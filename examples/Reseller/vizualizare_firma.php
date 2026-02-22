<?php

/**
 * Exemplu pentru vizualizarea detaliilor unei firme din contul reseller
 * Echivalentul metodei firma_vizualizare() din API-ul original
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
    
    // Datele pentru vizualizarea unei firme
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu
        'id'    => '36038935438935c360363389354389',  // id_firma
    );
    
    // Apel API pentru vizualizarea detaliilor firmei
    $response = $insideApp->firmaVizualizare($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "firma/vizualizare",
     *   "data": {
     *     "output": {
     *       "id": "36089343893535d3638935389",
     *       "nume": "TECHNO SOLUTIONS SRL",
     *       "regcom": "J40/8234/2023",
     *       "cif": "RO47852369",
     *       "adresa": {
     *         "tara": "Romania",
     *         "judet": "Bucuresti",
     *         "oras": "Sector 1",
     *         "adresa": "Str. Calea Victoriei nr. 120, et. 3, ap. 15"
     *       },
     *       "banca": {
     *         "name": "Banca Transilvania",
     *         "iban": "RO49BTRLRONCRT0237923501"
     *       },
     *       "contact": {
     *         "name": "Andrei Popescu",
     *         "email": "contact@technosolutions.ro",
     *         "telefon": "0721.345.678",
     *         "web": "www.technosolutions.ro"
     *       },
     *       "defaultintocmit": "Popescu Andrei - Administrator",
     *       "capitalsocial": "200",
     *       "caen": "6201",
     *       "tva": "Y",
     *       "tvaintracomunitar": "N",
     *       "extra": "Societate cu activitate în dezvoltare software și consultanță IT",
     *       "status": "activa",
     *       "anaf_spv_status": "autorizata",
     *       "anaf_spv_last_sync": "2024-02-22 10:30:15"
     *     }
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la vizualizarea firmei: " . $e->getMessage() . "\n";
}