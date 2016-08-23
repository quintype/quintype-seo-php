<?php

namespace Quintype\Seo;

require "Base.php";

class Home extends Base {

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
		        ],
		        'msvalidate.01' => $this->getBingId(),
		        'fb' => [
		          'app_id' => $this->getFacebookId()
		        ],
		        'alternate' => [
		          'href' => '/feed',
		          'type' => 'application/atom+xml',
		          'title' => "#{title} ATOM Feed"
		        ]
		    ];
		} else {
			return array();
		}
	}

	private function getTitle(){
		if(isset($this->seoMetadata['page-title'])){
			return $this->seoMetadata['page-title'];
		} else {
			$this->config['title'];
		}
	}

	private function getFacebookId(){
		if(isset($this->config['facebook'])){
			return $this->config['facebook']['app-id'];
		}
	}

	private function getBingId(){
		if(isset($this->config['integrations'])){
			if(isset($this->config['integrations']['bing'])){
				return $this->config['integrations']['bing']['app-id'];
			}
		}
	}

}
