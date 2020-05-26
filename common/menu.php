<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Основное</div>
                <a class="nav-link" href="<?php echo $home_url; ?>"
                    >
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Главная
                </a>
                <a class="nav-link" href="<?php echo $home_url; ?>/queue-list.php"
                    >
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Список всех очередей
                </a>
                <a class="nav-link" href="<?php echo $home_url; ?>/my-queues-list.php"
                    >
                    <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    Мои очереди
                </a>
                 <a class="nav-link" href="<?php echo $home_url; ?>/my-awaiting-queues-list.php"
                    >
                    <div class="sb-nav-link-icon"><i class="fas fa-user-clock"></i></div>
                    Участие в очереди
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Авторизованы как:</div>
            <?php echo !empty($current_user['login']) ? $current_user['login'] : $current_user['email']; ?>
        </div>
    </nav>
</div>