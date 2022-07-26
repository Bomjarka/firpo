<?php

class Controller_Cabinet extends Controller
{
    /**
     * @return void
     */
    public function action_index()
	{
		session_start();
        $userService = new UserService($_SESSION['database']);
        $data['edit_data'] = '';

		if (isset($_SESSION['user_id']))
		{
            $userId = $_SESSION['user_id'];
            $data = $this->getData($userId, $userService);
        } else {
            $data['is_logged'] = 'not_logged';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logoutbutton'])) {
            AuthorizationService::logout();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edituserdatabutton'])) {
            $data['edit_data'] = 'edit_user_data';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateuserdatabutton'])) {
            $inputValues =  InputHelper::checkInputValues($_POST);
            $user = $userService::getUserById($userId);
            $isUserUpdated = $userService::updateUser($user, $inputValues);
            $data = $this->getData($userId, $userService);

            if ($isUserUpdated) {
                $data['data_updated'] = 'success';
            } else {
                $data['data_updated'] = 'failed';
            }
        }

        $this->view->generate('cabinet_view.php', 'template_view.php', $data);
    }

    /**
     * @param int $userId
     * @param UserService $userService
     * @return array
     */
    private function getData(int $userId, UserService $userService): array
    {
        $user = $userService::getUserById($userId);
        $data['user'] = $user;
        $data['is_logged'] = 'logged';

        return $data;
    }

}
