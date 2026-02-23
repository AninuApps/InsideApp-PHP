# Changelog

Toate schimbările notabile ale acestui proiect vor fi documentate în acest fișier.

Formatul se bazează pe [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
și acest proiect respectă [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.30.2] - 2024-02-23

### Changed
- 🧹 Curățare documentație: eliminare duplicate în README-uri
- 🗂️ Reorganizare structură exemple în documentație
- 📝 Îmbunătățire consistență format documentație

### Removed
- 🚫 Eliminat referințe la `example.php` din documentație
- 🏷️ Șters tag vechi v1.30.1 pentru managementul curat al versiunilor

## [1.30.1] - 2024-02-23

### Added
- 🌍 **Metodă nouă**: `infoJudete()` - Lista completă a județelor din România
- 🏘️ **Metodă nouă**: `infoLocalitati($judet)` - Localități pentru un județ specificat
- 📋 Exemple practice: `examples/info_judete.php` și `examples/info_localitati.php`
- 🧪 Suite de teste complete pentru noile metode geografice
- 📊 Teste de integrare cu API real pentru validarea datelor

### Changed
- 📚 Actualizare README.md cu documentație pentru noile metode
- 🔧 Îmbunătățire structură exemple în `examples/README.md`

### Technical
- ✅ 72 metode publice disponibile în SDK
- 🚀 Răspunsuri API sub 300ms pentru metodele geografice
- 📈 Coverage complet pentru noile funcționalități

## [1.30.0] - 2026-02-XX

### Added
- 📦 Publicare inițială pe Packagist
- 🔗 Integrare Composer pentru instalare simplă
- 🎯 Badges Packagist în documentație

### Changed
- 🔄 Migrare de la descărcări ZIP la instalare Composer
- 📄 Actualizare HTML pages cu referințe Packagist

## [1.29.x și anterioare]
Versiuni anterioare fără changelog documentat. Pentru detalii complete despre funcționalități:
- 📖 Consultă [documentația oficială](https://doc.iapp.ro)
- 🔍 Vezi [referințele API](https://doc.iapp.ro/swagger)

---

## Tipuri de schimbări

- **Added** pentru funcționalități noi
- **Changed** pentru schimbări în funcționalități existente  
- **Deprecated** pentru funcționalități care vor fi eliminate în viitoarele versiuni
- **Removed** pentru funcționalități eliminate
- **Fixed** pentru bug fixes
- **Security** pentru patch-uri de securitate

## Link-uri

- [Repository GitHub](https://github.com/AninuApps/InsideApp-PHP)
- [Packagist](https://packagist.org/packages/aninu-apps/inside-app-php)
- [Documentație](https://doc.iapp.ro)
- [Suport](mailto:support@iapp.ro)

[Unreleased]: https://github.com/AninuApps/InsideApp-PHP/compare/v1.30.2...HEAD
[1.30.2]: https://github.com/AninuApps/InsideApp-PHP/releases/tag/v1.30.2