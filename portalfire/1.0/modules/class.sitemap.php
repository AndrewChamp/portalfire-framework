<?php

/**
 * @File:    class.sitemap.php
 * @Author:  Andrew Champ
 */
 
	class sitemap{
		
		
		public $crud;
		public $table;
		public $site;
		public $url;
		public $description;
		
		private static $instance;
		
	
		public function __construct($_crud=null, $_site=null, $_url=null, $_description){
			if($_crud == null)
				throw new Exception('Missing database connection for '.__CLASS__);
			if($_site == null)
				throw new Exception('Missing Site Name for '.__CLASS__);
			if($_url == null)
				throw new Exception('Missing URL / domain for '.__CLASS__);			
			
			$this->crud = $_crud;
			$this->site = $_site;
			$this->url = $_url;
			$this->description = $_description;
		}
		
		
		public static function obtain($_crud=null, $_site=null, $_url=null, $_description){
			if(!self::$instance)
				self::$instance = new sitemap($_crud, $_site, $_url, $_description);
			return self::$instance;
		}
		
		
		public function build($table, $where=null, $time=10800){
			if(!file_exists(INSTALL.'/'.$table.'.xml') || (time() - filemtime(INSTALL.'/'.$table.'.xml')) > $time):
				$data = '<?xml version="1.0"?>
				<rss version="2.0">
						<channel>
							<title>'.$this->site.'</title>
							<link>'.$this->url.'/</link>
							<description>'.$this->description.'</description>
							<language>en-us</language>';
				$doit = $this->crud->query("SELECT * FROM ".$table." ".($where != null ? "WHERE ".$where : ''));
				foreach($doit as $x):
					$data .= "\n\t\t\t\t".'<item>
						<title>'.$x['title'].'</title>
							<link>'.$this->url.'/'.($table != 'content' ? $table.'/' : '').($x['page'] != '/' ? $x['page'] : '').'</link>
							<description>'.$x['description'].'</description>
						</item>'; 
				endforeach;
				$data .= '
						</channel>
					</rss>';	
				file_put_contents(INSTALL.'/sitemaps/'.$table.'.xml', $data);
			endif;
		}
		
		
		public function robots($more=null){
			if(!file_exists(INSTALL.'/robots.txt') || time() - filemtime(INSTALL.'/robots.txt') > 10800):
				$data = "User-agent: * \n";
				foreach(glob(INSTALL.'/sitemaps/'.'*.xml') as $sitemap):
					$data .= 'Sitemap: '.$this->url.'/sitemaps/'.basename($sitemap)."\n";
				endforeach;
				$data .= $more;
				file_put_contents(INSTALL.'/robots.txt', $data);
			endif;
		}
	

	}

?>