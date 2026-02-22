<?php

/**
 * Exemplu pentru listarea facturilor primite de la furnizori din SPV
 * Echivalentul metodei eFactura_furnizori() din API-ul original
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
    
    // Datele pentru listarea facturilor de la furnizori
    $data_iApp = array(
        'email_responsabil' => $email,      // obligatoriu

        'start' => '2026-01-01',                    // obligatoriu (Y-m-d)
        'end' => date("Y-m-d"),                     // obligatoriu (Y-m-d)

    );
    
    // Apel API pentru listarea facturilor de la furnizori din SPV
    $response = $insideApp->eFacturaFurnizori($data_iApp);

    echo ">>><pre>";
    print_r($response);
    echo "</pre>";
    
    /*
     * Exemplu de răspuns JSON:
     * {
     *   "status": "SUCCESS",
     *   "error_code": "000",
     *   "message": "",
     *   "request": "e-factura/furnizori",
     *   "data": {
     *     "perioada": {
     *       "tStart": 1704060000,
     *       "tEnd": 1750712400,
     *       "dStart": "2024-01-01",
     *       "dEnd": "2025-06-24"
     *     },
     *     "raport": [
     *       {
     *         "id_solicitare": 4112345677,
     *         "id_descarcare": 3180237297,
     *         "mesaj": "Factura cu id_incarcare=4112345677 emisa de cif_emitent=RO23456789 pentru cif_beneficiar=RO47852369",
     *         "data_incarcare": "15 Feb 2026 (10:30)",
     *         "data_sync_iapp": "15 Feb 2026 (10:45)",
     *         "factura": {
     *           "furnizor_name": "OFFICE SUPPLIES SRL",
     *           "furnizor_cif": "RO23456789",
     *           "serie_numar": "OFF-2024-1156",
     *           "total": "2847.50 RON"
     *         }
     *       },
     *       {
     *         "id_solicitare": 4135946038,
     *         "id_descarcare": 3180611988,
     *         "mesaj": "Factura cu id_incarcare=4135946038 emisa de cif_emitent=RO34567890 pentru cif_beneficiar=RO47852369",
     *         "data_incarcare": "20 Feb 2026 (14:25)",
     *         "data_sync_iapp": "20 Feb 2026 (14:40)",
     *         "factura": {
     *           "furnizor_name": "IT SERVICES & CONSULTING SRL",
     *           "furnizor_cif": "RO34567890",
     *           "serie_numar": "ITC-2026-0084",
     *           "total": "5640.00 RON"
     *         }
     *       }
     *     ]
     *   }
     * }
     */
    
} catch (Exception $e) {
    echo "Eroare la listarea facturilor de la furnizori din SPV: " . $e->getMessage() . "\n";
}