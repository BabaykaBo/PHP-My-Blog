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

    /**
     * Log in using the session
     * 
     * @return void
     */
    public static function login(): void
    {
        session_regenerate_id(true);

        $_SESSION['is_logged_in'] = true;
    }

    /**
     * Log out using the session
     * 
     * @return void
     */
    public static function logout(): void
    {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }
}
