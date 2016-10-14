<?php

namespace Quintype\Seo;

class Section extends Base
{
	function __construct($config, $pageType, $sectionName, $sectionId){
		parent::__construct($config, $pageType, $sectionId);
		$this->sectionName = $sectionName;
	}

	function prepareTags() {
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
				return $this->sectionName . " - " . $this->config['title'];
			}else{
				return $this->seoMetadata['page-title'];
			}
		} else {
			return $this->sectionName . " - " . $this->config['title'];
		}
	}
}
