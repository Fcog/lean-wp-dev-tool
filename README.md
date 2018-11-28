# Pre-requisites

You need to make sure you have at least the followings to use the theme:

- PHP 7.0
- [composer](https://getcomposer.org/doc/00-intro.md)

You need to make sure you have installed composer globally in your terminal just by running 
`composer -v` you should have an output as follows: 

```
$ composer -v
   ______
  / ____/___  ____ ___  ____  ____  ________  _____
 / /   / __ \/ __ `__ \/ __ \/ __ \/ ___/ _ \/ ___/
/ /___/ /_/ / / / / / / /_/ / /_/ (__  )  __/ /
\____/\____/_/ /_/ /_/ .___/\____/____/\___/_/
                    /_/
Composer version 1.2.1 2016-09-12 11:27:19
```

# Installation

1. Download or clone the theme
2. Go to the theme path and run `composer install`

# Scripts

The theme uses [`composer`](https://getcomposer.org/doc/00-intro.md) as dependency manager for PHP
libraries and script mananger for the theme, inside of the theme you have the following commands
available.

To run any of the following commands you only need to type the name of the command on your terminal
for instance: 

```
composer lint
```

### composer build

This task run: 

- `composer build-deps`
- `composer buld-app`

### composer build-deps

Install all the required packages from `package.json` inside of the `patterns`
directory, this command is executed automatically after you run `composer install` or `composer
update`

### composer build-app

This task generates the production ready assets by running [`gulp build`](patterns#gulp-build) 
inside of the `patterns` directory.

### composer lint

Function that executes the linter task for the `.php` files except on `vendor` directory the files
are specified as follows: 

```
 *.php src/*.php **/*.php src/**/**/*.php --ignore=vendor
```

If you want to change this just [edit `composer.json` file](composer.json#L52) to adjust based on your needs. 

The linter for PHP uses the [`WordPresss` Coding Standard](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) 
configuration to make sure we follow the coding standards specified by the `WordPress` handbook.

### composer set-up-php-lint

Script that is executed automatically after `composer install` or `composer update` and is used to
setup the linter configuration for `PHP`.

### composer <task to create Pattern>

Script to create a organism/molecule/atom folder inside of the `patterns` directory, as well as php/scss files. It will also add the corresponding calls to the scss file in the general `_style.scss` file. To run this task:
- `composer organism -- <name-of-element>`
- `composer molecule -- <name-of-element>`
- `composer atom -- <name-of-element>`


# Actions

> List of `hooks` and `filters` availables to be used with this theme.

### `lean/before_header`

Action executed before the main `<header>` tag and after the `<body>` tag, useful
if you want to add something before anyother tag on the site.

### `lean/after_header`

Action executed after the main `</header>` tag. Useful if you want to add something
just after the header has been rendered.

### `lean/before_footer`

Action that is executed before the main `<footer>` tag. Useful to add something 
before the last tag of the page is added.

### `lean/after_footer`

Action that is executed before the closing `</body>` tag and just after the 
`</footer>` tg. Useful to add something at the end of the site.

# Filters

The following is a collection of filters available to be used to change settings
and options from the theme at any point.

### `lean/acf_path`

With this filter you can change the location of the ACF files, by default saves 
the ACF Groups into the `acf` directory located on the theme.

### `lean/acf_use_custom_location`:

By default is set to `true`, with this filter you can remove the automatic 
save of ACF Fields into the `lean/acf_path`.

# Helper functions

### use_icon

This function renders a new icon from the sprite set.

**Parameters**

- id: the file name of the icon for example if you have a file 
`patterns/static/icons/facebook.svg` the `id` of the icon is `facebook`.
- class_name: The `class_name` attribute is an optional parameter that can be 
used to add a custom class to the specifc instance of the icon if a different 
style is required.
