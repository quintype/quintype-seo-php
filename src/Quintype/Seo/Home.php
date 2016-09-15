<?php

namespace Quintype\Seo;

require "Base.php";

class Home extends Base {

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
		        ],
		        'msvalidate.01' => $this->getBingId(),
		        'fb' => [
		          'app_id' => $this->getFacebookData('app-id'),
		          'pages' => $this->getFacebookData('pages')
		        ],
		        'alternate' => [
		          'href' => '/feed',
		          'type' => 'application/atom+xml',
		          'title' => trim($this->getPageTitle()) . " ATOM Feed"
		        ]
		    ];
		} else {
			return ['title' => trim($this->getPageTitle())];
		}
	}


}