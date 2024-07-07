<?php

// tests/DatabaseTest.php

use PHPUnit\Framework\TestCase;
use App\Database;

class DatabaseTest extends TestCase
{
    protected static $pdo; // Propriété statique pour stocker l'objet PDO partagé entre les tests

    public static function setUpBeforeClass(): void
    {
        // Méthode appelée une seule fois avant l'exécution des tests de la classe DatabaseTest
        // Connexion à la base de données de test 'testing-php' avec PDO
        self::$pdo = new PDO('mysql:host=localhost;dbname=testing-php', 'root', '');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Définition du mode de gestion des erreurs
    }

    public function testSaveAndFind()
    {
        // Méthode de test pour tester la méthode save() et find() de la classe Database
        $database = new Database(self::$pdo); // Création d'une instance de Database avec l'objet PDO configuré
        $database->save('John Doe', 'john.doe@example.com'); // Appel de la méthode save() avec des données d'exemple
        $user = $database->find('john.doe@example.com'); // Recherche de l'utilisateur inséré dans la base de données
        $this->assertEquals('john.doe@example.com', $user['email']); // Assertion pour vérifier l'email de l'utilisateur trouvé
    }

    public function testFindNonExistingKey()
    {
        // Méthode de test pour tester la recherche d'une clé inexistante avec la méthode find()
        $database = new Database(self::$pdo); // Création d'une nouvelle instance de Database avec l'objet PDO configuré
        $user = $database->find('Non Existing'); // Recherche d'un utilisateur qui n'existe pas dans la base de données
        $this->assertFalse($user); // Assertion pour vérifier que le résultat est false (utilisateur non trouvé)
    }

    // Cas de figure d'échec
    public function testSaveWithoutName()
    {
        $database = new Database(self::$pdo);
        $result = $database->save('', 'john.doe@example.com');
        $this->assertFalse($result); // La sauvegarde devrait échouer car le nom est vide
    }

    public function testSaveWithoutEmail()
    {
        $database = new Database(self::$pdo);
        $result = $database->save('John Doe', '');
        $this->assertFalse($result); // La sauvegarde devrait échouer car l'email est vide
    }

    public function testSaveWithoutNameAndEmail()
    {
        $database = new Database(self::$pdo);
        $result = $database->save('', '');
        $this->assertFalse($result); // La sauvegarde devrait échouer car le nom et l'email sont vides
    }
}
