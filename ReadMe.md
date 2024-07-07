# Guide des Tests en PHP

## Introduction

Les tests automatisés sont essentiels pour garantir la fiabilité et la maintenabilité de votre code. Ils permettent de détecter les erreurs rapidement, facilitent les modifications et améliorent la qualité globale de votre application.

## Types de tests

### Tests unitaires

Les tests unitaires vérifient le comportement de petites unités de code de manière isolée, généralement au niveau des fonctions ou des méthodes. Ils sont rapides à exécuter et faciles à écrire.

#### Exemple de test unitaire

Supposons que nous ayons une fonction qui ajoute deux nombres :

```php
function add($a, $b) {
    return $a + $b;
}
Un test unitaire pour cette fonction pourrait ressembler à ceci :

use PHPUnit\Framework\TestCase;

class MathTest extends TestCase {
    public function testAdd() {
        $this->assertEquals(4, add(2, 2));
        $this->assertEquals(0, add(-1, 1));
    }
}
```
### Tests fonctionnels
Les tests fonctionnels vérifient que les fonctionnalités de l'application fonctionnent comme prévu. Ils simulent des scénarios réels d'utilisation de l'application et testent l'interaction entre plusieurs composants.

#### Exemple de test fonctionnel
Supposons que nous ayons un service d'enregistrement d'utilisateur :

```php
use PHPUnit\Framework\TestCase;
use App\UserService;
use App\User;
use App\Database;

class UserServiceTest extends TestCase {
    protected static $pdo;

    public static function setUpBeforeClass(): void {
        self::$pdo = new PDO('mysql:host=localhost;dbname=testing-php', 'root', '');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function testRegisterAndFindUser() {
        $userService = new UserService(new Database(self::$pdo));
        $user = new User('Jane Smith', 'jane.smith@example.com');
        $userService->register($user);
        $savedUser = $userService->findUserByEmail('jane.smith@example.com');

        $this->assertEquals('Jane Smith', $savedUser['name']);
        $this->assertEquals('jane.smith@example.com', $savedUser['email']);
    }
}
```
### Tests d'intégration
Les tests d'intégration vérifient que différents modules ou services de l'application fonctionnent correctement ensemble. Ils permettent de détecter des problèmes d'intégration entre les composants.

#### Exemple de test d'intégration
Supposons que nous ayons une base de données et un service de gestion d'utilisateurs. Un test d'intégration pourrait vérifier que l'enregistrement d'un utilisateur dans la base de données fonctionne correctement :

```php
use PHPUnit\Framework\TestCase;
use App\UserService;
use App\User;
use App\Database;

class UserServiceIntegrationTest extends TestCase {
    protected static $pdo;

    public static function setUpBeforeClass(): void {
        self::$pdo = new PDO('mysql:host=localhost;dbname=testing-php', 'root', '');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->exec("CREATE TABLE IF NOT EXISTS user (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), email VARCHAR(255))");
    }

    public function testRegisterAndFindUserIntegration() {
        $database = new Database(self::$pdo);
        $userService = new UserService($database);
        $user = new User('John Doe', 'john.doe@example.com');
        $userService->register($user);

        $savedUser = $userService->findUserByEmail('john.doe@example.com');

        $this->assertEquals('John Doe', $savedUser['name']);
        $this->assertEquals('john.doe@example.com', $savedUser['email']);
    }

    public static function tearDownAfterClass(): void {
        self::$pdo->exec("DROP TABLE IF EXISTS user");
    }
}
```

## Conclusion
Mettre en place des tests unitaires, fonctionnels et d'intégration est essentiel pour garantir la qualité de votre code. Les tests unitaires permettent de vérifier le comportement isolé des fonctions ou des méthodes, les tests fonctionnels valident les fonctionnalités globales de l'application, et les tests d'intégration assurent que les différents composants interagissent correctement entre eux. En combinant ces types de tests, vous pouvez avoir une couverture de test complète et fiable.
