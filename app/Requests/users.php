<?php

require_once '/app/config/mysql.php';
/**
 * Récupère tous les utilisateurs en BDD
 * @return array
 */
function findAllUsers(): array
{
    global $db;

    // $query = "SELECT * FROM users";

    // $sql = $db->query($query);

    // return $sql->fetchAll();

    return $db
        ->query("SELECT * FROM users")
        ->fetchALL();
}


/**
 * Récupère un utilisateur en BDD en filtrant par son email
 * @param string $email Email de l'utilisateur à rechercher
 * @return bool|array
 */
function findOneUserByEmail(string $email): bool|array
{
    global $db;

    // $sql = $db->query("SELECT * FROM users WHERE email = '$email'");
    $sql = $db->prepare("SELECT * FROM users WHERE email = :email");
    $sql->execute([
        'email' => $email
    ]);

    return $sql->fetch();
}
/**
 * Créer un utilisateur en BDD
 * @param string $firstName Prénom de l'utilisateur
 * @param string $lastName Nom de l'utilisateur
 * @param string $email Email de l'utilisateur
 * @param string $password Mot de passe de l'utilisateur
 * @return bool 
 */

function createUser(string $firstName, string $lastName, string $email, string $password): bool
{
    global $db;

    try {
        $query = "INSERT INTO users(first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";

        $sql = $db->prepare($query);
        $sql->execute([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_ARGON2I),
        ]);
    } catch (PDOException $e) {
        return false;
    }

    return true;
}
