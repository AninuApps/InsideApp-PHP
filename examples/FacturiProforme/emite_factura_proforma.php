<?php

/**
 * Exemplu pentru emiterea unei facturi proforma
 * Echivalentul metodei emite_proforma() din API-ul original
 */

require_once '../../vendor/autoload.php';

use AninuApps\InsideAppPhp\InsideApp;

// Configurare credențiale (înlocuiește cu credențialele tale reale)
$username = 'username_tau_api';  
$password = 'parola_ta_api';
$email = 'email@exemplu.ro';

try {
    // Inițializare SDK
    $insideApp = new InsideApp($username, $password);
    
    // Datele pentru emiterea facturii proforma
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'client' => [
            'type' => "J",  /** F / J  - persoana fizica sau juridica */
            'name' => "SC Exemplu Business SRL",
            'tva' => "Y",   // doar pentru Juridic
            'cif' => "RO12345678",   // doar pentru Juridic
            'regcom' => "J40/1234/2023",   // doar pentru Juridic
            'contact' => "Ion Popescu",       // nume si prenume
            'telefon' => "0721123456",    // optional
            'tara' => "Romania",          // obligatoriu
            'judet' => "Bucuresti",       // obligatoriu
            'localitate' => "Sectorul 1",  // obligatoriu
            'adresa' => "Str. Exemplu nr. 123, Bl. A1, Sc. B, Et. 2, Ap. 15",      // obligatoriu
            'banca' => "Banca Transilvania",       // optional
            'iban' => "RO49BTRL01234567890123",        // optional
            'email' => "contact@exemplu-business.ro",    // optional
            'web' => "www.exemplu-business.ro",         // optional
            'extra' => "Cod postal: 012345",      // optional
        ],
        'data_start' => date("Y-m-d"),  // data emiterii
        'data_termen' => '30',       // Numar de zile de la data emiterii
        'seria' => 'PF',     // serie factura (obligatoriu sa existe in aplicatie)
        'moneda' => 'RON',  // Moneda
        'footer' => [
            'intocmit_name' => 'Maria Ionescu'      // nume si prenume cine emite factura
        ],
        'continut' => [
            [
                'title' => 'Consultanță IT - Dezvoltare aplicații web',
                'um' => 'oră',
                'cantitate' => '40',
                'pret' => '150',
                'tvavalue' => '1140',
                'tvapercent' => '19',
            ], [
                'title' => 'Licență software enterprise',
                'descriere' => "Licență anuală pentru platforma de management\nInclus support tehnic 24/7 și training pentru echipă",
                'um' => 'buc',
                'cantitate' => '1',
                'pret' => '2500',
                'tvavalue' => '475',
                'tvapercent' => '19',
            ]
        ]
    );
    
    // Apel API pentru emiterea facturii proforma
    $response = $insideApp->emiteProforma($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Factura a fost inregistrata cu succes.",
     *   "request": "emite/proforma",
     *   "data": {
     *     "client": {
     *       "type": "J",
     *       "name": "SC Exemplu Business SRL",
     *       "telefon": "0721123456",
     *       "tara": "Romania",
     *       "judet": "Bucuresti",
     *       "localitate": "Sectorul 1",
     *       "adresa": "Str. Exemplu nr. 123, Bl. A1, Sc. B, Et. 2, Ap. 15",
     *       "email": "contact@exemplu-business.ro"
     *     },
     *     "data_start": "2026-02-22",
     *     "data_termen": 30,
     *     "seria": "PF",
     *     "moneda": "RON",
     *     "curs_valutar": 0,
     *     "footer": {
     *       "intocmit_name": "Maria Ionescu",
     *       "intocmit_cnp": "",
     *       "delegat": "",
     *       "buletin": "",
     *       "aviz": "",
     *       "auto_nr": "",
     *       "mentiuni": ""
     *     },
     *     "continut": [
     *       {
     *         "title": "Consultanță IT - Dezvoltare aplicații web",
     *         "descriere": "Servicii profesionale de dezvoltare",
     *         "um": "oră",
     *         "cantitate": 40,
     *         "pret": 150,
     *         "tvavalue": 1140,
     *         "tvapercent": 19
     *       },
     *       {
     *         "title": "Licență software enterprise",
     *         "descriere": "Licență anuală pentru platforma de management",
     *         "um": "buc",
     *         "cantitate": 1,
     *         "pret": 2500,
     *         "tvavalue": 475,
     *         "tvapercent": 19
     *       }
     *     ],
     *     "document": {
     *       "seria": "PF",
     *       "numar": 2024001,
     *       "total": 7615,
     *       "status": "WAIT",
     *       "pdf": "https://my.iapp.ro/share/proforma/tech2024pf001secure789xyz"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la emiterea facturii proforma: " . $e->getMessage() . "\n";
}
