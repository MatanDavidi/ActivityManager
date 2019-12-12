<?php
if ($_SERVER["REQUEST_URI"] !== "/home/login") {
    if (!(isset($_SESSION["userName"]) && isset($_SESSION["userRole"]))) {
        header("Location: " . URL . "home");
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>ActivityManager - Gestisci le ore di lavoro della tua azienda in modo facile e veloce</title>

    <!--    Thanks to icontree for the favicon     -->
    <!--    https://www.iconfinder.com/icontree    -->
    <!--    Also, thanks to https://realfavicongenerator.net/ for the favicon generation and implementation code    -->
    <link rel="apple-touch-icon" sizes="180x180" href="/application/libs/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/application/libs/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/application/libs/img/favicon-16x16.png">
    <link rel="manifest" href="/application/libs/img/site.webmanifest">
    <link rel="mask-icon" href="/application/libs/img/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/application/libs/img/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/application/libs/img/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <meta name="description"
          content="ActivityManager è una piattaforma che facilita la gestione delle ore di lavoro della tua azienda.">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/application/libs/css/bootstrap.min.css"/>
    <!-- animate CSS -->
    <link rel="stylesheet" href="/application/libs/css/animate.css"/>
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="/application/libs/css/owl.carousel.min.css"/>
    <!-- themify CSS -->
    <link rel="stylesheet" href="/application/libs/css/themify-icons.css"/>
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="/application/libs/css/flaticon.css"/>
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="/application/libs/css/magnific-popup.css"/>
    <!-- swiper CSS -->
    <link rel="stylesheet" href="/application/libs/css/slick.css"/>
    <!-- nice-select CSS -->
    <link rel="stylesheet" href="/application/libs/css/nice-select.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="/application/libs/css/style.css"/>

    <!-- jquery here-->
    <script src="/application/libs/js/jquery-1.12.1.min.js"></script>
    <!-- jquery.validate js -->
    <script src="/application/libs/js/jquery.validate.min.js"></script>
</head>

<body>
<!--::header part start::-->
<header class="main_menu home_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="<?php echo URL; ?>">
                        <h4 class="text-light btn-link">Vai alla home</h4>
                    </a>
                    <button
                            class="navbar-toggler"
                            type="button"
                            data-toggle="collapse"
                            data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                    >
                        <span class="ti-menu"></span>
                    </button>

                    <div class="collapse navbar-collapse main-menu-item justify-content-center"
                         id="navbarSupportedContent">
                        <ul class="navbar-nav align-items-center">
                            <li class="list-item">
                                <?php if ($_SERVER["REQUEST_URI"] !== "/home/login"): ?>
                                    <a class="nav-link" href="<?php echo URL . "activities"; ?>">Lavori</a>
                                <?php else: ?>
                                    <div class="invisible nav-link"></div>
                                <?php endif; ?>
                            </li>
                            <li class="list-item">
                                <?php if ($_SERVER["REQUEST_URI"] !== "/home/login"): ?>
                                    <a class="nav-link" href="<?php echo URL . "resources"; ?>">Risorse</a>
                                <?php else: ?>
                                    <div class="invisible nav-link"></div>
                                <?php endif; ?>
                            </li>
                            <?php if (
                                $_SERVER["REQUEST_URI"] !== "/home/login" &&
                                $_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE): ?>
                                <li class="nav-item dropdown">
                                    <a
                                            class="nav-link dropdown-toggle"
                                            id="navbarDropdown"
                                            role="button"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                    >
                                        Gestione
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="<?php echo URL . "activities/new"; ?>">
                                            Aggiungi un lavoro
                                        </a>
                                        <a class="dropdown-item" href="<?php echo URL . "resources/add"; ?>">
                                            Registra una risorsa
                                        </a>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION["userName"]) &&
                                isset($_SESSION["userRole"])): ?>
                                <li class="nav-item dropdown">
                                    <a
                                            class="nav-link dropdown-toggle"
                                            id="navbarDropdown"
                                            role="button"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                    >
                                        Resoconto
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="<?php echo URL . "workHours/dailyReport"; ?>">
                                            Giornaliero
                                        </a>
                                        <?php if ($_SESSION["userRole"] == Resource::ADMINISTRATOR_ROLE): ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URL . "workHours/monthlyReport"; ?>">
                                                Mensile
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php if ($_SERVER["REQUEST_URI"] !== "/home/login"): ?>
                        <div class="d-lg-block">
                            <a class="btn btn-danger" href="<?php echo URL . "home/logout"; ?>">LOGOUT</a>
                        </div>
                    <?php endif; ?>
                    <div class="social_icon d-none d-lg-block">
                        <a href="https://www.github.com/MatanDavidi"><i class="ti-github"></i></a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header part end-->