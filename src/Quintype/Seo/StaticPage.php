<?php

namespace Quintype\Seo;

require "Base.php";

class StaticPage extends Base {

	function __construct($title){
		$this->title = $title;
	}

	function tags() {
			return ['title' => trim($this->title)];
	}

}
