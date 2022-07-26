<body>
<h1>Страница авторизации</h1>
<div class="box">
    <form action="" method="post">
        <table class="login">
            <tr>
                <th colspan="2">Авторизация</th>
            </tr>
            <tr>
                <td>Логин</td>
                <td><input type="text" name="login"></td>
            </tr>
            <tr>
                <td>Пароль</td>
                <td><input type="password" name="password"></td>
            </tr>
            <th colspan="2" style="text-align: center">
                <input type="submit" value="Войти" name="loginbtn" style="width: 150px; height: 30px;">
                <br>
                <a href="/registration">Регистрация</a>
            </th>
        </table>
    </form>
</div>
</body>
<?php if (isset($data)) {
    extract($data);
    if ($login_status == "access_granted") { ?>
        <p style="color:green">Авторизация прошла успешно.</p>
    <?php } elseif ($login_status == "access_denied") { ?>
        <p style="color:red">Логин и/или пароль введены неверно.</p>
    <?php }
} ?>
