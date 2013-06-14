<?php

/**
 * PortalFire Framework
 *
 * Creates dynamic applications for rapid development.
 *
 * PHP versions 5.3.0 & up
 * MySQL versions 5.0.0 & up
 *
 * @category   Framework
 * @package    PortalFire
 * @author     Andrew Champ
 * @copyright  2011-2013 Andrew Champ
 * @license    The MIT License (MIT)
 * @version    1.0.0 RC
 * @link       https://github.com/AndrewChamp/portalfire-framework
 * @since      File available since Release 1.0.0
 * @deprecated n/a
 * @file       class.core.php
 *
 * The MIT License (MIT)
 * Copyright (c) 2013 Andrew Champ
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sub-license, 
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial 
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT 
 * LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
 * NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

	class core{
		
		public $configTable;
		public $page;
		public $header;
		public $body;
		public $footer;
		public $html;
		public $content;
		public $includes;
		public $table;
		public $upTimeMarker = '<!--upTimeMarker-->';
		public $error = false;
		
		private $crud;
		private $site = array();
		private $url;
		private static $instance;
		
	
		public function __construct($_crud=null, $_configTable=null, $_page){
			if($_crud==null)
				throw new Exception('You need the database connection argument for '.__CLASS__.' class.');
			
			$this->crud = $_crud;
			$this->configTable = $_configTable;
			$this->page = $_page;
			if($this->configTable != null)
				$this->defines();
			$this->page();
		}
		
		
		public static function obtain($_crud=null, $_configTable=null, $_page){
			if(!self::$instance)
				self::$instance = new core($_crud, $_configTable, $_page); 
			return self::$instance;
		}
		
		
		public function __get($name){
			if(isset($this->site[$name]) && $this->site[$name] != null)
				return $this->site[$name];
		}
		
		
		public function __set($name, $val){
			if(isset($this->site[$name]) && $this->site[$name] != null)
				$this->site[$name] = $val;
		}
		
		
		private function defines(){
			$config = $this->crud->query("SELECT config_key, config_value FROM ".$this->configTable);
			foreach($config as $z)
				define($z['config_key'], $z['config_value']);
		}
		
		
		private function url(){
			$pager = $this->sanitize($this->page);
			$doit = (empty($pager) ? '/' : $pager);
			$this->url = (substr($doit, -1) != '/' ? $doit.'/' : $doit);
		}
		
		
		private function load(){
			$this->url();
			try{
				if(strlen($this->url) > 1):
					$this->url = array_filter(explode('/', $this->url, 2));
					if(count($this->url) == 1):
						$x = $this->crud->query("SELECT * FROM ".TABLE_CONTENT." WHERE page = '".$this->url[0]."/' LIMIT 1");
					elseif($this->tableExist($this->url[0]) == true):
						$this->table = $this->url[0];
						$x = $this->crud->query("SELECT * FROM ".$this->url[0]." WHERE page = '".$this->url[1]."' LIMIT 1");
					endif;
				else:
					$x = $this->crud->query("SELECT * FROM ".TABLE_CONTENT." WHERE page = '".$this->url."' LIMIT 1");
				endif;
				
				if(empty($x))
					$x = $this->error404();
			}catch(Exception $e){
				$this->error_logging($e->getMessage());
			}
			
			$site = $x[0];
			$this->site = $site;
				
			foreach($site as $index => $v)
				$this->$index = $v;
			
			return true;
		}
		
		
		private function error_logging($message){
			print $message;
		}
		
		
		private function page(){
			$this->load();		
			$this->header = empty($this->header) ? INSTALL.THEME.'common/header.php' : INSTALL.THEME.'common/'.$this->header;
			$this->body = empty($this->body) ? INSTALL.THEME.'templates/main.php' : INSTALL.THEME.'templates/'.$this->body;
			$this->footer = empty($this->footer) ? INSTALL.THEME.'common/footer.php' : INSTALL.THEME.'common/'.$this->footer;
			$this->html = ALLOW_PHP ? $this->fixcodeblocks($this->html) : preg_replace(array('#<\?(?:php)?(.*?)\?>#s'), array(''), $this->html);
			$this->includes = empty($this->includes) ? false : INSTALL.THEME.'includes/'.$this->includes;
		}
		
		
		public function frame(){
			$debug = debug::obtain();
			$core = core::obtain();
			$crud = crud::obtain();
			$template = file_get_contents($this->body);
			$content = str_replace('[CONTENT]', $this->html, $template);
			if($this->includes):
				$includes = file_get_contents($this->includes);
				$content = str_replace('[INCLUDE]', $includes, $content);
			endif;
			if(preg_match('/<?/', $content)):
				$content = eval(" ?>" . $content . "<?php ");
			endif;
			return $content;
		}
		
		
		private function tableExist($table){
			if(!defined('TABLE_'.strtoupper($table)))
				return false;
			else
				return true;
		}
		

		private function error404(){
			$this->error = true;
			header("HTTP/1.0 404 Not Found");
			return $this->crud->query("SELECT * FROM ".TABLE_ERROR." WHERE error_code = '404' LIMIT 1");
		}
		
		
		public function canonical(){
			if(!$this->error)
				return (SITE_URL.'/'.($this->page != '/' ? (isset($this->table) ? $this->table.'/' : '').$this->page : ''));
		}
		
		
		public function sanitize($str){
			return filter_var($str, FILTER_SANITIZE_STRING);
		}
		
		
		private function fixcodeblocks($str){
			return preg_replace_callback('#<(code|pre)([^>]*)>(((?!</?\1).)*|(?R))*</\1>#si', 'specialchars', $str);
		}
		
	
	}

?>