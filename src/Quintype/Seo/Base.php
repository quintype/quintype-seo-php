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
}