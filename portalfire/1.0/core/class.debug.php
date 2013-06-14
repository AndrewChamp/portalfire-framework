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
 * @file       class.debug.php
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

/**
 * Please note that this class's methods & properties won't print to screen 
 * if your IP address isn't registered in the $development property array.
 * The class is instantiated in index.php in the website's root folder.
 */

	class debug{
	
		private static $instance;
	
		public $development = array(
			'Interlink'		=> '207.32.225.*',
			'WUBU FM'		=> '63.131.11.31',
			'Home'			=> '50.127.119.140',
			'Home'			=> '50.121.16.65'
		);
		public $ip;
		public $dev = false;
	
	
		public function __construct(){
			$this->ip = $_SERVER['REMOTE_ADDR'];
			$this->dev = $this->isDevIP($this->ip);
			$this->noCaching();
		}

		
		/**
		 * Singleton Pattern.
		 * Allows for reusing the initial instanited object.
		 */
		public static function obtain(){
			if(!self::$instance)
				self::$instance = new debug(); 
			return self::$instance; 
		}
		
		
		/**
		 * Development IP Check
		 * Checks if the user is using a development IP, for viewing debugging output.
		 */
		public function isDevIP($ip){
			if(in_array($ip, $this->development))
				return true;
			$octet2 = explode('.', $ip);
			foreach($this->development as $allowed):
				if(strpos($allowed,'*') !== false):
					$octet = explode('.', $allowed);
					foreach($octet as $index => $oct):
						if($oct == '*')
							return true;
						if($octet2[$index] != $oct)
							return false;
					endforeach;
				endif;
			endforeach;
			return false;
		}
		
		
		/**
		 * Checks for PHP version number.
		 */
		 public function versionCheck($version){
			if(version_compare(phpversion(), $version, '<='))
				throw new Exception('Your PHP version is v'.phpversion().', and needs to be above v'.$version.' in order for this framework to work properly.');
		}
		
		
		/**
		 * Prints an array.
		 */
		public function printArray($bugger){
			if($this->dev):
				$this->pre($bugger);
			endif;
		}
		
	
		/**
		 * Prints all the user defined defines.
		 */	
		public function allDefines(){
			if($this->dev):
				$defines = get_defined_constants(true);
				foreach($defines['user'] as $k => $v):
					$all .= $k.': '.$v."\n";
				endforeach;
				$this->pre($all);
			endif;
		}
		
		
		/**
		 * Displays all the properties in the class.
		 */
		public function allVars($class){
			if($this->dev):
				$this->pre(get_object_vars($class));
			endif;
		}
		
		
		/**
		 * Displays all the methods in the class.
		 */
		public function allMethods($class){
			if($this->dev):
				$this->pre(get_class_methods($class));
			endif;
		}
		
		
		/**
		 * Syntax highlights code to screen.
		 */
		public function highlighter($file){
			if($this->dev):
				if(file_exists($file)):
					$lines = implode(range(1, count(file($file)) + 3), '<br />');
					$content = highlight_file($file, true);
					print '<style type="text/css">
							#codeWrapper{}
							.codeNum{float:left; color:#666; text-align:right; margin-right:6px; padding-right:6px; border-right:1px solid #666; width:40px;}
							.codeNum, .codeContent{vertical-align:top; font-size:12px; font-family:monospace; /*background:#EEE; text-shadow:1px 1px 0 #FFF;*/ background:#111; text-shadow:1px 1px 0 #000; word-wrap:break-word;}
							#codeWrapper span[style="color: #0000BB"]{color:rgb(129, 230, 255)!important;}
							#codeWrapper span[style="color: #007700"]{color:rgb(0, 224, 0)!important;}
							#codeWrapper span[style="color: #FF8000"]{color:rgb(255, 143, 0)!important;}
							#codeWrapper span[style="color: #000000"]{color:rgb(255, 255, 255)!important;}
						</style>'; 
					print "<div id=\"codeWrapper\"><div class=\"codeNum\">\n$lines\n</div><div class=\"codeContent\">\n$content\n</div></div>";
				endif;
			endif;
		}
		
		
		/**
		 * Syntax highlight a php string.
		 */
		public function highlight($str){
			if($this->dev)
				return highlight_string($str);
		}
		
		
		/**
		 * Prevents caching when in Developer Mode.
		 */
		private function noCaching(){
			if($this->dev):
				header('Expires: Thu, 31 May 1984 08:00:00 EST');
				header('Cache-Control: no-store, no-cache, must-revalidate');
				header('Cache-Control: pre-check=0, post-check=0, max-age=0');
				header('Pragma: no-cache');
			endif;
		}
		
		
		/**
		 * Displays on screen when you're in developer mode.  
		 * Note: your IP has to be registered above to be in developer mode.
		 */
		private function developerMode(){
			if($this->dev):
				print '<div style="z-index:99999; top:0; right:0; background:#000; box-shadow:0 0 10px #000; border-left:1px solid #666; border-bottom:1px solid #666; border-radius:0 0 0 7px; position:fixed; color:#FFF; padding:5px 10px; font-size:14px;">Developer Mode</div>';
			endif;
		}
		
		
		/**
		 * Formats the array by putting the 'pre' tags around it.
		 */
		private function pre($array){
			print '<pre>';
			print_r($array);
			print '</pre>';
		}
		
		
		/**
		 * Prints to screen all the php files that make up the framework.
		 * Example of directories it will scan and return the files in are 'core', 'modules', & 'crons'.
		 * Helps by reference in using properties and methods when developing apps.
		 */
		public function debugBar(){
			if($this->dev):
				$this->developerMode();
				print '<style>
					#debugBar{width:100%; background:#000; border-bottom:1px solid #666; border-top:1px solid #666; clear:both; overflow:hidden; box-shadow:0 0 20px #000, 0 0 20px #000; text-align:center;}
					#debugBar li{display:inline;}
					#debugBar li a{padding:5px 10px; color:rgb(255, 143, 0);}
				</style>';
				$result = '<ul id="debugBar">';
				foreach(glob(PATH.VERSION.'/*/*.php') as $file):
					$result .= '<li><a href="?output='.$file.'#debugBar">'.basename($file).'</a></li>';
				endforeach;
				print $result.'</ul>';
				$this->highlighter($_GET['output']);
			endif;
		}
		
	
	}

?>