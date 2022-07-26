<?php

/**
 * @property int $id;
 * @property int $owner_id;
 * @property int $external_code;
 * @property string $name;
 * @property string $type;
 * @property string $gender;
 * @property string $breed;
 * @property int age;
 * @property DateTime $created_at;
 * @property DateTime $updated_at;
 */
class Pet extends Model
{
    protected $table = 'pets';

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
            $this->owner_id = $petOwnerData['owner_id'];
            $this->external_code = $petOwnerData['external_code'];
            $this->type = $petOwnerData['type'];
            $this->breed = $petOwnerData['breed'];
            $this->gender = $petOwnerData['gender'];
            $this->age = $petOwnerData['age'];
            $this->created_at = $dateTime;
            $this->updated_at = $dateTime;
        }
    }

    /**
     * Сохраняет данные в БД
     *
     * @param bool $isNewPet
     * @return bool|int|string
     */
    public function save(bool $isNewPet = true)
    {
        if ($isNewPet) {
            $insertUserQuery = "INSERT INTO $this->table (owner_id, external_code, name, type, breed, gender, age, created_at, updated_at)
            VALUES ('$this->owner_id',
                    '$this->external_code',
                    '$this->name',
                    '$this->type',
                    '$this->breed',
                    '$this->gender',
                    '$this->age',
                    '$this->created_at',
                    '$this->updated_at'
                    )";

            return parent::$database::add($insertUserQuery);
        }

        $updateUserQuery = "UPDATE $this->table SET
            owner_id = '$this->owner_id',
            external_code = '$this->external_code',
            name = '$this->name',
            type = '$this->type',
            breed = '$this->breed',
            gender = '$this->gender',
            age = '$this->age',
            updated_at = '$this->updated_at'
            WHERE id = '$this->id'";

        return parent::$database::set($updateUserQuery);
    }
}