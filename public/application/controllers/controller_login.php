<?php

class Controller_Login extends Controller
{

    /**
     * @return void
     */
    public function action_index()
	{
        session_start();
        if (isset($_SESSION['user_id']))
        {
            header('Location:cabinet');
        }
        $userService = new UserService($_SESSION['database']);
        $authorizationService = new AuthorizationService($_SESSION['database']);

		if(isset($_POST['login']) && isset($_POST['password']))
		{
			$login = InputHelper::processInputValue($_POST['login']);
			$password = InputHelper::processInputValue($_POST['password']);
            $data["login_status"] = "access_denied";

            if (strlen($login) == 0 && strlen($password) == 0) {
                $this->action_error($data);
            }

            $user = $userService::getUserByLogin($login);
            if ($user) {
                $isUserAithorized = $authorizationService->authorizeUser($user, $password);
                if ($isUserAithorized) {
                    $isAdmin = $authorizationService->isAdmin($user);
                    $data["login_status"] = "access_granted";
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['is_admin'] = 'no';
                    if ($isAdmin) {
                        $_SESSION['is_admin'] = 'yes';
                        header('Location:/admin');
                    } else {
                        header('Location:cabinet');
                    }
                } else {
                    $this->action_error($data);
                }
            } else {
                $this->action_error($data);
            }
		}
        $this->view->generate('login_view.php', 'template_view.php');
	}

    /**
     * @param $data
     * @return void
     */
    private function action_error($data): void
    {
        $this->view->generate('login_view.php', 'template_view.php', $data);
    }
}
