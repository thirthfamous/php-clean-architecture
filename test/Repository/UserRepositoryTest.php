<?php

namespace thirthfamous\Repository;

use thirthfamous\Config\Database;
use thirthfamous\Domain\User;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase 
{
    private UserRepository $userRepository;

    protected function setUp(): void {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $user = new User();
        $user->id = "farhan";
        $user->name = "Farhan";
        $user->password = "rahasia";

        $this->userRepository->save($user);
        
        $result = $this->userRepository->findById($user->id);

        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);
    }   
    
    public function findByIdNotFound()
    {
        $user = $this->userRepository->findById('not found');
        self::assertNull($user);
    }
    

}
