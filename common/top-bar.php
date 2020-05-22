<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo $home_url; ?>">Онлайн Очередь ХНУРЭ</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" onclick="$('body').toggleClass('sb-sidenav-toggled');" ><i class="fas fa-bars"></i></button>
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></div>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
                <span style="margin: 0 5px;"><?php echo $current_user['name']; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="logout.php">Выйти</a>
            </div>
        </li>
    </ul>
</nav>