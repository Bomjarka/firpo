<?php

class Controller_Registration extends Controller
{
    function action_index()
    {
        session_start();
        $userService = new UserService($_SESSION['database']);
        $registrationService = new RegistrationService($_SESSION['database']);
        if (isset($_SESSION['user_id']))
        {
            header('Location:cabinet');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $inputValues = InputHelper::checkInputValues($_POST, true);

            $login = $inputValues['login'];
            $password = $inputValues['password'];
            $firstName = $inputValues['first_name'];
            $secondName = $inputValues['second_name'];;
            $lastName = $inputValues['last_name'];
            $phone = $inputValues['phone'];
            $email = $inputValues['email'];

            if (!$login || !$password || !$firstName || !$secondName || !$lastName || !$phone || !$email) {
                $data['reg_status'] = "not_all_fields";
                $this->view->generate('registration_view.php', 'template_view.php', $data);
            } else {
                $userData = $userService::prepareUserData($login, $password, $firstName, $secondName, $lastName, $phone, $email);
                $user = $registrationService->registerUser($userData, $userService);
                if (!$user) {
                    $data['reg_status'] = "such_user_exists";
                    $this->view->generate('registration_view.php', 'template_view.php', $data);
                } else {
                    $registeredUser = $userService::getUserByLogin($login);
                    $data["reg_status"] = "registration_completed";
                    $_SESSION['user_id'] = $registeredUser->id;
                    header('Location:/cabinet/');
                }
            }
        }else {
            $this->view->generate('registration_view.php', 'template_view.php');
        }
    }
}
