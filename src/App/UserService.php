<?php

// src/App/UserService.php
namespace App;

class UserService {
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function register(User $user) {
        $name = $user->getName();
        $email = $user->getEmail();
        $this->database->save($name, $email);
    }

    public function findUserByEmail($email) {
        return $this->database->find($email);
    }
}
