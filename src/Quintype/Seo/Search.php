<?php

namespace Quintype\Seo;

class Search
{
	function __construct($query){
		$this->query = $query;
	}

	function prepareTags() {
		return ['title' => trim($this->query) ." - Search Results"];
	}
}
