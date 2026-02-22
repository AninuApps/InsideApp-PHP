# InsideApp PHP SDK

A simple PHP SDK for InsideApp with basic functionality.

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
