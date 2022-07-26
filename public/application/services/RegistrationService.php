<?php

class RegistrationService extends Service
{
    /**
     * @param $registrationData
     * @return false|User
     */
    public function registerUser($registrationData, UserService $userService)
    {
        $isUserExists = $userService::checkDataForDuplicating($registrationData['phone'], $registrationData['email'], $registrationData['login']);
        if ($isUserExists) {
            return false;
        }
        $user = $userService::createUser($registrationData);

        return $user;
    }
}