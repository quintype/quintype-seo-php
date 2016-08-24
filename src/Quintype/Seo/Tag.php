<?php

namespace Quintype\Seo;

require "Base.php";

class Tag extends Base {

	function __construct($config, $pageType, $tag){
		$this->config = $config;
		$this->tag = $tag;
	}

	function tags() {
			return ['title'=>$this->tag . " - " . $this->config['title']];
	}

}
