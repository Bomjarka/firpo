<h1>Работа с данными</h1>
<?php if ($data['is_logged'] === 'logged') { ?>
    <div class="box">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="file_input"><strong>Прикрепите xml-файл:</strong></label>
            <input class="file_input" name="uploaded_file" type="file" accept="xml">
            <button class="upload_file" type="submit" disabled>Загрузить файл</button>
        </form>
    </div>
    <?php if ($data['sql']) { ?>
        <div class="box">
            <table style="margin: auto">
                <tr id="result">
                    <th>Люди с животными, которым более 3х лет</th>
                    <?php foreach ($data['sql'] as $usersRows) {
                        echo
                            '<tr>
                             <td> ' . $usersRows['name'] . '</td>
                            </tr>';
                    }
                    } else {
                        echo '<p style="color:red">Нет таких пользователей</p>';
                    }
                    ?>
                </tr>
            </table>
        </div>
<?php } else { ?>
    <div class="box">
        <h3>Приветствуем тебя, для доступа к данной странице необходимо авторизоваться или зарегистрироваться</h3>
        <a href="/login">Авторизация</a>
        <a href="/registration">Регистрация</a>
    </div>
<?php } ?>

<script>
    $(document).ready(function () {
        $('.file_input').change(function (e) {
            let inputFile = e.target.files[0];
            let extension = inputFile.name.substring(inputFile.name.lastIndexOf('.') + 1);
            if (!['xml'].includes(extension)) {
                $('.files_div').addClass('border-2 border-red-500 rounded');
                $('.input_area').addClass('border-red-500');
                $('.input_filename').addClass('text-red-500');
                $('.add-photo-div').addClass('hidden');
                $(this).val('');
                alert('Wrong file type!')
                //По хорошему добавить проверку на max_upoload_size, но не стал делать
            } else {
                $('.upload_file').prop('disabled', false);
            }

        });
    });
</script>


