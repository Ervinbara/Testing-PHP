<?php

// src/App/Database.php

namespace App;

use PDO;
use PDOException;

class Database
{
    private $pdo; // Propriété pour stocker l'objet PDO

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo; // Initialisation de l'objet PDO dans le constructeur
    }

    public function save($name, $email)
    {
        if (empty($name) || empty($email)) {
            return false; // Retourne false si le nom ou l'email sont vides
        }

        try {
            // Préparation de la requête d'insertion avec des paramètres nommés
            $stmt = $this->pdo->prepare("INSERT INTO user (name, email) VALUES (:name, :email)");
            $stmt->bindParam(':name', $name); // Liaison du paramètre :name avec la valeur de $name
            $stmt->bindParam(':email', $email); // Liaison du paramètre :email avec la valeur de $email
            $stmt->execute(); // Exécution de la requête d'insertion
            
            return true; // Retourne true si la sauvegarde est réussie
        } catch (PDOException $e) {
            // Gérer l'erreur en cas d'échec de la requête
            // Vous pouvez logger l'erreur ou renvoyer une exception personnalisée si nécessaire
            error_log("Erreur lors de l'insertion dans la base de données : " . $e->getMessage());
            return false;
        }
    }

    public function find($email)
    {
        // Préparation de la requête de sélection avec un paramètre nommé
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email); // Liaison du paramètre :email avec la valeur de $email
        $stmt->execute(); // Exécution de la requête de sélection
        return $stmt->fetch(PDO::FETCH_ASSOC); // Récupération du résultat de la requête sous forme de tableau associatif
    }
}
