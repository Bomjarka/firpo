<h1>Администраторская панель</h1>

<?php if (isset($data['error'])) {
    extract($data);
    if ($error == "access_denied") { ?>
        <p style="color:red">У вас нет доступа к администраторской панели</p>
    <?php }
} ?>





