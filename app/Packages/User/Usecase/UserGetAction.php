<?php

namespace App\Packages\User\Usecase;

use App\Packages\User\Domain\User;
use App\Packages\User\Domain\UserName;
use App\Packages\User\Domain\UserAddress;
use App\Packages\User\Domain\UserBirthday;
use App\Packages\User\Domain\UserEmail;
use App\Packages\User\Domain\UserEmailMagazineSubscription;
use App\Packages\User\Domain\UserGender;
use App\Packages\User\Domain\UserId;
use App\Packages\User\Domain\UserNameFurigana;
use App\Packages\User\Domain\UserPassword;
use App\Packages\User\Domain\UserPostalCode;
use App\Packages\User\Domain\UserRepositoryInterface;
use App\Packages\User\Domain\UserService;
use App\Packages\User\Domain\UserTel;
use Exception;
use Illuminate\Support\Facades\DB;

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
        echo $userId;
        $user = $this->userRepository->findById(new UserId($userId));
        return new UserData($user);
    }
}