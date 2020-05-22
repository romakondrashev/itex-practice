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
                    <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                    Список всех очередей
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Авторизованы как:</div>
            <?php echo $current_user['login']; ?>
        </div>
    </nav>
</div>