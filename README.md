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

## 📋 Changelog & Versioning

Toate schimbările și versiunile sunt documentate în [CHANGELOG.md](CHANGELOG.md).

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
$email = 'email@exemplu.ro';

// Inițializare SDK
$insideApp = new InsideApp($username, $password);

// Exemplu: Listare facturi
$data_iApp = array(
    'email_responsabil' => $email,      // obligatoriu
    'start' => '2026-01-01',                    // obligatoriu (Y-m-d)
    'end' => date("Y-m-d"),                     // obligatoriu (Y-m-d) - până azi
);
$facturi = $insideApp->viewFacturi($data_iApp);

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

Găsești exemple complete în folderul `examples/`. **Vezi [examples/README.md](examples/README.md) pentru documentație detaliată și instrucțiuni de rulare.**

```
examples/
├── curs_valutar.php           # Cursul valutar curent
├── info_cif.php               # Verificare informații CIF
├── info_judete.php            # Lista județelor din România
├── info_localitati.php        # Localități dintr-un județ
├── FacturiProforme/
│   ├── emite_factura_proforma.php
│   ├── emite_factura_fiscala_din_proforma.php
│   ├── vizualizare_factura_proforma.php
│   └── vizualizare_toate_facturile_proforme.php
├── FacturiFiscale/
│   ├── emite_factura_fiscala.php
│   ├── marcheaza_factura_fiscala_incasata.php
│   ├── storneaza_factura_fiscala.php
│   ├── vizualizare_factura_fiscala.php
│   └── vizualizare_toate_facturile_fiscale.php
├── SPV/
│   ├── lista_facturi_emise.php
│   ├── lista_facturi_furnizori.php
│   ├── vizualizare_factura_emisa.php
│   ├── vizualizare_factura_furnizor.php
│   ├── descarcare_factura_emisa.php
│   ├── descarcare_factura_furnizor.php
│   ├── incarca_factura_xml.php
│   └── status_trimitere_factura.php
├── ConturiBancare/
│   ├── lista.php              # Listare conturi bancare
│   ├── vizualizare.php        # Vizualizare detalii cont
│   ├── adauga.php             # Adăugare cont bancar nou
│   ├── modifica.php           # Modificare cont existent
│   └── sterge.php             # Ștergere cont bancar
├── NomenclatorClienti/
│   ├── lista.php              # Listare clienți
│   ├── vizualizare.php        # Vizualizare detalii client
│   ├── adauga.php             # Adăugare client nou
│   ├── modifica.php           # Modificare client existent
│   └── sterge.php             # Ștergere client
├── NomenclatorProduseServicii/
│   ├── lista.php              # Listare produse/servicii
│   ├── vizualizare.php        # Vizualizare detalii produs
│   ├── adauga.php             # Adăugare produs/serviciu nou
│   ├── modifica.php           # Modificare produs existent
│   └── sterge.php             # Ștergere produs/serviciu
├── Reseller/
│   ├── lista_firme.php
│   ├── vizualizare_firma.php
│   ├── firma_adauga.php
│   ├── firma_modifica.php
│   ├── firma_activeaza.php
│   ├── firma_dezactiveaza.php
│   ├── firma_vizualizare_credentiale_api.php
│   ├── firma_reset_credentiale_api.php
│   ├── trimite_factura_manual_in_spv.php
│   ├── eFactura_autorizari_lista.php
│   ├── eFactura_autorizare_noua.php
│   ├── eFactura_vizualizare_setari.php
│   └── eFactura_modifica_setarile.php
├── ConfigurareSerii/
│   ├── lista_serii.php
│   ├── design_facturi.php
│   ├── serie_adauga.php
│   ├── serie_modifica.php
│   ├── serie_vizualizare.php
│   ├── serie_sterge.php
│   └── serie_sterge_logo.php
└── Incasari/
    └── vizualizare_incasari.php
```

## Cerințe

- PHP >= 7.4

## Licență

Licența MIT
