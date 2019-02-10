Nextras Form Components
========================

[![Build Status](https://travis-ci.org/nextras/form-components.svg?branch=master)](https://travis-ci.org/nextras/form-components)
[![Downloads this Month](https://img.shields.io/packagist/dm/nextras/form-components.svg?style=flat)](https://packagist.org/packages/nextras/form-components)
[![Stable version](http://img.shields.io/packagist/v/nextras/form-components.svg?style=flat)](https://packagist.org/packages/nextras/form-components)
[![Code coverage](https://img.shields.io/coveralls/nextras/form-components.svg?style=flat)](https://coveralls.io/r/nextras/form-components)

This package provides architecture and UI components for building Nette forms.

Architecture components provide Nette Forms' BaseControl in two flavors:
- BaseControl that inherits from `Nette\Application\UI\Component` - form control with support for signal & state handling;
- BaseControl that inherits from `Nette\Application\UI\Control` - form control with support for template rendering + same feature as in UI\Component; 

UI components:
- *AutocompleteControl* - text input with support for autocomplete signal handling;
- *DateControl* - date picker - text input returning `DateTimeImmutable` instance;
- *DateTimeControl* - date tiime picker - text input returning `DateTimeImmutable` instance;

### Installation

The best way to install is using [Composer](http://getcomposer.org/):

```sh
$ composer require nextras/form-components
```

### Documentation

See examples directory.


### License

Combined MIT and Nette's . See full [license](license.md).
