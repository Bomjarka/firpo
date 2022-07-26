<?php

class TestDataGenerator extends BaseGenerator
{

    /**
     * @return void
     */
    public static function generateData()
    {
        self::generateUsers(10);
        self::generateUsersWithEqualEmails(2, 'equalemai@gmail.com');
        self::generateUsersWithEqualEmails(3, 'testequals@gmail.com');
        self::generateOrdersForOneUser();
    }

    /**
     * Создаёт указанное количество тестовых пользователей в базе
     *
     * @param int $usersCount
     * @param string|null $requestedEmail
     * @return void
     */
    private static function generateUsers(int $usersCount = 50, string $requestedEmail = null)
    {
        $usersToCreate = $usersCount;

        while ($usersToCreate >= 0) {
            $dateTime = DateTimeHelper::getCurrentDateTime();
            $login = self::getRandomLogin();
            $password = (new PasswordService())->makePassword('qwerty');
            $firstName = self::getRandomName()['firstName'];
            $secondName = self::getRandomName()['secondName'];
            $lastName = self::getRandomName()['lastName'];
            $phone = self::getRandomPhone();
            if ($requestedEmail != null) {
                $email = $requestedEmail;
            } else {
                $email = self::getRandomEmail();
            }
            $createdAt = $dateTime;
            $updatedAt = $dateTime;

            $insertRandomUsersQuery = "INSERT INTO users (login, password, first_name, second_name, last_name, phone, email, created_at, updated_at)
            VALUES (
                    '$login',
                    '$password',
                    '$firstName',
                    '$secondName',
                    '$lastName',
                    '$phone',
                    '$email',
                    '$createdAt',
                    '$updatedAt'
            )";
            $userId = self::$database::add($insertRandomUsersQuery);

            self::generateOrder($userId);
            $usersToCreate--;
        }
    }

    /**
     * Создаёт указанное количество пользователей с определённым email
     *
     * @param int $usersCount
     * @param string|null $email
     * @return void
     */
    private static function generateUsersWithEqualEmails(int $usersCount, string $email = null)
    {
        self::generateUsers($usersCount, $email);
    }

    /**
     * Создаёт заказ для пользователя
     *
     * @param int $userId
     * @return void
     */
    private static function generateOrder(int $userId): void
    {
        $price = rand(10, 9999);
        $insertOrderQuery = "INSERT INTO orders (user_id, price) VALUES ('$userId', '$price')";

        self::$database::add($insertOrderQuery);
    }

    /**
     * Создаёт несколько заказов для последнего пользователя из базы
     *
     * @return void
     */
    private static function generateOrdersForOneUser()
    {
        $user = self::getLastUser();
        $i = 0;
        while ($i <= 2) {
            self::generateOrder($user['id']);
            $i++;
        }
    }

    /**
     * Возвращает строку с последним пользователем из БД
     *
     * @return mixed
     */
    private static function getLastUser()
    {
        $lastUserQuery = "SELECT * FROM users ORDER BY id DESC LIMIT 1";

        return self::$database::getRow($lastUserQuery);
    }

    /**
     * Создаёт администратора в users и administrators
     *
     * @return void
     */
    public static function createAdmin()
    {
        $dateTime = DateTimeHelper::getCurrentDateTime();
        $login = 'admin';
        $password = (new PasswordService())->makePassword('admin');
        $firstName = 'admin';
        $secondName = 'admin';
        $lastName = 'admin';
        $phone = self::getRandomPhone();
        $email = self::getRandomEmail();
        $createdAt = $dateTime;
        $updatedAt = $dateTime;

        $insertRandomUsersQuery = "INSERT INTO users (login, password, first_name, second_name, last_name, phone, email, created_at, updated_at)
            VALUES (
                    '$login',
                    '$password',
                    '$firstName',
                    '$secondName',
                    '$lastName',
                    '$phone',
                    '$email',
                    '$createdAt',
                    '$updatedAt'
            )";
        $userAdminId = self::$database::add($insertRandomUsersQuery);
        $insertAdminQuery = "INSERT INTO administrators (user_id, is_active) VALUES ('$userAdminId', '1')";
        self::$database::add($insertAdminQuery);
    }

    /**
     * @return string
     */
    public static function getRandomEmail(): string
    {
        return (new Functions())->getRandomString() . '@mail.ru';
    }

    /**
     * @return string
     */
    public static function getRandomLogin(): string
    {
        return (new Functions())->getRandomString();
    }

    /**
     * @return array
     */
    public static function getRandomName(): array
    {
        $namesArray = ['Abraham', ' Addison', ' Adrian', ' Albert', ' Alec', ' Alfred', ' Alvin', ' Andrew', ' Andy', ' Archibald', ' Archie', ' Arlo', ' Arthur', ' Arthur', ' Austen', ' Barnabe', ' Bartholomew', ' Bertram', ' Bramwell', ' Byam', ' Cardew', ' Chad', ' Chance', ' Colin', ' Coloman', ' Curtis', ' Cuthbert', ' Daniel', ' Darryl', ' David', ' Dickon', ' Donald', ' Dougie', ' Douglas', ' Earl', ' Ebenezer', ' Edgar', ' Edmund', ' Edward', ' Edwin', ' Elliot', ' Emil', ' Floyd', ' Franklin', ' Frederick', ' Gabriel', ' Galton', ' Gareth', ' George', ' Gerard', ' Gilbert', ' Gorden', ' Gordon', ' Graham', ' Grant', ' Henry', ' Hervey', ' Hudson', ' Hugh', ' Ian', ' Jack', ' Jaime', ' James', ' Jason', ' Jeffrey', ' Joey', ' John', ' Jolyon', ' Jonas', ' Joseph', ' Joshua', ' Julian', ' Justin', ' Kurt', ' Lanny', ' Larry', ' Laurence', ' Lawton', ' Lester', ' Malcolm', ' Marcus', ' Mark', ' Marshall', ' Martin', ' Marvin', ' Matt', ' Maximilian', ' Michael', ' Miles', ' Murray', ' Myron', ' Nate', ' Nathan', ' Neil', ' Nicholas', ' Nicolas', ' Norman', ' Oliver', ' Oscar', ' Osric', ' Owen', ' Patrick', ' Paul', ' Peleg', ' Philip', ' Phillipps', ' Raymond', ' Reginald', ' Rhys', ' Richard', ' Robert', ' Roderick', ' Rodger', ' Roger', ' Ronald', ' Rowland', ' Rufus', ' Russell', ' Sebastian', ' Shahaf', ' Simon', ' Stephen', ' Swaine', ' Thomas', ' Tobias', ' Travis', ' Victor', ' Vincent', ' Vincent', ' Vivian', ' Wayne', ' Wilfred', ' William', ' Winston', ' Zadoc',];

        $userName = [
            'firstName' => InputHelper::processInputValue($namesArray[array_rand($namesArray)]),
            'secondName' => InputHelper::processInputValue($namesArray[array_rand($namesArray)]),
            'lastName' => InputHelper::processInputValue($namesArray[array_rand($namesArray)]),
        ];

        return $userName;
    }

    /**
     * @return string
     */
    public static function getRandomPhone(): string
    {
        return InputHelper::processInputValue(rand(10000000000, 99999999999));
    }
}