<?php

declare(strict_types=1);

namespace App\Test\Unit;

use App\Controller\UserController;
use App\Entity\User;
use App\Test\Resource\Fixture\UserFixtures;
use Doctrine\DBAL\Exception;
use PHPUnit\Framework\TestCase;
use App\App;

use function PHPUnit\Framework\assertEquals;

require __DIR__ . '/../../bootstrap.php';

class UserControllerTest extends TestCase
{
    private UserController $controller;

    public function setUp(): void
    {
        App::getEntityManager()->beginTransaction();
        $this->controller = new UserController();
        App::getEntityManager()->getConnection()->executeStatement("ALTER SEQUENCE users_id_seq RESTART WITH 1");
        App::getEntityManager()->getConnection()->executeStatement("UPDATE users SET id=nextval('users_id_seq')");
        App::getEntityManager()->clear();
    }

    public function tearDown(): void
    {
        App::getEntityManager()->rollback();
    }

    public function testAddUser(): void
    {
        $login = 'test';
        $mail = 'test@mail.ru';

        $this->controller->add($login, $mail);
        $user = $this->controller->getByLogin('test');
        $isAdded = $user !== null;

        self::assertTrue($isAdded);
        self::assertEquals($user->getMail(), $mail);
        self::assertEquals($user->getLogin(), $login);
    }

    public function testAddUserWithEmptyFields(): void
    {
        $login = 'test';
        $mail = 'test@mail.ru';

        self::assertFalse($this->controller->add('', $mail));
        self::assertFalse($this->controller->add($login, ''));
    }

    /** @throws Exception */
    public function testGetUser(): void
    {
        $userFixture = App::getFixturesLoader()->getFixture(UserFixtures::class);
        $userFixture->load(App::getEntityManager());

        $id = App::getEntityManager()->getRepository(User::class)->count();

        $givenUser = $this->controller->getUser($id);
        self::assertNotNull($givenUser);
        self::assertEquals(
            $givenUser,
            $this->controller->getByLogin($givenUser->getLogin())
        );
    }

    public function testRemove(): void
    {
        $userFixture = App::getFixturesLoader()->getFixture(UserFixtures::class);
        $userFixture->load(App::getEntityManager());

        self::assertTrue($this->controller->remove('1'));
        $givenUser = $this->controller->getUser(1);
        self::assertNull($givenUser);
        self::assertFalse($this->controller->remove('1'));
    }

    public function testGetAll()
    {
        $controllerCount = count($this->controller->getAll());
        $doctrineCount = App::getEntityManager()->getRepository(User::class)->count();

        assertEquals($controllerCount, $doctrineCount);
    }
}
