<?php

namespace Quintype\Seo;

class Base {
	function __construct($config, $pageType, $sectionId = ''){
		$this->config = $config;
		$this->pageType = $pageType;
		$this->sectionId = $sectionId;
		$this->seoMetadata = $this->getSeoMetadata();
	}

	private function getSeoMetadata() {
		if(sizeof($this->config['seo-metadata'])>0){
			$key = 'owner-type';
			$found = 0;

			if($this->pageType == 'section'){//If it is a section page.
				foreach ($this->config['seo-metadata'] as $metadata) {
	        if (array_key_exists($key, $metadata) && $metadata[$key]==$this->pageType && $metadata['owner-id']==$this->sectionId) {
	        	$found = 1;
            return $metadata['data'];
	        }
				}
				if(!$found){
					return array();
				}
			} else {
				foreach ($this->config['seo-metadata'] as $metadata) {
	        if (array_key_exists($key, $metadata) && $metadata[$key]==$this->pageType) {
	        	$found = 1;
            return $metadata['data'];
	        }
				}
				if(!$found){
					return array();
				}
			}

		} else {
			return array();
		}

	}

	protected function getPageTitle(){
		if(isset($this->seoMetadata['page-title'])){
			return $this->seoMetadata['page-title'];
		} else {
			return $this->config['title'];
		}
	}

	protected function getTitle(){
		if(isset($this->seoMetadata['title'])){
			return $this->seoMetadata['title'];
		} else {
			return $this->config['title'];
		}
	}

	protected function getDescription(){
		if(isset($this->seoMetadata['description'])){
			return $this->seoMetadata['description'];
		} else {
			return '';
		}
	}

	protected function getKeywords($params = []){
		$keywords = '';
		if(isset($this->seoMetadata['keywords'])){
			$keywords = $this->seoMetadata['keywords'];
		} else {
			if(isset($params['stories'])){
				$keywordsArray = [];
				if(isset($this->story['seo']['meta-keywords']) && !empty($this->story['seo']['meta-keywords'][0])) {
					$keywordsArray = $this->story['seo']['meta-keywords'];
					$keywords = implode($keywordsArray, ',');
				} else {
					foreach ($params['stories']['tags'] as $key => $value) {
						array_push($keywordsArray, $value['name']);
					}
					$keywords = implode($keywordsArray, ',');	
				}
			}
		}
		return $keywords;
	}

	protected function getFacebookData($key){
		if(isset($this->config['facebook'])){
			if(isset($this->config['facebook'][$key])){
				return $this->config['facebook'][$key];
			}
		}
	}

	protected function getBingId(){
		if(isset($this->config['integrations'])){
			if(isset($this->config['integrations']['bing'])){
				if(isset($this->config['integrations']['bing']['app-id'])){
					return $this->config['integrations']['bing']['app-id'];
				}
			}
		}
	}

	protected function getCanonicalUrl(){
		if(isset($this->story['canonical_url'])){
			return $this->story['canonical_url'];
		} else {
			return $this->config['sketches-host'] . "/". $this->story['slug'];
		}
	}

	protected function getAlternateUrl(){
		if(isset($this->config['android-package']) && $this->config['android-package'] !== ''){
			$split_host_and_protocol = explode("://", $this->config['sketches-host']);
			if(sizeof($split_host_and_protocol) >= 2){
				return $this->config['android-package']. "/" . $split_host_and_protocol[0] . "/" . $split_host_and_protocol[1] . "/" . $this->story['slug'];
			}
			return $this->config['sketches-host'] . "/". $this->story['slug'];
		}
		return $this->config['sketches-host'] . "/". $this->story['slug'];
	}
}
