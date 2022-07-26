<h1>Страница регистрации</h1>
<div>
    <form action="" method="post">
        <table class="login"
            <tr>
                <th colspan="2">Данные для регистрации</th>
            </tr>
            <tr>
                <td>Логин</td>
                <td><input type="text" name="login" value="<?php echo TestDataGenerator::getRandomLogin()?>"></td>
            </tr>
            <tr>
                <td>Пароль</td>
                <td><input type="password" name="password" value="qwerty"></td>
            </tr>
            <tr>
                <td>Имя</td>
                <td><input type="text" name="first_name" value="<?php echo TestDataGenerator::getRandomName()['firstName']?>"></td>
            </tr>
            <tr>
                <td>Отчество</td>
                <td><input type="text" name="second_name" value="<?php echo TestDataGenerator::getRandomName()['secondName']?>"></td>
            </tr>
            <tr>
                <td>Фамилия</td>
                <td><input type="text" name="last_name" value="<?php echo TestDataGenerator::getRandomName()['lastName']?>"></td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td><input type="text" name="phone" value="<?php echo TestDataGenerator::getRandomPhone() ?>"></td>
            </tr>
            <tr>
                <td>Почта</td>
                <td><input type="text" name="email" value="<?php echo TestDataGenerator::getRandomEmail()?>"></td>
            </tr>
            <th colspan="2" style="text-align: right">
                <input type="submit" value="Зарегистрироваться" class="regbtn"
                       style="width: 150px; height: 30px;">
            </th>
        </table>
    </form>
</div>


<?php
if ($data) {
    extract($data);
    if ($reg_status == "registration_completed") { ?>
        <p style="color:green">Регистрация прошла успешно.</p>
    <?php } elseif ($reg_status == "not_all_fields") { ?>
        <p style="color:red">Вы заполнили не все поля</p>
    <?php } elseif ($reg_status == "such_user_exists") { ?>
        <p style="color:red">Пользователь с такими данными уже существует</p>
    <?php }
}?>
