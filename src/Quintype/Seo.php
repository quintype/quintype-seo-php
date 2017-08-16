<?php

namespace Quintype\Seo;

class Seo
{
  public function __construct($config){
    $this->config = $config;
  }
  public function home($pageType){
    return new Home($this->config, $pageType);
  }

  public function search($query){
    return new Search($query);
  }

  public function section($pageType, $sectionName, $sectionId){
    return new Section($this->config, $pageType, $sectionName, $sectionId);
  }

  public function staticPage($title){
    return new StaticPage($title);
  }

  public function story($pageType, $story){
    return new Story($this->config, $pageType, $story);
  }

  public function storyElement($pageType, $story, $element){
    return new StoryElement($this->config, $pageType, $story, $element);
  }

  public function tag($tag){
    return new Tag($this->config, $tag);
  }

  public function custom($customValues = []){
    return new Custom($this->config, $customValues);
  }
}
