<?php

namespace Quintype\Seo;

class Tag
{
	function __construct($config, $tag){
		$this->config = $config;
		$this->tag = $tag;
	}

	function prepareTags() {
		return ['title'=>trim($this->tag) . " - " . $this->config['title']];
	}
}
