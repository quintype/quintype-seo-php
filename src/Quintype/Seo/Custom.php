<?php

namespace Quintype\Seo;

class Custom
{
	function __construct($config, $customValues){
		$this->config = $config;
		$this->customValues = $customValues;
	}

	function prepareTags() {
		$customMetatags = [];
		foreach ($this->customValues as $key => $value) {
			$customMetatags[$key] = $value;
		}
		return $customMetatags;
	}
}
