<h1>Личный кабинет</h1>
<?php if ($data['is_logged'] == 'logged') {
    if (isset($data['edit_data']) && $data['edit_data'] == 'edit_user_data') {?>
        <div class="box">
            <h3>Ваши данные</h3>
            <table style="margin: auto">
                <form action="" method="post">
                <tr id="result">
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Фамилия</th>
                    <th>Логин</th>
                    <th>Телефон</th>
                    <th>Почта</th>
                    <?php
                    echo
                        '<tr>
                             <td><input type="text" name="first_name" style="width: 100%" value="' . $data['user']->firstName . '"></td>
                             <td><input type="text" name="second_name" style="width: 100%" value="' . $data['user']->secondName . '"></td>
                             <td><input type="text"  name="last_name" style="width: 100%" value="' . $data['user']->lastName . '"></td>
                             <td><input type="text" name="login" style="width: 100%" value="' . $data['user']->login . '"></td>
                             <td><input type="text" name="phone" style="width: 100%" value="' . $data['user']->phone . '"></td>
                             <td><input type="email" name="email" style="width: 100%" value="' . $data['user']->email . '"></td>
                        </tr>';
                    ?>
                </tr>
            </table>
            <div class="button-box">
                <input class="button" name="updateuserdatabutton" type="submit" value="Сохранить данные" style="width: 150px; height: 30px;">
                <input class="button" name="cancelupdatebutton" type="submit" value="Отмена" style="width: 150px; height: 30px;">
            </div>
            </form>
        </div>
   <?php } else { ?>
        <div class="box">
            <h3>Ваши данные</h3>
            <table style="margin: auto">
                <tr id="result">
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Фамилия</th>
                    <th>Логин</th>
                    <th>Телефон</th>
                    <th>Почта</th>
                    <?php
                    echo
                        '<tr>
                             <td> ' . $data['user']->firstName . '</td>
                             <td>' . $data['user']->secondName . '</td>
                             <td>' . $data['user']->lastName . '</td>
                             <td>' . $data['user']->login . '</td>
                             <td>' . $data['user']->phone . '</td>
                             <td>' . $data['user']->email . '</td>
                        </tr>';
                    ?>
                </tr>
            </table>
            <div class="button-box">
                <form action="" method="post">
                    <input class="button" name="edituserdatabutton" type="submit" value="Редактировать данные" style="width: 150px; height: 30px;">
                    <?php include ('logout_view.php'); ?>
                </form>
            </div>
        </div>
   <?php }
    if (isset($data['data_updated']) && $data['data_updated'] == 'failed') { ?>
        <p style="color:red">Пользователь с такими данными уже существует</p>    <?php }
} else { ?>
    <div class="box">
        <h3>Приветствуем тебя, для доступа к данной странице необходимо авторизоваться или зарегистрироваться</h3>
        <a href="/login">Авторизация</a>
        <a href="/registration">Регистрация</a>
    </div>
<?php }



