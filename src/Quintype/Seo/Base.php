<?php

namespace Quintype\Seo;

class Base {
	function __construct($config, $pageType){
		$this->config = $config;
		$this->pageType = $pageType;
		$this->seoMetadata = $this->getSeoMetadata();
	}

	private function getSeoMetadata() {

		if(sizeof($this->config['seo-metadata'])>0){
			$key = 'owner-type';
			foreach ($this->config['seo-metadata'] as $metadata) {
		        if (array_key_exists($key, $metadata) && $metadata[$key]==$this->pageType) {
		            return $metadata['data'];
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
}