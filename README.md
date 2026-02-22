# InsideApp PHP SDK

**SDK oficial PHP pentru InsideApp** - gestiune facturi și integrare completă cu SPV. Tot ce ai nevoie pentru facturarea în România: emite facturi, integrează automat cu ANAF eFactura și gestionează tot procesul pentru mai multe firme direct din aplicația ta.

## 🚀 Caracteristici Principale

- **📋 Gestiune Facturi**: Proformă, fiscale, chitanțe, încasări
- **🏛️ Integrare Completă SPV**: eFactura automată cu ANAF
- **📚 Arhivă Digitală**: Toate facturile emise și primite din SPV
- **👥 Management Complet**: Clienți, produse, servicii, conturi  
- **🏢 API Reseller**: Gestionează facturarea pentru mai multe firme din aplicația ta
- **🔧 Instrumente Utile**: Validare CIF, cursuri valutar, configurări

[![Packagist Version](https://img.shields.io/packagist/v/aninu-apps/inside-app-php)](https://packagist.org/packages/aninu-apps/inside-app-php)
[![Total Downloads](https://img.shields.io/packagist/dt/aninu-apps/inside-app-php)](https://packagist.org/packages/aninu-apps/inside-app-php)

## Support & Documentation

- **📧 Suport Email**: support@iapp.ro
- **🎫 Suport Tehnic**: [developer.iapp.ro](https://developer.iapp.ro)
- **📞 Contact**: [iapp.ro/contact](https://iapp.ro/contact)
- **📖 Documentație**: [doc.iapp.ro](https://doc.iapp.ro)
- **🔧 Referințe API**: [doc.iapp.ro/swagger](https://doc.iapp.ro/swagger)
- **🤝 API Reseller**: [doc.iapp.ro/reseller](https://doc.iapp.ro/reseller)
- **🔗 Webhooks Reseller**: [doc.iapp.ro/reseller-webhook](https://doc.iapp.ro/reseller-webhook)

## Instalare

Instalează prin Composer:

```bash
composer require aninu-apps/inside-app-php
```

## Utilizare

```php
<?php

require_once 'vendor/autoload.php';

use AninuApps\InsideAppPhp\InsideApp;

// Configurare credențiale API
$username = 'username_tau_api';
$password = 'parola_ta_api';

// Inițializare SDK
$insideApp = new InsideApp($username, $password);

// Exemplu: Listare facturi
$facturi = $insideApp->facturiLista(['limit' => 10]);

// Exemplu: Verificare curs valutar
$curs = $insideApp->cursValutar();
echo "EUR/RON: " . $curs['data']['EUR'];
```

## Exemple Practice

### 📊 Verificare Informații CIF

```php
// Obținere informații despre un CIF
$data = [
    'email_responsabil' => 'email@firma.ro',  // obligatoriu
    'cif' => '12345678',                      // obligatoriu
];

$response = $insideApp->infoCif($data);
print_r($response);
```

### 📋 Emitere Factură Proforma

```php
$facturaProforma = [
    'email_responsabil' => 'email@firma.ro',
    'client' => [
        'type' => 'J',  // J = Juridic, F = Fizic
        'name' => 'SC Exemplu Business SRL',
        'cif' => 'RO12345678',
        'contact' => 'Ion Popescu',
        'telefon' => '0721123456',
        'tara' => 'Romania',
        'judet' => 'Bucuresti',
        'localitate' => 'Sectorul 1',
        'adresa' => 'Str. Exemplu nr. 123',
        'email' => 'contact@exemplu.ro'
    ],
    'data_start' => date('Y-m-d'),
    'data_termen' => '30',  // zile
    'seria' => 'PF',
    'moneda' => 'RON',
    'footer' => ['intocmit_name' => 'Maria Ionescu'],
    'continut' => [
        [
            'title' => 'Consultanță IT',
            'um' => 'oră',
            'cantitate' => '40',
            'pret' => '150',
            'tvavalue' => '1140',
            'tvapercent' => '19'
        ]
    ]
];

$response = $insideApp->emiteProforma($facturaProforma);
```

### 📁 Fișiere Exemple

Găsești exemple complete în folderul `examples/`:

```
examples/
├── curs_valutar.php           # Cursul valutar curent
├── info_cif.php               # Verificare informații CIF
├── FacturiProforme/
│   ├── emite_proforma.php     # Emitere factură proforma
│   ├── vizualizare_factura_proforma.php
│   └── vizualizare_toate_facturile_proforme.php
└── FacturiFiscale/
    ├── emite_factura_fiscala.php
    ├── vizualizare_factura_fiscala.php
    └── marcheaza_factura_fiscala_incasata.php
```

## Cerințe

- PHP >= 7.4

## Licență

Licența MIT
