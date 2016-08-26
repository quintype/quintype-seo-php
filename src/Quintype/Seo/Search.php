<?php

namespace Quintype\Seo;

require "Base.php";

class Search extends Base {

	function __construct($config, $pageType, $query){
		$this->query = $query;
	}

	function tags() {
			return ['title' => trim($this->query) ." - Search Results"];
	}

}
