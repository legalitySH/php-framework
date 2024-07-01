<?php


namespace Unit;

use App\Controller\UserController;
use App\Model\UserModel;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetUser()
    {
        $userModelMock = $this->createMock(UserModel::class);
        $userModelMock->expects($this->once())
            ->method('find')
            ->willReturn([
                'id' => 1,
                'username' => 'testuser'
            ]);

        $controller = new UserController($userModelMock);

        $result = $controller->getUser(1);
        $this->assertEquals(['id' => 1, 'username' => 'testuser'], $result);
    }

    /**
     * @throws Exception
     */
    public function testRemove()
    {
        $userModelMock = $this->createMock(UserModel::class);
        $userModelMock->expects($this->once())
            ->method('removeById')
            ->with($this->equalTo(1));

        $controller = new UserController($userModelMock);

        $result = $controller->remove('1');
        $this->assertTrue($result);
    }

    /**
     * @throws Exception
     * @test
     */
    public function testAdd()
    {
        $userModelMock = $this->createMock(UserModel::class);
        $userModelMock->expects($this->once())
            ->method('add')
            ->with($this->equalTo('testuser'));

        $controller = new UserController($userModelMock);

        $result = $controller->add('testuser');
        $this->assertTrue($result);
    }
}
