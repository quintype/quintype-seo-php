# quintype-seo-php
A composer package for SEO for all quintype projects

###Important : If any change is made to the package, do the following.
* Create a new release.
* Update the package in [Packagist](https://packagist.org/).
* To use the new version of the package in any project, change the version number in composer.json file and run
``` $ composer update ```

Note : We are making use of a package called Meta (https://github.com/quintype/meta) forked from https://github.com/RyanNielson/meta for dynamically adding the meta tags into the pages.

Instructions to include the package into a project.

###  In composer.json, require Meta and SEO packages.
```sh
"require": {
        ...
        ...
        "quintype/seo":"1.0.0",
        "quintype/meta":"2.0.0"
    },
```

###  Install or update the composer packages.
```sh
$ composer install
or
$ composer update
```

###  In the Laravel config/app.php file, add aliases to the packages for convenience.
```sh
'aliases' => [
        ...
        ...
        'Meta' => Quintype\Meta\Meta::class,
        'Seo' => Quintype\Seo\Seo::class
    ],
```

###  Add an attribute called 'title' in config/quintype.php file as a fall-back value if it is not received from the meta data.
```sh
return [
    ...
    ...
    "title" => "Pina Colada"
];
```

###  Include both Meta and SEO classes in the necessary controllers.
```sh
use Meta;
use Seo;
```

###  Create a constructor function to initialize the Meta and SEO objects. Note: Do not forget to pass the config(merge local config and config from API response) to SEO package.
```sh
public function __construct(){
  $this->client = new Api(config("quintype.api-host"));
  $this->config = array_merge($this->client->config(), config('quintype'));
  $this->meta = new Meta();
  $this->seo = new Seo($this->config);
}
```
###  Prepare the data required for meta tags.
```sh

$page = ["type" => PAGE_TYPE];//eg. home, section, story etc.
//Set SEO meta tags.
$setSeo = $this->seo->FUNCTION_CORRESPONDING_TO_PAGE(ARGUMENTS);//eg. home($arguments), section($arguments), story($arguments) etc.
$this->meta->set($setSeo->prepareTags());
```

###  In the function to render the view, include the meta data.
```sh
return view('home', $this->toView([
      ...
      ...
      "meta" => $this->meta
    ])
  );
```

###  In the layout.twig file(or the container template twig file of the project), call the function to add the meta tags.
```sh
{{ meta.display([], true)|raw }}
```
