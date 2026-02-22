<?php

/**
 * Exemplu pentru modificarea unei firme existente în contul reseller
 * Echivalentul metodei firma_modifica() din API-ul original
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
    
    // Datele pentru modificarea unei firme existente
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'id'    => '36038935438935c35e360389354389',

        'nume'  => "TECHNO SOLUTIONS SRL",
        'regcom'  => "J40/8234/2023",
        'cif'  => "RO47852369",
        'adresa' => array(
            'tara'  => "Romania",
            'judet'  => "Bucuresti",
            'oras'  => "Sector 2",
            'adresa'  => "Str. Calea Floreasca nr. 246, et. 5, birou 12",
        ),
        'banca' => array(
            'name'  => "BCR",
            'iban'  => "RO49RNCB0082049533570001",
        ),
        'contact' => array(
            'name'  => "Maria Ionescu",
            'email'  => "office@technosolutions.ro",
            'telefon'  => "0731.456.789",
            'web'  => "https://technosolutions.ro",
        ),
        'defaultintocmit'  => "Ionescu Maria - Director General",
        'capitalsocial'  => "500",
        'caen'  => "6202",
        'tva'  => "Y",   // Y/N
        'tvaintracomunitar'  => "Y",
        'extra'  => "Societate cu activitate în dezvoltare software, consultanță IT și servicii cloud",
    );
    
    // Apel API pentru modificarea firmei
    $response = $insideApp->resellerFirmaModifica($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "Firma a fost actualizată cu succes.",
     *   "request": "firma/modifica",
     *   "data": {
     *     "output": {
     *       "id": "36038935438935c35e360389354389",
     *       "email_responsabil": "admin@technosolutions.ro",
     *       "nume": "TECHNO SOLUTIONS SRL",
     *       "cif": "RO47852369"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la modificarea firmei: " . $e->getMessage() . "\n";
}