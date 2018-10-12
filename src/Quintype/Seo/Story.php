<?php

namespace Quintype\Seo;

class Story extends Base
{
    public function __construct($config, $pageType, $story, $card = null)
    {
        parent::__construct($config, $pageType);
        $this->story = $story;
        $this->card = $card;
        $this->cardSocialShare = (isset($card) && isset($card['metadata']['social-share']['shareable']))? $card['metadata']['social-share'] : [];

    }

    public function prepareTags()
    {
        if (sizeof($this->story) > 0) {
            $allTags = [
                'title' => trim($this->getTitle()) . $this->titleTextToAppend,
			          'description' => trim($this->getDescription()),
			          'keywords' => trim($this->getKeywords(["stories" => $this->story])),
			          'news_keywords' => trim($this->getKeywords(["stories" => $this->story])),
                'image_src' => $this->getHeroImageUrl(),
			          'og' => !empty($this->cardSocialShare)? $this->getCardShareOgAttributes() : $this->getOgAttributes(),
				        'twitter' => !empty($this->cardSocialShare)? $this->getCardShareTwitterAttributes() :$this->getTwitterAttributes(),
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
            $standOutUrl = $this->getStandOutUrl();//Check if the story is marked as standout story.

            return $standOutUrl ? array_merge($allTags, $standOutUrl) : $allTags;
        } else {
            return ['title' => $this->getPageTitle()];
        }
    }

    protected function getDescription()
    {
        if(isset($this->story['seo']['meta-description'])&&($this->story['seo']['meta-description']!="")) {

            return $this->story['seo']['meta-description'];
        } elseif (isset($this->story['summary'])) {
            return $this->story['summary'];
        } else {
            return '';
        }
    }

   protected function getSocialDescription() {
    if(isset($this->story['summary'])) {
        return $this->story['summary'];
    } elseif (isset($this->story['seo']['meta-description'])&&($this->story['seo']['meta-description']!="")) {
        return $this->story['seo']['meta-description'];
    } else {
      return '';
    }
   }

    protected function getSectionName()
    {
        if (isset($this->story['sections'][0]['name'])) {
            return $this->story['sections'][0]['name'];
        } else {
            return '';
        }
    }

    protected function getTitle()
    {
        return !empty($this->story["seo"]["meta-title"])? $this->story["seo"]["meta-title"] : $this->story["headline"];
    }

    private function getOgAttributes()
    {
        $attributes = [
            'title' => trim($this->getTitle()),
			      'type' => 'article',
			      'url' => $this->getCanonicalUrl(),
			      'site-name' => trim($this->config['title']),
			      'description' => trim($this->getSocialDescription()),
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

    private function getCardShareOgAttributes()
    {
        $attributes = [
            'title' => isset($this->cardSocialShare["title"])? $this->cardSocialShare["title"] : trim($this->getTitle()),
            'type' => 'article',
            'url' => $this->getCanonicalUrl(). "/". $this->card['id'],
            'site-name' => trim($this->config['title']),
            'description' => isset($this->cardSocialShare["message"])? $this->cardSocialShare["message"] : trim($this->getSocialDescription()),
            'image' => isset($this->cardSocialShare["image"]) && isset($this->cardSocialShare['image']['key']) ? $this->getCardImageUrl() : $this->getHeroImageUrl(),
        ];

        if (isset($this->cardSocialShare['image']['metadata'])) {
            $imageProperties = [];
            if (isset($this->cardSocialShare['image']['metadata']['width'])) {
                $imageProperties['image:width'] = $this->cardSocialShare['image']['metadata']['width'];
            }
            if (isset($this->cardSocialShare['image']['metadata']['height'])) {
                $imageProperties['image:height'] = $this->cardSocialShare['image']['metadata']['height'];
            }
            $attributes = array_merge($attributes, $imageProperties);
        }


        return $attributes;
    }

    private function getCardShareTwitterAttributes()
    {
        $attributes = [
            'title' => isset($this->cardSocialShare["title"])? $this->cardSocialShare["title"] : trim($this->getTitle()),
            'description' => isset($this->cardSocialShare["message"])? $this->cardSocialShare["message"] : trim($this->getSocialDescription()),
            'card' => 'summary_large_image',
            'site' => $this->getTwitterSite(),
            'creator' => $this->getTwitterCreator(),
            'image' => [
                'src' => isset($this->cardSocialShare["image"])? $this->getCardImageUrl() : $this->getHeroImageUrl(),
            ],
        ];

        return $attributes;
    }

    private function getTwitterAttributes()
    {
        $attributes = [
            'title' => trim($this->getTitle()),
			      'description' => trim($this->getSocialDescription()),
			      'card' => 'summary_large_image',
			      'site' => $this->getTwitterSite(),
                  'creator' => $this->getTwitterCreator(),
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

    private function getTwitterCreator()
    {
        $creator = [];
        if ((isset($this->config['social-links']['twitter-url']))&&($this->config['social-links']['twitter-url'] !="")) {
            $creator = $this->config['social-links']['twitter-url'];
            $creator = explode('/', $creator);
            if(isset($creator[3]))
              return '@'.$creator[3];
            else
              return '';
        } else {
            return '';
        }
    }

    private function getPublisher()
    {
        if ((isset($this->config['social-links']['facebook-url']))&&($this->config['social-links']['facebook-url'] !="")) {
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
        return $this->getImageCDNUrl($this->story['hero-image-s3-key']);
    }

    private function getCardImageUrl()
    {
        return $this->getImageCDNUrl($this->cardSocialShare['image']['key']);
    }

    private function getImageCDNUrl($imageS3Key)
    {
        if (isset($this->config['cdn-name']) || isset($this->config['cdn-image'])) {
            $cdn = isset($this->config['cdn-image']) ? "https://".$this->config['cdn-image'] : $this->config['cdn-name'];
            $imageUrl = trim($cdn, '/').'/'.$imageS3Key;

            return str_replace(' ', '%20', $imageUrl).'?w=700';
        } else {
            return '';
        }
    }
}
