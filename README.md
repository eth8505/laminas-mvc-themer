Eth8505\LaminasMvcThemer - Module for Theming Laminas\Mvc apps
==================================================================

The **eth8505/laminas-mvc-themer** module adds theming support to laminas-mvc apps.

## How to install

Install `eth8505/laminas-mvc-themer` package via composer.

~~~bash
$ composer require eth8505/laminas-mvc-themer
~~~

Load the module in your `application.config.php` file like so:

~~~php
<?php

return [
	'modules' => [
		'LaminasMvcThemer',
		// ...
	],
];
~~~

## How to use

### 1 Creating a theme
As described above, themes need to be registered with the theme plugin manager. A theme must implement the
`ThemeInterface`. All methods exept for `getName` may return an empty array. Check the `DefaultTheme` class
for an empty implementation of a theme specifying only a name.

#### 1.1 Specifying custom stylesheets
Implement the `getStylesheet` method in your theme, and return an array. Note that all paths will be pushed through
the `BasePath` view helper and hence must be relative to your `public/` directory.

~~~php
<?php

use LaminasMvcThemer\Theme\ThemeInterface;

class MyTheme implements ThemeInterface {
    // ...
    public function getStylesheets() : array {
        return [
            'css/theme/my/custom/file.css'
        ];
    }
    // ...
}
~~~

All stylesheets are injected using the `appendStylesheet` method of the `HeadLink` viewhelper.

#### 1.2 Specifying custom javascripts
Implement the `getScripts` method in your theme, and return an array. Note that all paths will be pushed through
the `BasePath` view helper and hence must be relative to your `public/` directory.

~~~php
<?php

use LaminasMvcThemer\Theme\ThemeInterface;

class MyTheme implements ThemeInterface {
    // ...
    public function getScripts() : array {
        return [
            'css/theme/my/custom/file.js'
        ];
    }
    // ...
}
~~~

All scripts are injected using the `prependFile` method of the `HeadScript` viewhelper.

#### 1.3 Specifying custom variables
Implement the `getVariables` method in your theme, and return an array. Note that all paths will be pushed through
the `BasePath` view helper and hence must be relative to your `public/` directory.

~~~php
<?php

use LaminasMvcThemer\Theme\ThemeInterface;

class MyTheme implements ThemeInterface {
    // ...
    public function getVariables() : array {
        return [
            'heading1' => 'one',
            'heading2' => [
                'key1' => 'test'
            ]
        ];
    }
    // ...
}
~~~

Theme variables are not automatically injected into your view models, as this could interfere with whatever you
set in your view models. However, the module provides a `theme()` view helper allowing access to the theme variables.

~~~php
<html>
    <body>
        <h1><?= $this->theme()->var('heading1') ?></h1>
        <h2><?= $this->theme()->var('heading2/key1') ?></h2>
    </body>
</html>
~~~

#### 1.4 Specifying custom meta tags
Meta tags are a little more complicated than scripts, styles or variables, as there are two basic types, `name` and
`http-equiv`. With this module, we use the same basic-syntax for both of them, specifying the `type` as a key in the
definition array.
To implement custom meta tags, implement get `getMetaTags` method in your theme.

~~~php
<?php

use LaminasMvcThemer\Theme\ThemeInterface;

class MyTheme implements ThemeInterface {
    // ...
    public function getMetaTags() : array {
        return [
            [
                'type' => 'name',
                'name' => 'robots',
                'content' => 'noindex,nofollow'
            ],
            [
                'type' => 'http-equiv',
                'name' => 'refresh',
                'content' => '30'
            ]
        ];
    }
    // ...
}
~~~

### 2. Register with service manager
You can either register your themes with the service manager via the config in your `module.config.php`:
~~~php
<?php

return [
    'laminas-mvc-themes' => [
        'invokables' => [
            MyTheme::class
        ]
    ]
];
~~~

or register it in your module class using the `ThemeProviderInterface`:
~~~php
<?php

namespace MyModule;

use LaminasMvcThemer\Theme\ThemeProviderInterface;

class Module implements ThemeProviderInterface {
    
    /**
     * @inheritdoc 
     */
    public function getThemeConfig() {

        return [
            'invokables' => [
                MyTheme::class
            ]
        ];
        
    }
    
}
~~~

### 3. Resolving themes
Per default, theme resolving is done using the `ConfigResolver` class, that simply checks the config 
`laminas-mvc-themer/resolver` config, and injects the theme as the `theme` service.

#### 3.1 Custom theme resolvers
In addition to the default config-based theme resolver, you can also specify a custom resolver class. This can be any
implementation of `ThemeResolverInterface` of your choosing, reading the theme from the session (if you want to provide
a selection of themes to your users).

Example implementation of a simple hostname-based theme resolver:

~~~php
<?php
namespace MyModule;

use LaminasMvcThemer\Resolver\ThemeResolverInterface;
use LaminasMvcThemer\Theme\ThemeInterface;
use LaminasMvcThemer\Theme\ThemePluginManager;
use Laminas\Http\Request;

class Module implements ThemeResolverInterface {

    private $request;
    
    private $pluginManager;

    public function __construct(Request $request, ThemePluginManager $pluginManager) {
        $this->request = $request;
        $this->pluginManager = $pluginManager;
    }

    public function resolve() : ThemeInterface  {
        
        if ($this->request->getUri()->getHost() === 'my.awesome.host') {
            $theme = ThemeOne::class;
        } else {
            $theme = ThemeTwo::class;
        }
        
        return $this->pluginManager->get($theme);
        
    }

}
~~~


