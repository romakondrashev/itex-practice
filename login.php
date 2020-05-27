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
    <title>Авторизация - Онлайн Очередь ХНУРЭ</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/scripts.js"></script>
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Авторизация</h3></div>
                                <div class="card-body">
                                    <div id="messages">
                                        <?php if (isset($_GET['message']) && $_GET['message']==='register-success'): ?>
                                            <div class="alert alert-success" role="alert">
                                                Регистрация прошла успешно! <br>Пожалуйста, авторизуйтесь.
                                            </div>
                                            <?php elseif (isset($_GET['message']) && $_GET['message']==='need-auth'): ?>
                                                <div class="alert alert-danger" role="alert">
                                                    Для работы с сервисом необходима авторизация!
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <form id="login_form">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Логин или Email</label>
                                                <input required="required" name="login" class="form-control py-4" id="inputEmailAddress" type="text" placeholder="Введите логин или пароль" pattern="^([a-zA-Z0-9]+|([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6})$" title="Введите логин или email" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Пароль *</label>
                                                <input required="required" name="password" class="form-control py-4" id="inputPassword" type="password" placeholder="Введите пароль" pattern="[a-zA-Z0-9]{6,30}" title="Пароль может состоять из латинских символов и цифр, от 6 до 30 символов"/>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox"><input name="remember_ip" class="custom-control-input" id="rememberPasswordCheck" type="checkbox" checked="checked" /><label class="custom-control-label" for="rememberPasswordCheck">Запомнить IP</label></div>
                                            </div>
                                            <div class="form-group d-flex w-100 mt-4 mb-0">
                                                <input type="submit" class="btn btn-primary w-100 " value="Авторизоваться">
                                                <input type="hidden" name="submit">
                                            </div>
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
                                        <div class="small"><a href="register.php">Нужен аккаунт? Зарегистрируйся!</a></div>
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
                                <a href="<?php echo $home_url; ?>/MediaWiki">Документация MediaWiki</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script>
            $('#login_form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'backend/auth/login.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function(e){
                        $('#login_form [type="submit"]').attr('disabled','disabled').val('Отправка данных...');
                    },
                    success: function (data){
                        if (data.redirect) {
                         window.location.href = data.redirect;
                     } else if (data.message) {
                        $('#messages').html('<div class="alert alert-danger" role="alert">'+data.message+'</div>');
                    }
                    $('#login_form [type="submit"]').removeAttr('disabled').val('Авторизоваться');
                }
            })
            })
        </script>
    </body>
    </html>
