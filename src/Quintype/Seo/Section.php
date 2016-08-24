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
				'title' => $this->getTitle(),
	        	'description' => $this->seoMetadata['description'],
	        	'og' => [
	          		'title' => $this->seoMetadata['title'],
	          		'description' => $this->seoMetadata['description']
	        	],
		        'twitter' => [
		          'title' => $this->seoMetadata['title'],
		          'description' => $this->seoMetadata['description']
		        ]
		    ];
		} else {
			return ['title' => $this->getTitle()];
		}
	}

	private function getTitle(){
		if(isset($this->seoMetadata['page-title'])){
			return $this->seoMetadata['page-title'];
		} else {
			return $this->section . " - " . $this->config['title'];
		}
	}


}