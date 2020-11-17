<?php

namespace AnexusPHP\Core\Tools;

class Request
{
    public static function sendPostJson($url, $data, $headers = [])
    {
        $ch = curl_init();
        $postFields = (is_array($data) ? json_encode($data) : $data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Strings::escapeSequenceDecode($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch) || !$response) {
            throw new \Exception('Ocorreu um erro na sua requisição');
        }

        curl_close($ch);

        $oldResponse = $response;
        $response = @gzdecode($response);

        if(!trim($response)){
            $response = json_encode(['msg' => $oldResponse, 'acao' => 1]);
            $info['http_code'] = 500;
        }

        return array(
            'response' => $response,
            'info' => $info
        );
    }

    public static function sendGetJson($url, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch) || !$response) {
            throw new \Exception('Ocorreu um erro na sua requisição');
        }

        curl_close($ch);

        $oldResponse = $response;
        $response = @gzdecode($response);

        if(!trim($response)){
            $response = json_encode(['msg' => $oldResponse, 'acao' => 1]);
            $info['http_code'] = 500;
        }

        return array(
            'response' => $response,
            'info' => $info
        );
    }

    public static function sendDeleteJson($url, $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch) || !$response) {
            throw new \Exception('Ocorreu um erro na sua requisição');
        }

        curl_close($ch);

        $oldResponse = $response;
        $response = @gzdecode($response);

        if(!trim($response)){
            $response = json_encode(['msg' => $oldResponse, 'acao' => 1]);
            $info['http_code'] = 500;
        }

        return array(
            'response' => $response,
            'info' => $info
        );
    }

    public static function sendPutJson($url, $data, $headers = [])
    {
        $ch = curl_init();
        $postFields = (is_array($data) ? json_encode($data) : $data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, Strings::escapeSequenceDecode($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (curl_errno($ch) || !$response) {
            throw new \Exception('Ocorreu um erro na sua requisição');
        }

        curl_close($ch);

        $oldResponse = $response;
        $response = @gzdecode($response);

        if(!trim($response)){
            $response = json_encode(['msg' => $oldResponse, 'acao' => 1]);
            $info['http_code'] = 500;
        }

        return array(
            'response' => $response,
            'info' => $info
        );
    }
}