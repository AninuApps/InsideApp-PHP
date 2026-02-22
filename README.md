# InsideApp-PHP

PHP SDK for the [InsideApp](https://inap.ro/) API.

## Installation

```bash
composer require aninuapps/insideapp-php
```

## Usage

```php
require __DIR__ . '/vendor/autoload.php';

$user = 'your_username';
$pw   = 'your_password';

$iApp = new InsideApp\InsideAppAPIClient($user, $pw);

// Verify the SDK is loaded
$iApp->ping();

// Emit an invoice
$response = $iApp->emite_factura([
    'client'   => 'Acme SRL',
    'produse'  => [
        ['denumire' => 'Servicii web', 'cantitate' => 1, 'pret' => 100],
    ],
]);
print_r($response);

// Emit a proforma invoice
$response = $iApp->emite_proforma([
    'client'  => 'Acme SRL',
    'produse' => [
        ['denumire' => 'Servicii web', 'cantitate' => 1, 'pret' => 100],
    ],
]);
print_r($response);
```

### Custom API URL

```php
$iApp = new InsideApp\InsideAppAPIClient($user, $pw, 'https://custom.api.example.com/');
```

### Download a file

```php
$response = $iApp->execute('factura/download', ['id' => 123, 'output' => 'factura.zip'], download: true);
```

## Requirements

- PHP 8.0 or higher
- cURL extension enabled
- `ext-dom` (required by PHPUnit for running the test suite)

## Running Tests

```bash
composer install
composer test
```

## License

MIT
