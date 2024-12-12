<?php

use \Firebase\JWT\JWT;

function createJWT($userId)
{
    $key = getenv("JWT_secret");
    $payload = [
        'iat' => time(),
        'exp' => time() + 3600,
        'data' =>
            $userId
        
    ];

    return JWT::encode($payload, $key, 'HS256');
}


// use Firebase\JWT\JWT;
// use Firebase\JWT\key;

// function createJWT($userId) {
//     $key = 'VikasSingh@123';
//     $payload = [
//         'iss' => 'localhost:8080',
//         'aud' => 'localhost:8080',
//         'iat' => time(),
//         'exp' => time() + (60 * 60),
//         'uid' => $userId
//     ];

//     return JWT::enccode($payload, $key, 'HS256');
// }

function validateJWT($jwt) {
    $key = getenv("JWT_secret");
    try {
        return JWT::decode($jwt, new \Firebase\JWT\key($key, 'HS256'))->data;
        
    } catch (Exception $e) {
        return null;
    }
}
