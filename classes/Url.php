<?php

/**
 * Url
 * 
 * Response methods
 */
class Url
{
    /**
     * Redirect to another URL
     * 
     * @param string $path The path to redirect
     * 
     * @return void
     */
    public static function redirect($path): void
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

        header("Location: $protocol://{$_SERVER['HTTP_HOST']}$path");
    }
}
