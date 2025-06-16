<?php
class Api_Siniwin
{

    protected static function Signature()
    {
        $Date = date('Ymd');
        $toHash = SINIWIN_USER_ID . SINIWIN_SECRET_TOKEN . $Date;

        $signature = hash('sha512', $toHash);

        return $signature;
    }

    protected static function Curl_Conection($url, $method = 'GET')
    {
        if (empty($url)) { throw new Exception("URL is empty"); }
        if (!filter_var($url, FILTER_VALIDATE_URL)) { throw new Exception("Invalid URL format"); }
        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) { throw new Exception("Invalid HTTP method"); }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . SINIWIN_BEARER_TOKEN
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if (curl_errno($curl)) { $error_msg = curl_error($curl); throw new Exception("Curl error: " . $error_msg); }
        if (empty($response)) { throw new Exception("Empty response from API"); }

        $response = json_decode($response, true);

        if ($response['success'] == false) { throw new Exception("API error: " . $response['error']['description']); }

        if (!empty($response['data'])) { $response = $response['data']; return $response; } 
        else { throw new Exception("API error: No data found in response"); }
    }

    public static function Productos($numRef = "", $idStore = "")
    {
        $ref = !empty($numRef) ? '&ref=' . $numRef : '';
        $store = !empty($idStore) ? '&store=' . $idStore : '';
        $signature = '?signature=' . self::Signature();

        $url = SINIWIN_URL_API . '/products' . $signature . $ref . $store;

        $productos = self::Curl_Conection($url);

        return $productos;
    }
}