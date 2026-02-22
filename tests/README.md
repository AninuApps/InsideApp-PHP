# Testing Infrastructure - InsideApp PHP SDK

Infrastructura completă de testare pentru SDK-ul InsideApp PHP, incluzând teste unitare și de integrare cu API-ul real.

## 📋 Structura Testelor

```
tests/
├── README.md                           # Acest fișier
├── InsideAppTest.php                   # Teste principale SDK
├── Unit/                               # Teste unitare (nu necesită API real)
│   ├── FacturiTest.php                # Teste operații facturi
│   ├── SPVTest.php                    # Teste operații SPV/eFactura  
│   ├── ResellerTest.php               # Teste operații reseller
│   └── ConfigurareSeriiTest.php       # Teste configurare serii
├── Integration/                        # Teste integrare API real
│   └── InsideAppIntegrationTest.php   # Teste cu API real InsideApp
└── Fixtures/                          # Date mock pentru teste
    └── TestDataFixtures.php           # Helper clase și date test
```

## 🚀 Comenzi Rapide

### Toate testele
```bash
composer test
```

### Doar teste unitare (fără API)
```bash
composer test-unit
```

### Doar teste integrare (cu API real)
```bash
composer test-integration
```

### Cu output detaliat
```bash
composer test-verbose
```

### Generare rapoarte HTML
```bash
composer test-report
# Deschide: reports/testdox.html în browser
```

## 🔐 Configurare Credențiale API

### Variabile de Mediu
Pentru testele de integrare cu API-ul real, setează:

```bash
export INSIDEAPP_TEST_USERNAME="your_username"
export INSIDEAPP_TEST_PASSWORD="your_password"
export INSIDEAPP_TEST_EMAIL="your_email@domain.com"
export INSIDEAPP_INTEGRATION_TESTS=true
```

### Fișier Local (.test_data)
```bash
# Creează .test_data în root (exclus din Git)
echo 'export INSIDEAPP_TEST_USERNAME="your_username"' > .test_data
echo 'export INSIDEAPP_TEST_PASSWORD="your_password"' >> .test_data
echo 'export INSIDEAPP_TEST_EMAIL="your_email@domain.com"' >> .test_data
echo 'export INSIDEAPP_INTEGRATION_TESTS=true' >> .test_data

# Apoi încarcă
source .test_data
```

### Rulare Cu Credențiale Inline
```bash
INSIDEAPP_TEST_USERNAME="username" INSIDEAPP_TEST_PASSWORD="password" INSIDEAPP_TEST_EMAIL="email@test.com" INSIDEAPP_INTEGRATION_TESTS=true vendor/bin/phpunit tests/Integration --verbose
```

## 📝 Tipuri de Teste

### 1. Teste Unitare (`tests/Unit/`)
**Nu necesită API real** - rulează cu date mock

#### FacturiTest.php
- ✅ Validare format date facturi
- ✅ Testare parametri obligatorii
- ✅ Validare CIF-uri și email-uri
- ✅ Testare structura continut factură

#### SPVTest.php  
- ✅ Validare descărcare facturi SPV
- ✅ Testare format ID-uri descărcare
- ✅ Validare parametri filtrare
- ✅ Testare format date eFactura

#### ResellerTest.php
- ✅ Validare date firmă (CIF, IBAN, telefon)
- ✅ Testare format email și adrese
- ✅ Validare capitol social
- ✅ Testare parametri reseller

#### ConfigurareSeriiTest.php
- ✅ Validare configurare serii facturare
- ✅ Testare format numerovarare
- ✅ Validare design ID-uri
- ✅ Testare parametri obligatorii

### 2. Teste Integrare (`tests/Integration/`)
**Necesită credențiale API reale**

#### InsideAppIntegrationTest.php
- 🌐 **testCursValutarIntegration** - Obține cursuri valutare reale
- 🏢 **testInfoCifIntegration** - Validare CIF-uri cu API ANAF
- 📄 **testListareFacturiIntegration** - Listare facturi din cont
- ⚙️ **testTimeoutConfiguration** - Test configurare timeout
- 🔍 **testNomenclatoareIntegration** - Test metode nomenclatoare
- 📊 **testPerformanceMultipleRequests** - Test performanță API
- ❌ **testApiErrorHandling** - Test gestionare erori API

### 3. Teste Principale (`InsideAppTest.php`)
- 🔧 Inițializare SDK
- 📦 Versiune SDK
- ⏱️ Configurare timeout
- 🔑 Validare credențiale
- 🌐 Testare URL-uri API

## 📊 Exemple Răspunsuri API

