<?php

namespace thirthfamous\Service;

use thirthfamous\Domain\User;
use thirthfamous\Config\Database;
use thirthfamous\Model\UserLoginRequest;
use thirthfamous\Model\UserLoginResponse;
use thirthfamous\Model\UserRegisterRequest;
use thirthfamous\Repository\UserRepository;
use thirthfamous\Model\UserRegisterResponse;
use thirthfamous\Exception\ValidationException;

class UserService  
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $this->validateUserRegistrationRequest($request);

        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->id);
            if($user != null) {
                throw new ValidationException("User ID already exists");
            }
            $user = new User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;
            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request) {
        if($request->id == null || $request->name == null || $request->password == null || trim($request->id) == "" || trim($request->name) == "" || trim($request->password) == "")
        {
            throw new ValidationException("id, Name, Password cannot blank");
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $this->validateUserLoginRequest($request);

        $user = $this->userRepository->findById($request->id);
        if($user == null) {
            throw new ValidationException("Id or password is wrong");
        }

        if(password_verify($request->password, $user->password)){
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;
        }else{
            throw new ValidationException("Id or password is wrong");
        }
    }

    private function validateUserLoginRequest(UserLoginRequest $request)
    {
        if($request->id == null || $request->password == null || trim($request->id) == "" || trim($request->password) == "")
        {
            throw new ValidationException("id, Password cannot blank");
        }
    }
}

