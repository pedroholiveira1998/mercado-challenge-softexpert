<?php

function json($data, $statusCode = 200)
{
    if (!headers_sent()) {
        header('Content-Type: application/json', true, $statusCode);
        echo json_encode($data);
        exit;
    } else {
        throw new Exception('Os cabeçalhos HTTP já foram enviados.');
    }
}