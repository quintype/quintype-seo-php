<?php

namespace Quintype\Seo;

class Search extends Base
{
	function __construct($config, $query){
		parent::__construct($config);
		$this->query = $query;
	}

	function prepareTags() {
		return ['title' => "Search results for " . trim($this->query) . $this->titleTextToAppend];
	}
}
