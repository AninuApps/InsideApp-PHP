# InsideApp PHP SDK

A simple PHP SDK for InsideApp with basic functionality.

[![Packagist Version](https://img.shields.io/packagist/v/aninu-apps/inside-app-php)](https://packagist.org/packages/aninu-apps/inside-app-php)
[![Total Downloads](https://img.shields.io/packagist/dt/aninu-apps/inside-app-php)](https://packagist.org/packages/aninu-apps/inside-app-php)

## Installation

Install via Composer:

```bash
composer require aninu-apps/inside-app-php
```

## Usage

```php
<?php

require_once 'vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

// Create instance
$sdk = new InsideApp();

// Use dummy print function
$sdk->dummyPrint(); // outputs: test

// Print custom message
$sdk->printMessage("Hello World!");

// Get SDK version
echo $sdk->getVersion(); // outputs: 1.0.0
```

## Requirements

- PHP >= 7.4

## License

MIT License
