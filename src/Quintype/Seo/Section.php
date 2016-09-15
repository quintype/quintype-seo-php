<?php

namespace Quintype\Seo;

require "Base.php";

class Section extends Base {

	function __construct($config, $pageType, $section, $section_id = ''){
		parent::__construct($config, $pageType, $section_id);
		$this->section = $section;
	}

	function tags() {
		if (sizeof($this->seoMetadata)>0){

			return [
				'title' => trim($this->getPageTitle()),
	        	'description' => trim($this->getDescription()),
	        	'keywords' => trim($this->getKeywords()),
	        	'og' => [
	          		'title' => trim($this->getTitle()),
	          		'description' => trim($this->getDescription())
	        	],
		        'twitter' => [
		          'title' => trim($this->getTitle()),
		          'description' => trim($this->getDescription())
		        ]
		    ];
		} else {
			return ['title' => trim($this->getPageTitle())];
		}
	}

	protected function getPageTitle(){
		if(isset($this->seoMetadata['page-title'])){
			if($this->seoMetadata['page-title']==''){
				return $this->section . " - " . $this->config['title'];
			}else{
				return $this->seoMetadata['page-title'];
			}
		} else {
			return $this->section . " - " . $this->config['title'];
		}
	}


}