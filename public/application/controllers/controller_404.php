<?php

class Controller_404 extends Controller
{

    /**
     * @return void
     */
    public function action_index()
    {
        session_start();
        $this->view->generate('404_view.php', 'template_view.php');
    }

}
