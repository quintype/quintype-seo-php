<?php

namespace Quintype\Seo;

class Tag extends Base
{
	function __construct($config, $tag){
		parent::__construct($config);
		$this->tag = $tag;
	}

	function prepareTags() {
		return ['title'=>trim($this->tag) . $this->titleTextToAppend];
	}
}
