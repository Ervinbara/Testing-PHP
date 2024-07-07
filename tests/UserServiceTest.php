<?php

// tests/UserServiceTest.php
use PHPUnit\Framework\TestCase;
use App\User;
use App\UserService;
use App\Database; // Assurez-vous d'importer correctement la classe Database

class UserServiceTest extends TestCase
{
    protected static $pdo;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new PDO('mysql:host=localhost;dbname=testing-php', 'root', '');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function testRegisterAndFindUser()
    {
        $userService = new UserService(new Database(self::$pdo));

        // Créer un utilisateur avec un nom différent
        $user = new User('Jane Smith', 'jane.smith@example.com');

        // Enregistrer l'utilisateur en utilisant register()
        $userService->register($user);

        // Récupérer l'utilisateur enregistré
        $savedUser = $userService->findUserByEmail('jane.smith@example.com');
        echo 'Saved User:';
        var_dump($savedUser);
        // Assertions pour vérifier que l'utilisateur a bien été enregistré et retrouvé
        $this->assertEquals('Jane Smith', $savedUser['name']);
        $this->assertEquals('jane.smith@example.com', $savedUser['email']);
    }
}