### Curs Valutar (SUCCESS)
```json
{
    "status": "SUCCESS",
    "error_code": "000",
    "data": {
        "output": [
            {"tag": "EUR", "name": "Euro", "value": "5.0974"},
            {"tag": "USD", "name": "Dolar", "value": "4.3327"}
        ]
    }
}
```

### Info CIF (SUCCESS)  
```json
{
    "status": "SUCCESS", 
    "data": {
        "output": {
            "nume": "FIRMA SRL",
            "cif": "1234567",
            "regcom": "J05/256/1998",
            "tva": "N",
            "adresa": {...}
        }
    }
}
```

### Eroare API
```json
{
    "status": "ERROR",
    "error_code": "0064", 
    "message": "Informatiile de conectare nu sunt corecte"
}
```

## 🛠️ Dezvoltare și Debug

### Rulare Test Specific
```bash
# Un singur test
vendor/bin/phpunit tests/Unit/FacturiTest.php::testValidFacturaData --verbose

# O clasă completă
vendor/bin/phpunit tests/Unit/FacturiTest.php --verbose

# Cu filtrare
vendor/bin/phpunit --filter "testCursValutar" --verbose
```

### Debug Output
Testele de integrare afișează răspunsurile API JSON pentru debug:
- 🔵 **Curs Valutar** 
- 🟡 **Info CIF**
- 🟠 **View Facturi**
- 🟢 **Județe/Nomenclatoare**

### Adăugare Teste Noi

#### Pentru teste unitare:
```php
// tests/Unit/NewFeatureTest.php
<?php
namespace AninuApps\InsideApp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use AninuApps\InsideApp\Tests\Fixtures\TestDataFixtures;

class NewFeatureTest extends TestCase
{
    public function testSomething(): void
    {
        $data = TestDataFixtures::getValidData();
        $this->assertNotEmpty($data);
    }
}
```

#### Pentru teste integrare:
```php
// Adaugă în InsideAppIntegrationTest.php
public function testNewApiEndpoint(): void
{
    if (!getenv('INSIDEAPP_INTEGRATION_TESTS')) {
        $this->markTestSkipped('Integration tests are disabled.');
    }

    $response = $this->insideApp->newMethod(['param' => 'value']);
    echo "\n🟣 RĂSPUNS NEW API:\n";
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
    $this->assertTrue(TestDataFixtures::validateApiResponse($response));
}
```

## 📈 Statistici Teste

- **Total Teste**: 66
- **Total Assertions**: 518+  
- **Success Rate**: 100%
- **Coverage**: Unit tests pentru toate clasele principale
- **Integration**: Testare completă endpoints API

## 🔧 Cerințe Sistem

- **PHP**: >= 7.4
- **PHPUnit**: ^8.5 (compatibil cu PHP 8.3)
- **Extensii PHP**: curl, json, mbstring
- **Opțional**: zip, dom (pentru rapoarte HTML)

## 📋 Configurare PHPUnit

Configurația se află în `phpunit.xml`:
- **Bootstrap**: `vendor/autoload.php`
- **Test Suites**: Unit, Integration, All
- **Colors**: Enabled
- **Verbose**: Enabled per default

## 🎯 Best Practices

### 1. **Mock vs Real API**
- Folosește **Unit tests** pentru logică business
- Folosește **Integration tests** pentru validare API reală
- **Mock data** pentru development rapid

### 2. **Securitate Credențiale**
- ❌ **Nu** commitezi credențiale în cod
- ✅ Folosește variabile de mediu
- ✅ Folosește `.test_data` local (exclus din Git)

### 3. **Performance**
- Unit tests să ruleze **< 5 secunde**
- Integration tests **< 30 secunde**
- Folosește `timeout` pentru API calls

### 4. **Debugging**
- Activează **verbose mode** pentru detalii
- Folosește **debug output** în integration tests
- Verifică **logs** pentru erori resize

## 📞 Suport

- **Dokumentație SDK**: [README.md](../README.md)
- **API Docs**: https://doc.iapp.ro
- **Portal Suport**: https://developer.iapp.ro  
- **Email**: support@iapp.ro

---

## 🚀 Começi Rapide Summary

```bash
# Setup rapid
composer install
composer test-unit                    # Teste fără API (sigure)

# Cu API real  
source .test_data                     # Încarcă credențiale
composer test-integration             # Teste cu API real

# Rapoarte
composer test-report                  # Generează HTML
explorer.exe reports/testdox.html    # Deschide în browser

# Debug
vendor/bin/phpunit --verbose --debug # Output maxim
```

**SDK-ul este gata pentru producție cu infrastructură completă de testare!** ✨