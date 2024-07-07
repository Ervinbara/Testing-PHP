<?php

// Inclusion de la classe TestCase de PHPUnit
use PHPUnit\Framework\TestCase;

// Inclusion de la classe User à tester
use App\User;

// Déclaration de la classe de test UserTest qui étend TestCase
class UserTest extends TestCase {

    // Méthode de test pour tester la méthode getName() de la classe User
    public function testGetName() {
        // Création d'une nouvelle instance de la classe User avec les données 'John Doe' et 'john.doe@example.com'
        $user = new User('John Doe', 'john.doe@example.com');

        // Assertion : vérifie si le résultat de $user->getName() est égal à 'John Doe'
        $this->assertEquals('John Doe', $user->getName());
    }

    // Méthode de test pour tester la méthode getEmail() de la classe User
    public function testGetEmail() {
        // Création d'une nouvelle instance de la classe User avec les données 'John Doe' et 'john.doe@example.com'
        $user = new User('John Doe', 'john.doe@example.com');

        // Assertion : vérifie si le résultat de $user->getEmail() est égal à 'john.doe@example.com'
        $this->assertEquals('john.doe@example.com', $user->getEmail());
    }
}
