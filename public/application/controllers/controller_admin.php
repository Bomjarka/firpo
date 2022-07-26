<?php

class Controller_Admin extends Controller
{

    /**
     * @return void
     */
    public function action_index()
	{
        session_start();
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logoutbutton'])) {
            AuthorizationService::logout();
        }

        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 'no') {
            $data['error'] = 'access_denied';
        }

		$this->view->generate('admin_view.php', 'template_view.php', $data);
	}
}