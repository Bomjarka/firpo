<?php

class Controller_Data_Import extends Controller
{
    /**
     * @return void
     */
    public function action_index()
    {
        session_start();
        $database = $_SESSION['database'];

        $userService = new UserService($database);
        $xmlService = new XMLService($database);
        $petOwnerService = new PetOwnerService($database);
        $petService = new PetService($database);

        $data['edit_data'] = '';

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $data = $this->getData($userId, $userService);
        } else {
            $data['is_logged'] = 'not_logged';
        }

        if (!empty($_FILES)) {
            $uploadedFile = $_FILES['uploaded_file'];
            $dataArray = $xmlService->parseXml($uploadedFile);

            if ($dataArray) {
                if (count($dataArray['User'] ) !== 2) {
                    foreach ($dataArray as $usersData) {
                        $this->processInput($usersData, $petOwnerService, $petService);
                    }
                } else {
                    $this->processInput($dataArray, $petOwnerService, $petService);
                }
            }
        }

        $data['sql'] = $this->getSQLRaw($database);

        $this->view->generate('data_import_view.php', 'template_view.php', $data);
    }

    /**
     * @param $dataArray
     * @param $petOwnerService
     * @param $petService
     * @return void
     */
    private function processInput($dataArray, $petOwnerService, $petService): void
    {
        foreach ($dataArray as $userData) {
            $petOwnerName = ($userData['@attributes']['Name']);
            $pets = $userData['Pets'];
            $petOwner = $petOwnerService::firstOrCreatePetOwner($petOwnerName);
            if ($petOwner) {
                if (array_key_exists(0, $pets['Pet'])) {
                    foreach ($pets as $petsData) {
                        foreach ($petsData as $petData) {
                            $petData = $petService::preparePetData($petData, $petOwner->id);
                            $petService::updateOrCreate($petData);
                        }
                    }
                } else {
                    $petData = $petService::preparePetData($pets['Pet'], $petOwner->id);
                    $petService::updateOrCreate($petData);
                }
            }
        }
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

    /**
     * @param $database
     * @return array|false
     */
    private function getSQLRaw($database)
    {
        return (new SQLTestQueryService($database))::getAllPeopleWithPetsOlderThreeYears();
    }

}
