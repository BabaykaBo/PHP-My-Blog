<?php
/**
 * Auth
 * 
 * Login and logout checking
 */
class Auth
{

    /**
     * Check if user is logged in
     * 
     * @return boolean true if user is logged in or false if not
     */
    public static function isLoggedIn(): bool
    {
        return (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']);
    }
}
