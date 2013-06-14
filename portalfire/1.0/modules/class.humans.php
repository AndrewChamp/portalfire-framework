<?php

/**
 * @File:    class.humans.php
 * @Author:  Andrew Champ
 */
 
	class humans{
	
	
		private $siteName;
		private $siteUrl;
		private $buildDate;
		private $version;
		private $template;
		private $fileName = 'humans.txt';
		private $templateDir = '/templates/';
		
		
		public function __construct($_siteName, $_siteUrl, $_buildDate, $_version, $_siteNotes=null){
			$this->siteName = $_siteName;
			$this->siteUrl = $_siteUrl;
			$this->buildDate = $_buildDate;
			$this->version = $_version;
			$this->siteNotes = $_siteNotes;
			
			if(!file_exists($this->fileName) || filemtime($this->fileName) < filemtime(PATH.VERSION.$this->templateDir.$this->fileName)):
				$this->loadTemplate();
				$this->replace();
			endif;
		}

		
		private function loadTemplate(){
			$this->template = file_get_contents(PATH.VERSION.$this->templateDir.$this->fileName);
		}
		
		
		private function replace(){
			$search = array(
				'[SITE_NAME]',
				'[SITE_URL]',
				'[BUILD_DATE]',
				'[VERSION]',
				'[SITE_NOTES]'
			);
			$replace = array(
				$this->siteName,
				$this->siteUrl,
				$this->buildDate,
				$this->version,
				$this->siteNotes
			);
			$results = str_replace($search, $replace, $this->template);
			file_put_contents($this->fileName, $results);
		}
	
	
	}

?>