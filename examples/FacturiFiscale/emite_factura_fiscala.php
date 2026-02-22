<?php

/**
 * Exemplu pentru emiterea unei facturi fiscale
 * Echivalentul metodei emite_factura() din API-ul original
 */

require_once '../../vendor/autoload.php';

use AninuApps\InsideApp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru emiterea facturii fiscale
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'client' => [
            'type' => "J",  /** F / J  - persoana fizica sau juridica */
            'name' => "SC Tech Solutions SRL",
            'tva' => "Y",   // doar pentru Juridic
            'cif' => "RO98765432",  // doar pentru Juridic
            'regcom' => "J40/5678/2022",   // doar pentru Juridic
            'contact' => "Andrei Georgescu",       // nume si prenume
            'telefon' => "0742987654",    // optional
            'tara' => "Romania",          // obligatoriu
            'judet' => "Cluj",       // obligatoriu
            'localitate' => "Cluj-Napoca",  // obligatoriu
            'adresa' => "Str. Tehnologiei nr. 45, Et. 3, Biroul 12",      // obligatoriu
            'banca' => "BCR",       // optional
            'iban' => "RO76RNCB0082123456789012",        // optional
            'email' => "facturare@tech-solutions.ro",    // optional
            'web' => "www.tech-solutions.ro",         // optional
            'extra' => "Punct de lucru secundar",      // optional
        ],
        'data_start' => date("Y-m-d"),  // data emiterii
        'data_termen' => '15',       // Numar de zile de la data emiterii
        'seria' => 'FF',     // serie factura (obligatoriu sa existe in aplicatie)
        // 'numar' => '35',      // numar factura (optional, dar obligatoriu sa fie unic pe serie)
        'moneda' => 'RON',  // Moneda
        'footer' => [
            'intocmit_name' => 'Elena Popescu'      // nume si prenume cine emite factura
        ],
        'continut' => [
            [
                'title' => 'Dezvoltare aplicație mobilă',
                'um' => 'oră',
                'cantitate' => '80',
                'pret' => '120',
                'tvavalue' => '1824',
                'tvapercent' => '19',
            ], [
                'title' => 'Servicii de hosting cloud',
                'descriere' => "Hosting dedicat pentru aplicația dezvoltată\nInclus backup automat zilnic și monitoring 24/7",
                'um' => 'lună',
                'cantitate' => '12',
                'pret' => '250',
                'tvavalue' => '570',
                'tvapercent' => '19',
            ]
        ],
        /*  Referinta cumparatorului (BT-10);
        Numar de proiect (BT-11);
        Numar de contract (BT-12);
        Nr. comanda de achizitie (BT-13);
        Nr. comanda de vanzare (BT-14);
        Referinta aviz receptie (BT-15);
        Referința avizului de expediție (Număr aviz de însoțire marfa) (BT-16);
        Referinta lotului (BT-17);
        Referinta contabila a cumparatorului (BT-19);
        Conditii de plata (BT-20);
        Tip proces operational (BT-23);
        Nr. factura anterioara (BT-25);
        Data factura anterioara (BT-26);
        Identificator vanzator (BT-29);
        Identificator cumparator (BT-46);
        Perioada de facturare (BT-73, BT-74);
        Referinta doc. justificativ (BT-122);
        Descriere document justificativ (BT-123).
        */
        'xml' => [ // all optional - coduri pentru eFactura
            'bt_10' => 'REF-CLIENT-2026-001',
            'bt_11' => 'PROJ-MOBILE-APP-2026',
            'bt_12' => 'CONTRACT-DEV-2026-001',
            'bt_13' => 'PO-TECH-20260222-001',
            'bt_14' => 'SO-SOLUTIONS-20260222-001',
            'bt_15' => 'AVIZ-RECEPTIE-001',
            'bt_16' => 'AVIZ-EXPEDITIE-001',
            'bt_17' => 'LOT-DEV-2026-Q1',
            'bt_19' => 'CONT-CLIENT-2026-001',
            'bt_20' => 'Plata la 15 zile de la emitere',
            'bt_23' => 'Dezvoltare software',
            'bt_25' => 'FF-2026-100',
            'bt_26' => '2026-01-15',
            'bt_29' => 'VANZATOR-TECH-001',
            'bt_46' => 'CUMPARATOR-CLIENT-001',
            'bt_73' => '2026-02-01',
            'bt_74' => '2026-02-28',
            'bt_122' => 'DOC-JUSTIF-2026-001',
            'bt_123' => 'Contract de dezvoltare aplicație mobilă',
        ],
    );
    
    // Apel API pentru emiterea facturii fiscale
    $response = $insideApp->emiteFactura($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Factura a fost inregistrata cu succes.",
     *   "request": "emite/factura",
     *   "data": {
     *     "client": {
     *       "type": "J",
     *       "name": "SC Tech Solutions SRL",
     *       "telefon": "0742987654",
     *       "tara": "Romania",
     *       "judet": "Cluj",
     *       "localitate": "Cluj-Napoca",
     *       "adresa": "Str. Tehnologiei nr. 45, Et. 3, Biroul 12",
     *       "email": "facturare@tech-solutions.ro"
     *     },
     *     "data_start": "2026-02-22",
     *     "data_termen": 15,
     *     "seria": "FF",
     *     "numar": 2026015,
     *     "moneda": "RON",
     *     "curs_valutar": 0,
     *     "footer": {
     *       "intocmit_name": "Elena Popescu",
     *       "intocmit_cnp": "",
     *       "delegat": "",
     *       "buletin": "",
     *       "aviz": "",
     *       "auto_nr": "",
     *       "mentiuni": ""
     *     },
     *     "continut": [
     *       {
     *         "title": "Dezvoltare aplicație mobilă",
     *         "descriere": "Servicii profesionale dezvoltare mobile app",
     *         "um": "oră",
     *         "cantitate": 80,
     *         "pret": 120,
     *         "tvavalue": 1824,
     *         "tvapercent": 19
     *       },
     *       {
     *         "title": "Servicii de hosting cloud",
     *         "descriere": "Hosting dedicat cu backup și monitoring 24/7",
     *         "um": "lună",
     *         "cantitate": 12,
     *         "pret": 250,
     *         "tvavalue": 570,
     *         "tvapercent": 19
     *       }
     *     ],
     *     "document": {
     *       "seria": "FF",
     *       "numar": 2026015,
     *       "total": 12994,
     *       "status": "WAIT",
     *       "pdf": "https://my.iapp.ro/share/factura/tech2024ff015secure456ghi"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la emiterea facturii fiscale: " . $e->getMessage() . "\n";
}
