<?php

namespace Quintype\Seo;

require "Base.php";

class StoryElement extends Base
{
	function __construct($config, $pageType, $story, $element){
		$this->story = $story;
		$this->element = $element;
	}

	function prepareTags() {
		return [
			'title' => trim($this->story['headline']) . " - " . $this->config['title'],
    	'rel:canonical' => $this->getCanonicalUrl()
 		];
	}
}
