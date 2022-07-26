<?php

class InputHelper
{
    /**
     * Проверяет введённые пользователем значения и обрабатывает их
     *
     * @param $postData
     * @param bool $isRegistration
     * @return array
     */
    public static function checkInputValues($postData, bool $isRegistration = false): array
    {
        $inputValues = [];

        if ($isRegistration) {
            if (isset($postData['password'])) {
                $login = InputHelper::processInputValue($postData['password']);
                $inputValues['password'] = $login;
            }
        }

        if (isset($postData['login'])) {
            $login = InputHelper::processInputValue($postData['login']);
            $inputValues['login'] = $login;
        }

        if (isset($postData['first_name'])) {
            $firstName = InputHelper::processInputValue($postData['first_name']);
            $inputValues['first_name'] = $firstName;
        }

        if (isset($postData['second_name'])) {
            $secondName = InputHelper::processInputValue($postData['second_name']);
            $inputValues['second_name'] = $secondName;
        }

        if (isset($postData['last_name'])) {
            $lastName = InputHelper::processInputValue($postData['last_name']);
            $inputValues['last_name'] = $lastName;
        }
        if (isset($postData)) {
            $email = InputHelper::processInputValue($postData['email']);
            $inputValues['email'] = $email;
        }

        if (isset($postData['phone'])) {
            $phone = InputHelper::processInputValue($postData['phone']);
            $inputValues['phone'] = $phone;
        }

        return $inputValues;
    }

    /**
     * Обработка введённых значений
     *
     * @param $value
     * @return string
     */
    public static function processInputValue($value): string
    {
        $value = stripslashes($value);
        $value = htmlspecialchars($value);

        return trim($value);
    }
}