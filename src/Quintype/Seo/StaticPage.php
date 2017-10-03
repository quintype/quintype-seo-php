<?php

namespace Quintype\Seo;

class StaticPage extends Base
{
	function __construct($config, $title){
		parent::__construct($config);
		$this->title = $title;
	}

	function prepareTags() {
		return ['title' => trim($this->title) . $this->titleTextToAppend];
	}
}
