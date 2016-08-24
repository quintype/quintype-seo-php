<?php

namespace Quintype\Seo;

require "Base.php";

class StaticPage extends Base {

	function __construct($config, $pageType, $title){
		$this->title = $title;
	}

	function tags() {
			return ['title' => $this->title];
	}

}
