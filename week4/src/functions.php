<?php

function base_url()
{
    $base = sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
    $folder = '/avansplus_backend/week4';
    $address = $base . $folder;
    return $address;
}
