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

use AninuApps\InsideApp\InsideApp;

// Creează instanța
$sdk = new InsideApp();

// Folosește funcția dummy print
$sdk->dummyPrint(); // afișează: test

// Afișează mesaj personalizat
$sdk->printMessage("Salut de la InsideApp!");

// Obține versiunea SDK
echo $sdk->getVersion(); // afișează: 1.0.0
```

## Cerințe

- PHP >= 7.4

## Licență

Licența MIT
