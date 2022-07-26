<?php

class UserService extends Service
{
    public static function prepareUserData($login, $password, $firstName, $secondName, $lastName, $phone, $email): array
    {
        $userData = [
            'login' => $login,
            'password' => (new PasswordService())->makePassword($password),
            'firstName' => $firstName,
            'secondName' => $secondName,
            'lastName' => $lastName,
            'phone' => $phone,
            'email' => $email,
        ];

        return $userData;
    }

    /**
     * @param $userData
     * @return User
     */
    public static function createUser($userData): User
    {
        $dateTime = DateTimeHelper::getCurrentDateTime();

        $user = new User();
        $user->login = $userData['login'];
        $user->password = $userData['password'];
        $user->firstName = $userData['firstName'];
        $user->secondName = $userData['secondName'];
        $user->lastName = $userData['lastName'];
        $user->phone = $userData['phone'];
        $user->email = $userData['email'];
        $user->created_at = $dateTime;
        $user->updated_at = $dateTime;

        $user->save();

        return $user;
    }

    /**
     * @param $login
     * @return User|null
     */
    public static function getUserByLogin($login): ?User
    {
        $getUserQuery = "SELECT * FROM users WHERE login = '$login'";

        if (self::$database::getRow($getUserQuery)) {
            return new User(self::$database::getRow($getUserQuery));
        } else {
            return null;
        }
    }

    /**
     * @param $id
     * @return User|null
     */
    public static function getUserById($id): ?User
    {
        $getUserQuery = "SELECT * FROM users WHERE id = '$id'";

        if (self::$database::getRow($getUserQuery)) {
            return new User(self::$database::getRow($getUserQuery));
        } else {
            return null;
        }
    }

    /**
     * @param $user
     * @param $newData
     * @return bool
     */
    public static function updateUser($user, $newData): bool
    {
        $dateTime = DateTimeHelper::getCurrentDateTime();
        $isUserExists = self::checkDataForDuplicating($newData['phone'], $newData['email'], $newData['login'], $user);

        if (!$isUserExists) {
            $user->login = $newData['login'];
            $user->firstName = $newData['first_name'];
            $user->secondName = $newData['second_name'];
            $user->lastName = $newData['last_name'];
            $user->phone = $newData['phone'];
            $user->email = $newData['email'];
            $user->updated_at = $dateTime;

            if ($user->save(false) != 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $phone
     * @param $email
     * @param $login
     * @param User|null $user
     * @return bool
     */
    public static function checkDataForDuplicating($phone, $email, $login, User $user = null): bool
    {
        $phone = self::isPhoneExists($phone, $user);
        $email = self::isEmailExists($email, $user);
        $login = self::isLoginExists($login, $user);

        if ($login || $email || $phone) {
            return true;
        }

        return false;
    }

    /**
     * @param $phone
     * @param $user
     * @return mixed|null
     */
    private static function isPhoneExists($phone, $user)
    {
        if ($user) {
            $queryUserPhone = "SELECT phone FROM users WHERE phone = '$phone' AND id != '$user->id'";

        } else {
            $queryUserPhone = "SELECT phone FROM users WHERE phone = '$phone'";
        }

        return self::$database::getValue($queryUserPhone);
    }

    /**
     * @param $login
     * @param $user
     * @return mixed|null
     */
    private static function isLoginExists($login, $user)
    {
        if ($user) {
            $queryUserLogin = "SELECT login FROM users WHERE login = '$login' AND id != '$user->id'";
        } else {
            $queryUserLogin = "SELECT login FROM users WHERE login = '$login'";
        }

        return self::$database::getValue($queryUserLogin);
    }

    /**
     * @param $email
     * @param $user
     * @return mixed|null
     */
    private static function isEmailExists($email, $user)
    {
        if ($user) {
            $queryUserEmail = "SELECT email FROM users WHERE email = '$email' AND id != '$user->id'";
        } else {
            $queryUserEmail = "SELECT email FROM users WHERE email = '$email'";
        }

        return self::$database::getValue($queryUserEmail);
    }
}