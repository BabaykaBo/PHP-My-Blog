<?php

/**
 * User
 * 
 * A person that can log in to the site
 */
class User
{
    /**
     * Unique identification
     * 
     * @var int
     */
    public int $id;

    /**
     * Unique username
     * 
     * @var string
     */
    public string $username;

    /**
     * Password
     * 
     * @var string
     */
    public string $password;

    /**
     * Authenticate a user
     * 
     * @param object $conn Connection to DB
     * @param string $username Username
     * @param string $password Password
     * 
     * @return bool True if credentials are correct, false otherwise
     */
    public static function authenticate(object $conn, string $username, string $password): bool
    {

        $sql = "SELECT *
                FROM user
                WHERE username = :username;";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();

        if ($user = $stmt->fetch()) {

            return password_verify( $password, $user->password);
        } else {

            return false;
        }
    }
}
