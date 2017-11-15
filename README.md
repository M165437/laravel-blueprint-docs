![Blueprint Docs](https://i.imgur.com/m6Abbmc.png)

<p align="center">
    <a href="https://packagist.org/packages/m165437/laravel-blueprint-docs"><img src="https://poser.pugx.org/m165437/laravel-blueprint-docs/v/stable" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/m165437/laravel-blueprint-docs"><img src="https://poser.pugx.org/m165437/laravel-blueprint-docs/downloads" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/m165437/laravel-blueprint-docs"><img src="https://poser.pugx.org/m165437/laravel-blueprint-docs/v/unstable" alt="Latest Unstable Version"></a>
    <a href="https://packagist.org/packages/m165437/laravel-blueprint-docs"><img src="https://poser.pugx.org/m165437/laravel-blueprint-docs/license" alt="License"></a>
    <a href="http://twitter.com/M165437"><img src="https://img.shields.io/badge/twitter-@M165437-blue.svg?style=flat&colorB=00aced" alt="Twitter"></a>
</p>

# API Blueprint Renderer for Laravel

This Laravel package *Blueprint Docs* renders your [API Blueprint](http://apiblueprint.org/). It comes with a standard theme that you can customize via Blade templates. Install the package and find your rendered documentation at route `/api-documentation`.

**Example output**: If used with [API Blueprint boilerplate](https://github.com/jsynowiec/api-blueprint-boilerplate), this would be [*Blueprint Docs'* output](https://m165437.github.io/laravel-blueprint-docs).

API Blueprint is a Markdown-based document format that lets you write API descriptions and documentation in a simple and straightforward way. Currently supported is [API Blueprint format 1A](https://github.com/apiaryio/api-blueprint/blob/master/API%20Blueprint%20Specification.md).

## Requirements

* Laravel 5.4 or greater
* Drafter (the official C++ API Blueprint parser) [command line tool](https://github.com/apiaryio/drafter#drafter-command-line-tool)
* A valid API Blueprint `blueprint.apib` in the root directory of your Laravel project (example available)

**Drafter is not included** and must be installed beforehand. Use the [Drafter Installer](https://github.com/hendrikmaus/drafter-installer) composer package to "install drafter in your php project with ease". Head over there and install it now.

## Installation

Install the package via composer:

``` bash
composer require m165437/laravel-blueprint-docs
```

Next, register its service provider (Laravel >= 5.5 does this automatically via [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery)):

```php
// config/app.php
'providers' => [
    ...
    M165437\BlueprintDocs\BlueprintDocsServiceProvider::class,
];
```

Optionally, publish the example [API Blueprint boilerplate](https://github.com/jsynowiec/api-blueprint-boilerplate) file `blueprint.apib` to the root directory of your Laravel project:

```bash
php artisan vendor:publish --provider="M165437\BlueprintDocs\BlueprintDocsServiceProvider" --tag="example"
```

Finally, publish its assets to `public/vendor/blueprintdocs`:

```bash
php artisan vendor:publish --provider="M165437\BlueprintDocs\BlueprintDocsServiceProvider" --tag="public"
```

Find your documentation at route `/api-documentation`.

## Configuration

To adjust Blueprint Docs' configuration, publish its config file to `config/blueprintdocs.php`:

``` bash
php artisan vendor:publish --provider="M165437\BlueprintDocs\BlueprintDocsServiceProvider" --tag="config"
```

The default contents of the configuration file looks like this:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Blueprint Docs
    |--------------------------------------------------------------------------
    |
    | Find your rendered docs at the given route or set route to false if you
    | want to use your own route and controller. Provide a fully qualified
    | path to your API blueprint as well as to the required Drafter CLI.
    |
    */

    'route' => 'api-documentation',

    'blueprint_file' => base_path('blueprint.apib'),

    'drafter' => base_path('vendor/bin/drafter')

];
```

If you want to use Blueprint Docs with your own route and controller, set `'route' => false` and have a look at `vendor/m165437/laravel-blueprint-docs/src/BlueprintDocsController.php` to get an idea on how to set it up.

## Theming

To customize the default theme, publish its views to `views/vendor/blueprintdocs`:

``` bash
php artisan vendor:publish --provider="M165437\BlueprintDocs\BlueprintDocsServiceProvider" --tag="views"
```

## Contributing

Thank you for considering contributing to this package! Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

This package relies heavily on work done by [Hendrik Maus](https://github.com/hendrikmaus), namely his [Drafter PHP Wrapper](https://github.com/hendrikmaus/drafter-php) and [Reynaldo](https://github.com/hendrikmaus/reynaldo), it's inspired by [Aglio](https://github.com/danielgtaylor/aglio), an API Blueprint renderer written in Node.js, and provides the [API Blueprint boilerplate](https://github.com/jsynowiec/api-blueprint-boilerplate) as an example. The header is the modified part of a [graphic created by Iconicbestiary](http://www.freepik.com/free-vector/hands-signing-house-or-apartment-contract_1311557.htm), via [Freepik.com](http://www.freepik.com).

## License

Blueprint Docs is licensed under the MIT License (MIT). Please see the [LICENSE](LICENSE.md) file for more information.
