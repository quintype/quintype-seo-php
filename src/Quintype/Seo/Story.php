<?php

namespace Quintype\Seo;

require "Base.php";

class Story extends Base {

	function __construct($config, $pageType, $story){
		parent::__construct($config, $pageType);
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
		          'app-id' => $this->getFacebookId()
		        ],
		        'article' => [
		          'publisher' => $this->getPublisher()
		        ],
		        'rel:canonical' => $this->getCanonicalUrl(),
		        'al:android:package' => $this->getPublisher('al:android:package'),
		        'al:android:app-name' => $this->getPublisher('al:android:app-name'),
		        'al:android:url' => "quintypefb://" . $this->config['sketches-host'] . "/". $this->story['slug']
		    ];
		} else {
			return ['title' => $this->getTitle()];
		}
	}

	private function getOgAttributes(){
		$attributes = [
			'title' => $this->story['headline'],
	        'type' => 'article',
	        'url' => $this->getCanonicalUrl(),
	        'site-name' => $this->config['title'],
	        'description' => $this->story['summary'],
	        'image' => $this->getHeroImageUrl()
        ];

        if(isset($this->story['hero-image-metadata'])){

        	$imageProperties=[];

        	if(isset($this->story['hero-image-metadata']['width'])){
        		$imageProperties['image:width']=$this->story['hero-image-metadata']['width'];
        	}

        	if(isset($this->story['hero-image-metadata']['height'])){
        		$imageProperties['image:height']=$this->story['hero-image-metadata']['height'];
        	}

        	$attributes = array_merge($attributes, $imageProperties);
        }

        return $attributes;
	}

	private function getTwitterAttributes(){
		$attributes = [
			'title' => $this->story['headline'],
	        'description' => $this->story['summary'],
	        'card' => 'summary-large-image',
	        'site' => $this->getTwitterSite(),
	        'image' => [
	          'src' => $this->getHeroImageUrl()
	        ]
		];

		return $attributes;
	}

	private function getTwitterSite(){
		if(isset($this->config['social-app-credentials'])){
			if(isset($this->config['social-app-credentials']['twitter'])){
				return $this->config['social-app-credentials']['twitter']['username'];
			}
		}
	}

	private function getPublisher(){
		if(isset($this->config['social-links'])){
			return $this->config['social-links']['facebook-url'];
		}
	}

	private function getAndroidData($element){
		if(isset($this->config['apps-data'])){
			return $this->config['apps-data'][$element];
		}
	}

	private function getHeroImageUrl(){
		 if(isset($this->config['cdn-name']) && isset($this->story['hero-image-s3-key'])){
		 	$imageUrl = $this->config['cdn-name'].$this->story['hero-image-s3-key'];
		 	return str_replace(" ", "%20", $imageUrl);
		 }else{
		 	return '';
		 }
	}



}