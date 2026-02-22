<?php

/**
 * Exemplu pentru adăugarea unei noi firme în contul reseller
 * Echivalentul metodei firma_adauga() din API-ul original
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
    
    // Datele pentru adăugarea unei noi firme
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        
        'nume'  => "TECHNO SOLUTIONS SRL",
        'regcom'  => "J40/8234/2023",
        'cif'  => "RO47852369",
        'adresa' => array(
            'tara'  => "Romania",
            'judet'  => "Bucuresti",
            'oras'  => "Sector 1",
            'adresa'  => "Str. Calea Victoriei nr. 120, et. 3, ap. 15",
        ),
        'banca' => array(
            'name'  => "Banca Transilvania",
            'iban'  => "RO49BTRLRONCRT0237923501",
        ),
        'contact' => array(
            'name'  => "Andrei Popescu",
            'email'  => "contact@technosolutions.ro",
            'telefon'  => "0721.345.678",
            'web'  => "www.technosolutions.ro",
        ),
        'defaultintocmit'  => "Popescu Andrei",
        'capitalsocial'  => "200",
        'caen'  => "6201",
        'tva'  => "Y",   // Y/N
        'tvaintracomunitar'  => "N",
        'extra'  => "Societate cu activitate în dezvoltare software și consultanță IT",
    );
    
    // Apel API pentru adăugarea firmei
    $response = $insideApp->firmaAdauga($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Firma a fost adăugată cu succes.",
     *   "request": "firma/adauga",
     *   "data": {
     *     "output": {
     *       "id": "360389343893535e35f38934389",
     *       "email_responsabil": "admin@technosolutions.ro",
     *       "nume": "TECHNO SOLUTIONS SRL",
     *       "cif": "RO47852369"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la adăugarea firmei: " . $e->getMessage() . "\n";
}