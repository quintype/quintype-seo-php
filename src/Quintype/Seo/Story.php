<?php

namespace Quintype\Seo;

require "Base.php";

class Story extends Base {

	function __construct($config, $pageType, $story){
		$this->config = $config;
		$this->story = $story;
	}

	function tags() {

		if (sizeof($this->story)>0){

			return [
				'title' => $this->getTitle(),
	        	'description' => $this->story['summary'],
	        	'og' => $this->getOgAttributes(),
		        'twitter' => $this->getTwitterAttributes(),
		        'msvalidate.01' => $this->getBingId(),
		        'fb' => [
		          'app_id' => $this->getFacebookId()
		        ],
		        // 'alternate' => [
		        //   'href' => '/feed',
		        //   'type' => 'application/atom+xml',
		        //   'title' => "#{title} ATOM Feed"
		        // ]
		    ];
		} else {
			return ['title' => $this->getTitle()];
		}
	}

	private function getOgAttributes(){
		$attributes = [
			'title' => $this->story['headline'],
	        'type' => 'article',
	        // 'url' => '******** Canonical URL here ********',
	        'site_name' => $this->config['title'],
	        'description' => $this->story['summary'],
	        // 'image' => '******** Image URL ********'
        ];

        return $attributes;
	}

	private function getTwitterAttributes(){
		$attributes = [
			'title' => $this->story['headline'],
	        'description' => $this->story['summary'],
	        'card' => 'summary_large_image',
	        // 'site' => '******** Twitter Credentials ********',
	        'image' => [
	          // 'src' => '******** hero_image_url ********'
	        ]
		];

		return $attributes;
	}

	private function getTitle(){
		if(isset($this->seoMetadata['page-title'])){
			return $this->seoMetadata['page-title'];
		} else {
			return $this->config['title'];
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