<?php

namespace InsideApp;

class InsideAppAPIClient
{
    private string $hash = '';
    private string $api_url = 'https://api-facturare.inap.ro/';

    public function __construct(string $user, string $pw, ?string $apiUrl = null)
    {
        $this->hash = base64_encode("$user:$pw");
        if ($apiUrl !== null) {
            $this->api_url = rtrim($apiUrl, '/') . '/';
        }
    }

    private function curl(string $url, array|string $data, bool $hasFiles = false): \CurlHandle
    {
        $headers = [
            "Authorization: Basic {$this->hash}",
        ];

        $ch = curl_init($url);

        // SSL verification is disabled here for compatibility; not recommended in production
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($hasFiles) {
                // multipart/form-data — let cURL set the Content-Type boundary automatically
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            } else {
                $headers[] = 'Content-Type: application/json';
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return $ch;
    }

    public function execute(string $pathOrUrl, array $data = [], bool $download = false, bool $hasFiles = false): array
    {
        if (!function_exists('curl_init')) {
            throw new \Exception('cURL extension is not available.');
        }

        if (str_starts_with($pathOrUrl, 'http')) {
            $url = $pathOrUrl;
        } else {
            $url = $this->api_url . ltrim($pathOrUrl, '/');
        }

        $ch = $this->curl($url, $data, $hasFiles);

        if ($download) {
            $outputFile = $data['output'] ?? 'output.zip';
            $fp = fopen($outputFile, 'wb');
            if ($fp === false) {
                throw new \Exception("Failed to open output file for writing: $outputFile");
            }
            curl_setopt($ch, CURLOPT_FILE, $fp);
        }

        $return = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno  = curl_errno($ch);
        $error  = curl_error($ch);
        curl_close($ch);

        if (isset($fp)) {
            fclose($fp);
        }

        if ($errno > 0) {
            throw new \Exception("cURL Error ($errno): $error");
        }

        $decoded = json_decode($return, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['raw' => $return, 'status' => $status, 'json_error' => json_last_error_msg()];
        }

        return ['status' => $status, 'data' => $decoded];
    }

    public function ping(): void
    {
        print 'InsideApp SDK is working';
    }

    public function emite_proforma(array $data): array
    {
        return $this->execute('emite/proforma', $data);
    }

    public function emite_factura(array $data): array
    {
        return $this->execute('emite/factura', $data);
    }
}
