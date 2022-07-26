<?php

class PetOwnerService extends Service
{
    /**
     * @param $petOwnerName
     * @return PetOwner|null
     */
    public static function firstOrCreatePetOwner($petOwnerName): ?\PetOwner
    {
        return self::getPetOwnerByName($petOwnerName) ?? self::createPetOwner($petOwnerName);
    }

    /**
     * @param $petOwnerName
     * @return PetOwner|null
     */
    public static function createPetOwner($petOwnerName): ?\PetOwner
    {
        $isPetOwnerExists = self::checkDataForDuplicating($petOwnerName);

        if ($isPetOwnerExists) {
            return null;
        }

        $dateTime = DateTimeHelper::getCurrentDateTime();

        $petOwner = new PetOwner();
        $petOwner->name = $petOwnerName;
        $petOwner->created_at = $dateTime;
        $petOwner->updated_at = $dateTime;

        $petOwner->save();

        return self::getPetOwnerByName($petOwner->name);
    }

    /**
     * @param $petOwner
     * @param $newName
     * @return bool
     */
    public static function updatePetOwner($petOwner, $newName): bool
    {
        $dateTime = DateTimeHelper::getCurrentDateTime();
        $isPetOwnerExists = self::checkDataForDuplicating($newName, $petOwner);

        if ($isPetOwnerExists) {
            return false;
        }

        $petOwner->login = $newName['name'];
        $petOwner->updated_at = $dateTime;

        if ($petOwner->save(false) != 0) {
            return true;
        }

        return false;
    }

    /**
     * @param $name
     * @param PetOwner|null $petOwner
     * @return bool
     */
    public static function checkDataForDuplicating($name, PetOwner $petOwner = null): bool
    {
        $petOwnerName = self::getPetOwnerNameFromDatabase($name, $petOwner);

        if ($petOwnerName) {
            return true;
        }

        return false;
    }

    /**
     * @param $name
     * @param $petOwner
     * @return mixed|null
     */
    private static function getPetOwnerNameFromDatabase($name, $petOwner)
    {
        if ($petOwner) {
            $queryPetOwnerName = "SELECT name FROM pet_owners WHERE name = '$name' AND id != '$petOwner->id'";
        } else {
            $queryPetOwnerName = "SELECT name FROM pet_owners WHERE name = '$name'";
        }

        return self::$database::getValue($queryPetOwnerName);
    }

    /**
     * @param $name
     * @return PetOwner|null
     */
    public static function getPetOwnerByName($name): ?\PetOwner
    {
        $getByNameQuery = "SELECT * FROM pet_owners WHERE name = '$name'";

        if (self::$database::getRow($getByNameQuery)) {
            return new PetOwner(self::$database::getRow($getByNameQuery));
        }

        return null;
    }
}