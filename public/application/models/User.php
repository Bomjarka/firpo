<?php

/**
 * @property int $id;
 * @property string $firstName;
 * @property string|null $secondName;
 * @property string $lastName;
 * @property string $phone;
 * @property string $email;
 * @property string $login;
 * @property string $password;
 * @property DateTime $created_at;
 * @property DateTime $updated_at;
 */
class User extends Model
{
    protected $table = 'users';

    /**
     * @param $petOwnerData
     */
    public function __construct($petOwnerData = null)
    {
        parent::__construct();
        $dateTime = DateTimeHelper::getCurrentDateTime();
        if ($petOwnerData) {
            $this->id = $petOwnerData['id'];
            $this->login = $petOwnerData['login'];
            $this->password = $petOwnerData['password'];
            $this->firstName = $petOwnerData['first_name'];
            $this->secondName = $petOwnerData['second_name'];
            $this->lastName = $petOwnerData['last_name'];
            $this->phone = $petOwnerData['phone'];
            $this->email = $petOwnerData['email'];
            $this->created_at = $dateTime;
            $this->updated_at = $dateTime;
        }
    }

    /**
     * Сохраняет пользовательские данные в БД
     *
     * @param bool $isNewUser
     * @return bool|int|string
     */
    public function save(bool $isNewUser = true)
    {
        if ($isNewUser) {
            $insertUserQuery = "INSERT INTO $this->table (login, password, first_name, second_name, last_name, phone, email, created_at, updated_at)
            VALUES ('$this->login',
                    '$this->password',
                    '$this->firstName',
                    '$this->secondName',
                    '$this->lastName',
                    '$this->phone',
                    '$this->email',
                    '$this->created_at',
                    '$this->updated_at'
                    )";

            return parent::$database::add($insertUserQuery);
        } else {
            $updateUserQuery = "UPDATE $this->table SET
                login = '$this->login',
                first_name = '$this->firstName',
                second_name = '$this->secondName',
                last_name = '$this->lastName',
                phone = '$this->phone',
                email = '$this->email',
                updated_at = '$this->updated_at'
                WHERE id = '$this->id'";

            return parent::$database::set($updateUserQuery);
        }
    }
}