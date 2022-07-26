<?php

class PetService extends Service
{
    /**
     * @param $data
     * @param $petOwnerId
     * @return array
     */
    public static function preparePetData($data, $petOwnerId): array
    {
        $petAttributes = $data['@attributes'];
        $petRewards = [];
        $petParents = [];
        if (array_key_exists('Rewards', $data)) {

            foreach ($data['Rewards']['Reward'] as $rewardData) {
                if (array_key_exists('@attributes', $rewardData)) {
                    $petRewards[] = $rewardData['@attributes']['Name'];
                } else {
                    $petRewards[] = $rewardData['Name'];
                }

            }
        }

        if (array_key_exists('Parents', $data)) {
            foreach ($data['Parents']['Parent'] as $parentData) {
                if (array_key_exists('@attributes', $parentData)) {
                    $petParents[] = $parentData['@attributes']['Code'];
                } else {
                    $petParents[] = $parentData['Code'];
                }
            }
        }

        $petData = [
            'owner_id' => $petOwnerId,
            'external_code' => $petAttributes['Code'],
            'name' => $data['Nickname']['@attributes']['Value'],
            'type' => $petAttributes['Type'],
            'breed' => $data['Breed']['@attributes']['Name'],
            'gender' => $petAttributes['Gender'],
            'age' => $petAttributes['Age'],
            'rewards' => $petRewards,
            'parents' => $petParents,
        ];

        return $petData;
    }

    /**
     * @param $petData
     * @return Pet
     */
    public static function createPet($petData): Pet
    {
        $dateTime = DateTimeHelper::getCurrentDateTime();

        $pet = new Pet();
        $pet->owner_id = $petData['owner_id'];
        $pet->external_code = $petData['external_code'];
        $pet->name = $petData['name'];
        $pet->type = $petData['type'];
        $pet->breed = $petData['breed'];
        $pet->gender = $petData['gender'];
        $pet->age = $petData['age'];
        $pet->created_at = $dateTime;
        $pet->updated_at = $dateTime;

        $pet->save();

        $pet = self::getPetByNameAndOwnerId($pet->name, $pet->owner_id);
        if (!empty($petData['rewards'])) {
            foreach ($petData['rewards'] as $reward) {
                self::addReward($reward, $pet);
            }
        }

        if (!empty($petData['parents'])) {
            foreach ($petData['parents'] as $parentExtrenalCode) {
                self::addParent($parentExtrenalCode, $pet);
            }
        }

        return $pet;
    }

    /**
     * @param $petData
     * @return void
     */
    public static function updateOrCreate($petData): void
    {
        $pet = self::getPetByNameAndOwnerId($petData['name'], $petData['owner_id']);
        if ($pet) {
            self::updatePet($pet, $petData);
        } else {
            self::createPet($petData);
        }

    }

    /**
     * @param Pet $pet
     * @param $newData
     * @return bool
     */
    public static function updatePet(Pet $pet, $newData): bool
    {
        $dateTime = DateTimeHelper::getCurrentDateTime();

        $pet->external_code = $newData['external_code'];
        $pet->owner_id = $newData['owner_id'];
        $pet->type = $newData['type'];
        $pet->breed = $newData['breed'];
        $pet->gender = $newData['gender'];
        $pet->age = $newData['age'];
        $pet->updated_at = $dateTime;

        if ($pet->save(false) != 0) {
            return true;
        }


        return false;
    }

    /**
     * @param $name
     * @param $owner_id
     * @return Pet|null
     */
    public static function getPetByNameAndOwnerId($name, $owner_id): ?\Pet
    {
        $getByNameAndOwnerIdQuery = "SELECT * FROM pets WHERE name = '$name' and owner_id = '$owner_id'";
        if (self::$database::getRow($getByNameAndOwnerIdQuery)) {
            return new Pet(self::$database::getRow($getByNameAndOwnerIdQuery));
        }

        return null;
    }

    /**
     * @param $externalCode
     * @return Pet|null
     */
    public static function getPetByExtrnalCode($externalCode): ?\Pet
    {
        $getByNameAndOwnerIdQuery = "SELECT * FROM pets WHERE external_code = '$externalCode'";

        if (self::$database::getRow($getByNameAndOwnerIdQuery)) {
            return new Pet(self::$database::getRow($getByNameAndOwnerIdQuery));
        }

        return null;
    }

    /**
     * @param $reward
     * @param $pet
     * @return mixed
     */
    private static function addReward($reward, $pet)
    {
        $insertRewardQuery = "INSERT INTO pet_rewards (pet_id, name, created_at, updated_at)
            VALUES ('$pet->id',
                    '$reward',
                    'now()',
                    'now()'
                    )";

        return parent::$database::add($insertRewardQuery);
    }

    /**
     * @param $parentExtrenalCode
     * @param $pet
     * @return mixed
     */
    private static function addParent($parentExtrenalCode, $pet)
    {
        $insertRewardQuery = "INSERT INTO pet_parents (pet_id, parent_external_code, created_at, updated_at)
            VALUES ('$pet->id',
                    '$parentExtrenalCode',
                    'now()',
                    'now()'
                    )";

        return parent::$database::add($insertRewardQuery);
    }
}