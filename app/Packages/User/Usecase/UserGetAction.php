<?php

namespace App\Packages\User\Usecase;

use App\Packages\Shared\Usecase\UsecaseException;
use App\Packages\User\Domain\UserId;
use App\Packages\User\Domain\UserRepositoryInterface;
use App\Packages\User\Domain\UserService;


class UserGetAction
{
    private readonly UserRepositoryInterface $userRepository;
    private readonly UserService $userService;


    public function __construct(UserRepositoryInterface $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function __invoke(int $userId)
    {
        $user = $this->userRepository->findById(new UserId($userId));
        
        if($user == null) {
            throw new UsecaseException('ID:'.$userId.' のユーザーは存在しません', 404);
        }

        return new UserData($user);
    }
}