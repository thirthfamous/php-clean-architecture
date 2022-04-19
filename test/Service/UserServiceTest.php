<?php

namespace thirthfamous\Service;

use PHPUnit\Framework\TestCase;
use thirthfamous\Domain\User;
use thirthfamous\Config\Database;
use thirthfamous\Model\UserLoginRequest;
use thirthfamous\Model\UserRegisterRequest;
use thirthfamous\Repository\UserRepository;
use thirthfamous\Exception\ValidationException;

class UserServiceTest extends TestCase 
{
    private UserService $userService;
    private UserRepository $userRepository;

    protected function setUp(): void {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);
        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess()
    {
        $request = new UserRegisterRequest();
        $request->id = 'farhan';
        $request->name = 'farhan';
        $request->password = 'rahasia';

        $response = $this->userService->register($request);

        self::assertEquals($request->id, $response->user->id);
        self::assertEquals($request->name, $response->user->name);
        self::assertNotEquals($request->password, $response->user->password);

        self::assertTrue(password_verify($request->password, $response->user->password));
    }   
    
    public function testRegisterFailed()
    {
        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "";
        $request->name = "";
        $request->password = "";

        $this->userService->register($request);

    }

    public function testRegisterDuplicate()
    {
        $user = new User();
        $user->id = 'farhan';
        $user->name = 'Farhan';
        $user->password = 'rahasia';

        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = 'farhan';
        $request->name = 'farhan';
        $request->password = 'rahasia';

        $this->userService->register($request);

    }

    public function testLoginNotFound()
    {
        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->id = 'farhan';
        $request->name = 'farhan';
        $request->password = 'rahasia';

        $this->userService->login($request);
    }

    public function testLoginWrongPassword()
    {
        $user = new User();
        $user->id = 'farhan';
        $user->name = 'farhan';
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->expectException(ValidationException::class);
        $request = new UserLoginRequest();
        $request->id = 'farhan';
        $request->name = 'farhan';
        $request->password = 'salah';

        $this->userService->login($request);
    }

    public function testLoginSuccess()
    {
        $user = new User();
        $user->id = 'farhan';
        $user->name = 'farhan';
        $user->password = password_hash("rahasia", PASSWORD_BCRYPT);

        $this->userRepository->save($user);

        $request = new UserLoginRequest();
        $request->id = 'farhan';
        $request->name = 'farhan';
        $request->password = 'rahasia';

        $response = $this->userService->login($request);
        self::assertEquals($request->id, $response->user->id);
        self::assertTrue(password_verify($request->password, $response->user->password));
    }
    

}
