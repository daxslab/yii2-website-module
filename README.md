Yii2 Website Module
===================

[![Latest Stable Version](https://poser.pugx.org/daxslab/yii2-website-module/v/stable.svg)](https://packagist.org/packages/daxslab/yii2-website-module)
[![Total Downloads](https://poser.pugx.org/daxslab/yii2-website-module/downloads)](https://packagist.org/packages/daxslab/yii2-website-module)
[![Latest Unstable Version](https://poser.pugx.org/daxslab/yii2-website-module/v/unstable.svg)](https://packagist.org/packages/daxslab/yii2-website-module)
[![License](https://poser.pugx.org/daxslab/yii2-website-module/license.svg)](https://packagist.org/packages/daxslab/yii2-website-module)

Yii2 module to implement a website.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist daxslab/yii2-website-module "*"
```

or add

```
"daxslab/yii2-website-module": "*"
```

to the require section of your `composer.json` file.

Introduction
------------

Website tries to be an unobstrusive CMS without limiting the capabilities of Yii2 framework as development platform. The idea is that you can website features to an existing application, or just created a website based on Yii2 framework.

The idea behind **Website** module is a bit different compared with other CMS. While generally pages, posts and categories are managed, in **Website** everything is a page and every page can have children pages so,

- a page without subpages can be considered a regular _page_
- a page with subpages can be considered a _category_
- a subpage can be considered a _post_

The resulting tree can then have wathever depth is required. 

Besides pages, **Website** also manages Media: any attached file that can be referenced in the resulting website. The module handles the uploading process.

Also you can manage Menus with **Website** module. For every menu you can create menu items and this than be pointed to any URL. When creating a menu item you either type the label and URL, or select from existing pages.

Configuration
-------------

Website is meant to be used with the Yii2 Advanced Application template. Some modification could be done to make it usable with basic template.

### Module

First configure the module for all the apps in common/config/main.php

	//...
	'modules' => [
		'website' => [
			'class' => daxslab\website\Module::class,
			'languages' => ['en', 'es', 'it'],
			'token' => 'some-string-here'
		]
	]
	//...

Here notice the specified attributes:
- languages: array with the languages that will be active for creating content
- token: string identifying every website in case that several are used. 

### Database

It is assumed that you are using some database and that the connection to it it's already set. Configure migrations in console/config/main.php

    //...
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'daxslab\website\migrations',
            ]
        ],
    ],
    //...

### Controllers

Configure controllers namespaces for the module in each app. Let's start with frontend/config/main.php

	//...
	'modules' => [
		'website' => [
			'controllerNamespace' => 'website\daxslab\controllers\frontend'
		]
	]
	//...

And similar for backend/config/main.php

	//...
	'modules' => [
		'website' => [
			'controllerNamespace' => 'website\daxslab\controllers\backend'
		]
	
	]
	//...

Usage
-----

The module provides two sets of controllers: frontend and backend.
