<?php

namespace Quintype\Seo;

require "Base.php";

class Home extends Base {

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
		        ],
		        'msvalidate.01' => $this->getBingId(),
		        'fb' => [
		          'app_id' => $this->getFacebookData('app-id'),
		          'pages' => $this->getFacebookData('pages')
		        ],
		        'alternate' => [
		          'href' => '/feed',
		          'type' => 'application/atom+xml',
		          'title' => trim($this->getTitle() . " ATOM Feed"
		        ]
		    ];
		} else {
			return ['title' => trim($this->getTitle())];
		}
	}


}