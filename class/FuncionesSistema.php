<?php
class FuncionesSistema {
    public static function validarUrl($url) {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200') !== false;
    }

    public static function obtenerTweets($username) {
        $bearer_token = TOKEN_X; // Sustituye con tu Bearer Token

        $url = "https://api.twitter.com/2/tweets/search/recent?query=from:$username&tweet.fields=created_at,text";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $bearer_token",
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public static function obtenerPostsInstagram($userId) {
        $accessToken = TOKEN_META;
        $url = "https://graph.instagram.com/$userId/media?fields=id,caption,media_type,media_url,permalink&access_token=$accessToken";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }

    // Obtener información del navegador y sistema operativo
    public static function obtenerInfoNavegador($userAgent) {
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) return 'Internet Explorer';
        return 'Desconocido';
    }

    public static function obtenerInfoSO($userAgent) {
        if (strpos($userAgent, 'Windows') !== false) return 'Windows';
        if (strpos($userAgent, 'Macintosh') !== false) return 'MacOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) return 'iOS';
        return 'Desconocido';
    }

    public static function obtenerTipoDispositivo($userAgent) {
        if (preg_match('/mobile/i', $userAgent)) return 'Móvil';
        if (preg_match('/tablet/i', $userAgent)) return 'Tablet';
        return 'Desktop';
    }

    public static function obtenerUbicacionPorIP($ip) {
        $url = "http://ip-api.com/php/{$ip}";
        $respuesta = @file_get_contents($url);
        $datos = @unserialize($respuesta);
        if ($datos && $datos['status'] == 'success') {
            return [$datos['country'], $datos['city'], json_encode($datos)];
        }
        return ['Desconocido', 'Desconocida', json_encode(['error' => 'No se pudo obtener datos'])];
    }
}