<?php

class AuthorizationService extends Service
{
    /**
     * @param $user
     * @param $password
     * @return bool
     */
    public function authorizeUser($user, $password): bool
    {
        $isVerifed = (new PasswordService())->checkPassword($password, $user->password);

        return $isVerifed;
    }

    /**
     * @param $user
     * @return mixed
     */
    public function isAdmin($user)
    {
        $bool = DatabaseService::getDefaultBool();
        $isAdminQuery = "SELECT * FROM administrators WHERE user_id = '$user->id' AND is_active = '$bool'";
        $isAdmin = self::$database::getRow($isAdminQuery);

        return $isAdmin;
    }

    /**
     * @return void
     */
    public static function logout()
    {
        session_destroy();
        header('Location:/');
    }
}