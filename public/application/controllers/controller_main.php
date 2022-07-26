<?php

class Controller_Main extends Controller
{

    /**
     * @return void
     */
    function action_index()
    {
        session_start();
        $database = DatabaseService::getDatabase();
        $testDataGenerator = new TestDataGenerator($database);
        $_SESSION['database'] = $database;
        //Для тестов при первом открытии страницы и отсутствии юзеров создаём админа
       if (!(new Functions)->isAdminExists($database)) {
           $testDataGenerator::createAdmin();
       }

        $this->view->generate('main_view.php', 'template_view.php');
    }
}