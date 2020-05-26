<?php

require 'backend/auth/google-auth/settings.php';
$is_auth_page = true;
require 'connection.php';
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{    
    header("Location: $home_url/index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Регистрация - Онлайн Очередь ХНУРЭ</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/scripts.js"></script>
    <style>
        ul{margin:0;padding-left:20px}
    </style>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Создание профиля</h3>
                                </div>
                                <div class="card-body">
                                    <div id="messages"></div>
                                    <form id="register_form" onsubmit="return false;" class="validate">

                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputFirstName">Ваше ФИО *</label>
                                                <input required="required" name="surname" class="required form-control py-4" id="inputFirstName" type="text" placeholder="Кондрашев Р.А." pattern="^\D+ [А-ЯA-Z].[А-ЯA-Z].$" title="Пример: Кондрашев Р.А." />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputLogin">Логин *</label>
                                            <input required="required" name="login" class="required form-control py-4" id="inputLogin" type="text" aria-describedby="emailHelp" placeholder="vasyapupkin" pattern="^[a-zA-Z0-9]+$" title="Пример: vasyapupkin" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">Email (не обязательно)</label>
                                            <input name="email" class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="vasya.pupkin@gmail.com" title="Пример vasya.pupkin@gmail.com" pattern="^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$"/>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputCurse">Курс (не обязательно)</label>
                                                    <input name="curse" class="form-control py-4" id="inputCurse" type="number" min="1" max="6"  title="От 1 до 6" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputGroup">Группа (не обязательно)</label>
                                                    <input name="group" class="form-control py-4" id="inputGroup" type="text"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputPassword">Пароль *</label>
                                                    <input required="required" name="password" class="required form-control py-4" id="inputPassword" type="password" placeholder="Введите пароль" autocomplete="new-password" pattern="[a-zA-Z0-9]" title="Пароль может состоять из латинских символов и цифр" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputConfirmPassword">Подтверждение пароля *</label>
                                                    <input required="required" name="confirm-password" class="required form-control py-4" id="inputConfirmPassword" type="password" placeholder="Подтвердите пароль" autocomplete="new-password"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4 mb-0">
                                            <input type="submit" class="btn btn-primary btn-block" value="Создать профиль">
                                        </div>
                                        <input type="hidden" name="submit">
                                        <div class="form-group d-flex w-100 mt-4 mb-0 ">
                                            <p class="mx-auto mb-0">Или</p>
                                        </div>
                                        <div class="form-group d-flex w-100 mt-4 mb-0">
                                            <a href="<?php echo $client->createAuthUrl(); ?>" class="btn btn-outline-danger w-100 ">
                                                <img src="assets/img/google-auth.png" alt="" width="30" height="30">
                                                <span style="vertical-align: inherit;">
                                                    Google-авторизация
                                                </span>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="login.php">Уже зарегистрированы? Авторизоваться</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Online-Queue 2020</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>

        $('#register_form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'backend/auth/register.php',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function(e){
                    $('#register_form [type="submit"]').attr('disabled','disabled').val('Отправка данных...');
                },
                success: function (data){
                    if (data !== '') {
                        var output = '';

                        output = '<div class="alert alert-danger" role="alert"><p>Пожалуйста, исправьте следующие ошибки:</p><ul>';
                        for (var i = 0; i < data.length; i++) {
                            output += '<li>' + data[i] + '</li>';
                        }
                        output += '</ul></div>';

                        $('#messages').html(output);
                        $('#register_form [type="submit"]').removeAttr('disabled').val('Создать профиль');
                    }
                }
            })
        })

    // Проверка на подтверждение пароля
    var password = document.getElementById("inputPassword")
    , confirm_password = document.getElementById("inputConfirmPassword");

    function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Пароль не совпадает");
    } else {
        confirm_password.setCustomValidity('');
    }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
</body>
</html>