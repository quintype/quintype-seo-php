<?php

namespace Quintype\Seo;

class Story extends Base
{
    public function __construct($config, $pageType, $story)
    {
        parent::__construct($config, $pageType);
        $this->story = $story;
    }

    public function prepareTags()
    {
        if (sizeof($this->story) > 0) {
            return [
                'title' => trim($this->getTitle()),
			          'description' => trim($this->getDescription()),
			          'keywords' => trim($this->getKeywords()),
			          'og' => $this->getOgAttributes(),
				        'twitter' => $this->getTwitterAttributes(),
				        'msvalidate.01' => $this->getBingId(),
				        'fb' => [
				          'app_id' => $this->getFacebookData('app-id'),
				          'pages' => $this->getFacebookData('pages'),
				        ],
				        'article' => [
				          'publisher' => $this->getPublisher(),
				        ],
				        'rel:canonical' => $this->getCanonicalUrl(),
				        'al:android:package' => $this->getAndroidData('al:android:package'),
				        'al:android:app-name' => $this->getAndroidData('al:android:app-name'),
				        'al:android:url' => 'quintypefb://'.$this->config['sketches-host'].'/'.$this->story['slug'],
		        ];
        } else {
            return ['title' => $this->getPageTitle()];
        }
    }

    protected function getDescription()
    {
        if (isset($this->story['summary'])) {
            return $this->story['summary'];
        } else {
            return '';
        }
    }

    protected function getTitle()
    {
        if (isset($this->story['headline'])) {
            return $this->story['headline'];
        } else {
            return $this->config['title'];
        }
    }

    private function getOgAttributes()
    {
        $attributes = [
            'title' => trim($this->getTitle()),
			      'type' => 'article',
			      'url' => $this->getCanonicalUrl(),
			      'site-name' => trim($this->config['title']),
			      'description' => trim($this->getDescription()),
			      'image' => $this->getHeroImageUrl(),
    ];

        if (isset($this->story['hero-image-metadata'])) {
            $imageProperties = [];
            if (isset($this->story['hero-image-metadata']['width'])) {
                $imageProperties['image:width'] = $this->story['hero-image-metadata']['width'];
            }
            if (isset($this->story['hero-image-metadata']['height'])) {
                $imageProperties['image:height'] = $this->story['hero-image-metadata']['height'];
            }
            $attributes = array_merge($attributes, $imageProperties);
        }

        return $attributes;
    }

    private function getTwitterAttributes()
    {
        $attributes = [
            'title' => trim($this->getTitle()),
			      'description' => trim($this->getDescription()),
			      'card' => 'summary_large_image',
			      'site' => $this->getTwitterSite(),
			      'image' => [
			        'src' => $this->getHeroImageUrl(),
			      ],
        ];

        return $attributes;
    }

    private function getTwitterSite()
    {
        if (isset($this->config['social-app-credentials'])) {
            if (isset($this->config['social-app-credentials']['twitter'])) {
                return $this->config['social-app-credentials']['twitter']['username'];
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    private function getPublisher()
    {
        if (isset($this->config['social-links'])) {
            return $this->config['social-links']['facebook-url'];
        }
    }

    private function getAndroidData($element)
    {
        if (isset($this->config['apps-data'])) {
            if (isset($this->config['apps-data'][$element])) {
                return $this->config['apps-data'][$element];
            }
        }
    }

    private function getHeroImageUrl()
    {
        if (isset($this->config['cdn-name']) || isset($this->config['cdn-image'])) {
            $cdn = isset($this->config['cdn-image']) ? "https://".$this->config['cdn-image'] : $this->config['cdn-name'];
            $imageUrl = trim($cdn, '/').'/'.$this->story['hero-image-s3-key'];

            return str_replace(' ', '%20', $imageUrl);
        } else {
            return '';
        }
    }
}
