<?php

namespace Integration;

use App\Controller\UserController;
use App\Model\Database;
use App\Model\UserModel;
use App\Utils\UnitOfWork;
use PHPUnit\Framework\TestCase;
use Exception;
use \PDO;

class UserControllerIntegrationTest extends TestCase
{
    protected UserModel $userModel;
    protected UserController $controller;

    public function setUp(): void
    {
        $stmt = UnitOfWork::getDb()->getPdo()->prepare("
        CREATE TABLE users_test (
           id SERIAL PRIMARY KEY,
           login VARCHAR(200),
           registration_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        $stmt->execute();
        $this->userModel = new UserModel(UnitOfWork::getDb());
        $this->controller = new UserController($this->userModel);
    }

    public function tearDown(): void
    {
        $query = "DROP TABLE users_test";
        $stmt = UnitOfWork::getDb()->getPdo()->prepare($query);
        $stmt->execute();
    }

    /**
     * @return void
     * @throws Exception
     * @test
     */
    public function testInvalidLogin(): void
    {
        $this->expectException(Exception::class);
        $login = '';
        $result = $this->controller->add('', 'users_test');
    }

    /**
     * @return void
     * @throws Exception
     * @test
     */
    public function testAddUser(): void
    {
        $login = 'testLogin';

        $result = $this->controller->add($login, 'users_test');
        $this->assertTrue($result);

        $query = "SELECT * FROM users_test WHERE login = :login";

        $stmt = UnitOfWork::getDb()->getPdo()->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($user);
        $this->assertEquals($login, $user['login']);
    }

    public function testRemoveUser(): void
    {
        $login = 'testLogin';
        $this->controller->add($login, 'users_test');
        $result = $this->controller->remove(1);
        $this->assertTrue($result);
        $result = $this->controller->remove(1);
        $this->assertTrue($result);
        $this->assertFalse($this->controller->remove(''));
    }

}
