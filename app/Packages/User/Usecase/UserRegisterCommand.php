<?php

namespace App\Packages\User\Usecase;

class UserRegisterCommand
{
    public string $userName;
    public string $userNameFurigana;
    public string $userGender;
    public int $userBirthdayYear;
    public int $userBirthdayMonth;
    public string $userEmail;
    public string $userPassword;
    public string $userPostalCode;
    public string $userAddressPrefectures;
    public string $userAddressMunicipalities;
    public string $userAddressOthers;
    public string $userTel;
    public bool $userEmailMagazineSubscription;

    public function __construct(
        string $userName,
        string $userNameFurigana,
        string $userGender,
        int $userBirthdayYear,
        int $userBirthdayMonth,
        string $userEmail,
        string $userPassword,
        string $userPostalCode,
        string $userAddressPrefectures,
        string $userAddressMunicipalities,
        string $userAddressOthers,
        string $userTel,
        bool $userEmailMagazineSubscription,
    )
    {
        $this->userName = $userName;
        $this->userNameFurigana = $userNameFurigana;
        $this->userGender = $userGender;
        $this->userBirthdayYear = $userBirthdayYear;
        $this->userBirthdayMonth = $userBirthdayMonth;
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
        $this->userPostalCode = $userPostalCode;
        $this->userAddressPrefectures = $userAddressPrefectures;
        $this->userAddressMunicipalities = $userAddressMunicipalities;
        $this->userAddressOthers = $userAddressOthers;
        $this->userTel = $userTel;
        $this->userEmailMagazineSubscription = $userEmailMagazineSubscription;
    }
}