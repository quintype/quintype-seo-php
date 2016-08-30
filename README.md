# quintype-seo-php
A composer package for seo for all quintype projects

Note : We are making use of a package called Meta (https://github.com/quintype/meta) forked from https://github.com/RyanNielson/meta for dynamically adding the meta tags into the pages.

Instructions to include the package into a project.

### In composer.json, add a repository pointing to the forked meta repository.
```sh
"repositories": [
        ...
        ...
        {
            "type": "vcs",
            "url": "https://github.com/quintype/meta"
        }
    ],
```

###  In composer.json, require the original Meta package and this seo package.
```sh
"require": {
        ...
        ...
        "quintype/seo":"0.0.5",
        "ryannielson/meta":"dev-master"
    },
```
###  In the Laravel config/app.php file, include Meta provider and give an alias to it.
```sh
'providers' => [
        ...
        ...
        RyanNielson\Meta\MetaServiceProvider::class
    ],
    
'aliases' => [
        ...
        ...
        'Meta' => RyanNielson\Meta\Meta::class
    ],
```

###  Add an attribute called 'title' in config/quintype.php file as a fall-back value if it is not recieved from the meta data.
```sh
return [
    ...
    ...
    "title" => "Pina Colada"
];
```

###  Install or update the composer packages.
```sh
$ composer install
or
$ composer update
```
###  Include both Meta and SEO classes in the necessary controllers.
```sh
use Meta;
use Quintype\Seo;
```
###  Create a constructor function to initialize the Meta object and config variable if necessary.
```sh
public function __construct(){
  parent::__construct();
  $this->meta = new Meta;
  $this->config = $this->client->config();
}
```
###  Prepare the data required for meta tags.
```sh
// Setting Seo meta tags
$page = ["type" => "home"];//Type of the page. In this case, it is the home page.
$home = new Seo\Home(array_merge($this->config, config('quintype')), $page["type"]);//Since it is the home page, initialize the Home object.
$this->meta->set($home->tags());//Set the tags received in the above step.
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
