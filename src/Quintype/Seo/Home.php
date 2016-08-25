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
			return ['title' => $this->getTitle()];
		}
	}


}