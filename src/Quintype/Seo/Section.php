<?php

namespace Quintype\Seo;

require "Base.php";

class Section extends Base {

	function __construct($config, $pageType, $section){
		parent::__construct($config, $pageType);
		$this->section = $section;
	}

	function tags() {
		if (sizeof($this->seoMetadata)>0){

			return [
				'title' => trim($this->getTitle()),
	        	'description' => trim($this->seoMetadata['description']),
	        	'og' => [
	          		'title' => trim($this->seoMetadata['title']),
	          		'description' => trim($this->seoMetadata['description'])
	        	],
		        'twitter' => [
		          'title' => trim($this->seoMetadata['title']),
		          'description' => trim($this->seoMetadata['description'])
		        ]
		    ];
		} else {
			return ['title' => trim($this->getTitle())];
		}
	}

	protected function getTitle(){
		if(isset($this->seoMetadata['page-title'])){
			return $this->seoMetadata['page-title'];
		} else {
			return $this->section . " - " . $this->config['title'];
		}
	}


}