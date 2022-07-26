<?php


class PasswordService
{
    /**
     * @param $password
     * @return false|string|null
     */
    function makePassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param $inputedPassword
     * @param $userPassword
     * @return bool
     */
    function checkPassword($inputedPassword, $userPassword): bool
    {
        return password_verify($inputedPassword, $userPassword);
    }

}