# Exemple InsideApp PHP SDK

Colecție completă de exemple pentru utilizarea InsideApp PHP SDK. Toate exemplele sunt funcționale și pot fi rulate direct după configurarea credențialelor.

## 🔧 Configurare

Înainte de a rula exemplele, asigură-te că ai:

1. **Instalează dependențele**:
```bash
composer install
```

## 📁 Structura Exemplelor
### 🌍 Informații Generale
- `curs_valutar.php` - Obține cursul valutar curent
- `info_cif.php` - Verifică informații despre un CIF
- `info_judete.php` - Lista județelor din România
- `info_localitati.php` - Localități dintr-un județ specificat
### 🏦 ConturiBancare/
Gestionarea conturilor bancare ale firmei:
- `lista.php` - Listare toate conturile bancare
- `vizualizare.php` - Detalii cont bancar specific
- `adauga.php` - Adăugare cont bancar nou
- `modifica.php` - Modificare cont existent
- `sterge.php` - Ștergere cont bancar

### 👥 NomenclatorClienti/
Management complet al clientilor:
- `lista.php` - Listare toți clienții
- `vizualizare.php` - Detalii client specific
- `adauga.php` - Adăugare client nou
- `modifica.php` - Modificare date client
- `sterge.php` - Ștergere client

### 📦 NomenclatorProduseServicii/
Gestionarea cataloagelor de produse și servicii:
- `lista.php` - Listare produse/servicii
- `vizualizare.php` - Detalii produs/serviciu
- `adauga.php` - Adăugare produs/serviciu nou
- `modifica.php` - Modificare produs/serviciu
- `sterge.php` - Ștergere din catalog

### 📋 FacturiProforme/
Lucru cu facturile proforma:
- `emite_factura_proforma.php` - Emitere factură proforma nouă
- `emite_factura_fiscala_din_proforma.php` - Conversie proforma → fiscală
- `vizualizare_factura_proforma.php` - Detalii factură proforma
- `vizualizare_toate_facturile_proforme.php` - Listare toate proformele

### 🧾 FacturiFiscale/
Managementul facturilor fiscale:
- `emite_factura_fiscala.php` - Emitere factură fiscală nouă
- `marcheaza_factura_fiscala_incasata.php` - Marcare factură ca încasată
- `storneaza_factura_fiscala.php` - Stornare factură fiscală
- `vizualizare_factura_fiscala.php` - Detalii factură fiscală
- `vizualizare_toate_facturile_fiscale.php` - Listare toate facturile

### 🏛️ SPV/ (Spațiul Privat Virtual)
Integrare completă cu ANAF eFactura:
- `lista_facturi_emise.php` - Facturi emise în SPV
- `lista_facturi_furnizori.php` - Facturi primite de la furnizori
- `vizualizare_factura_emisa.php` - Detalii factură emisă
- `vizualizare_factura_furnizor.php` - Detalii factură furnizor
- `descarcare_factura_emisa.php` - Download PDF factură emisă
- `descarcare_factura_furnizor.php` - Download PDF factură furnizor
- `incarca_factura_xml.php` - Încărcare factură XML în SPV
- `status_trimitere_factura.php` - Status trimitere la ANAF

### 🏢 Reseller/
API pentru managementul mai multor firme:
- `lista_firme.php` - Listare toate firmele din cont
- `vizualizare_firma.php` - Detalii firmă specifică
- `firma_adauga.php` - Adăugare firmă nouă
- `firma_modifica.php` - Modificare date firmă
- `firma_activeaza.php` - Activare firmă
- `firma_dezactiveaza.php` - Dezactivare firmă
- `firma_vizualizare_credentiale_api.php` - Credențiale API firmă
- `firma_reset_credentiale_api.php` - Reset credențiale API
- `trimite_factura_manual_in_spv.php` - Trimitere manuală factură în SPV
- `eFactura_autorizari_lista.php` - Listare autorizări eFactura
- `eFactura_autorizare_noua.php` - Autorizare nouă eFactura
- `eFactura_vizualizare_setari.php` - Setări eFactura
- `eFactura_modifica_setarile.php` - Modificare setări eFactura

### ⚙️ ConfigurareSerii/
Configurarea seriilor de facturi și design:
- `lista_serii.php` - Listare toate seriile
- `design_facturi.php` - Configurări design facturi
- `serie_adauga.php` - Adăugare serie nouă
- `serie_modifica.php` - Modificare serie existentă
- `serie_vizualizare.php` - Detalii serie
- `serie_sterge.php` - Ștergere serie
- `serie_sterge_logo.php` - Ștergere logo din serie

### 💰 Incasari/
Management încasări și plăți:
- `vizualizare_incasari.php` - Vizualizare istoric încasări

## 🚀 Cum să Rulezi un Exemplu

1. **Editează credențialele** direct în exemplu
2. **Navighează** în directorul dorit
3. **Rulează exemplul**:
```bash
php examples/FacturiFiscale/emite_factura_fiscala.php
```

## 📝 Format Exemple

Toate exemplele urmează același format consistent:

```php
<?php

/**
 * Exemplu pentru [descriere funcționalitate]
 * Echivalentul metodei [nume_metoda]() din API-ul original
 */

require_once '../../vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

// Configurare credențiale
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Parametrii pentru apelul API
    $data_iApp = array(
        'email_responsabil' => $email,
        // ... parametrii specifici
    );
    
    // Apel API
    $response = $insideApp->numeMetoda($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /* Exemplu de răspuns JSON comentat */
    
} catch (Exception $e) {
    echo "Eroare: " . $e->getMessage() . "\n";
}
```

## Support & Documentation

- **📧 Suport Email**: support@iapp.ro
- **🎫 Suport Tehnic**: [developer.iapp.ro](https://developer.iapp.ro)
- **📞 Contact**: [iapp.ro/contact](https://iapp.ro/contact)
- **📖 Documentație**: [doc.iapp.ro](https://doc.iapp.ro)
- **🔧 Referințe API**: [doc.iapp.ro/swagger](https://doc.iapp.ro/swagger)
- **🤝 API Reseller**: [doc.iapp.ro/reseller](https://doc.iapp.ro/reseller)
- **🔗 Webhooks Reseller**: [doc.iapp.ro/reseller-webhook](https://doc.iapp.ro/reseller-webhook)

## 🎯 Sugestii de Testare

1. **Începe cu utilitarele**: `curs_valutar.php`, `info_cif.php`
2. **Testează nomenclatoarele**: adaugă clienți, produse
3. **Emite facturi proforma**: apoi convertește-le în fiscale
4. **Explorează SPV**: vezi facturile în Spațiul Privat Virtual
5. **Testează Reseller API**: dacă ai cont reseller

## 🛠️ Debugging

Pentru debugging, toate exemplele afișează răspunsul complet al API-ului. În caz de eroare:

1. **Verifică credențialele** din exemplu
2. **Consultă messajul de eroare** afișat
3. **Verifică documentația** la [doc.iapp.ro](https://doc.iapp.ro)
4. **Contactează suportul** la support@iapp.ro

---

**Nota**: Toate exemplele sunt testate și funcționale. Se recomandă testarea într-un mediu de dezvoltare înainte de utilizarea în producție.