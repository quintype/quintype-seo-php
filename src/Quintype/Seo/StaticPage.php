<?php

namespace Quintype\Seo;

class StaticPage extends Base
{
	function __construct($title){
		$this->title = $title;
	}

	function prepareTags() {
		return ['title' => trim($this->title)];
	}
}
