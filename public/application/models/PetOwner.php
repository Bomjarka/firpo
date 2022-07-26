<?php

/**
 * @property int $id;
 * @property string $name;
 * @property DateTime $created_at;
 * @property DateTime $updated_at;
 */
class PetOwner extends Model
{
    protected $table = 'pet_owners';

    /**
     * @param $petOwnerData
     */
    public function __construct($petOwnerData = null)
    {
        parent::__construct();
        $dateTime = DateTimeHelper::getCurrentDateTime();
        if ($petOwnerData) {
            $this->id = $petOwnerData['id'];
            $this->name = $petOwnerData['name'];
            $this->created_at = $dateTime;
            $this->updated_at = $dateTime;
        }
    }

    /**
     * Сохраняет данные в БД
     *
     * @param bool $isNewPetOwner
     * @return bool|int|string
     */
    public function save(bool $isNewPetOwner = true)
    {
        if ($isNewPetOwner) {
            $insertPetOwnerQuery = "INSERT INTO $this->table (name, created_at, updated_at)
            VALUES ('$this->name',
                    '$this->created_at',
                    '$this->updated_at'
                    )";

            return parent::$database::add($insertPetOwnerQuery);
        } else {
            $updateUserQuery = "UPDATE $this->table SET
                name = '$this->name',            
                updated_at = '$this->updated_at'
                WHERE id = '$this->id'";

            return parent::$database::set($updateUserQuery);
        }
    }
}