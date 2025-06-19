<?php 
    session_start();
    require_once './config/connect.php';

    // $style = mysqli_query($connect, "SELECT * FROM `styles`");
    // $style = mysqli_fetch_all($style);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/styles.css">
        <link href="https://fonts.googleapis.com/css?family=Manrope:regular,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/font-awesome.min.css">
        <title>Moldova Dancers: styles</title>
    </head>
    <body>
        <header class="header">
            <div class="container">
                <div class="header__body">
                    <!-- Логотип -->
                    <a href="index.php" class="header__logo">
                        <span class="header__logo-text">MOLDOVA DANCE</span>
                    </a>

                    <!-- Бургер-меню (для мобильной версии) -->
                    <div class="header__burger">
                        <span class="header__burger-line"></span>
                    </div>

                    <!-- Основное меню -->
                    <nav class="header__menu">
                        <ul class="header__list">
                            <!-- Пункт меню "About Us" -->
                            <li class="header__item">
                                <a href="index.php#aboutus" class="header__link">About Us</a>
                            </li>

                            <!-- Пункт меню "Events" с подменю -->
                            <li class="header__item header__item--dropdown">
                                <span class="header__link header__link--dropdown">Events</span>
                                <ul class="header__submenu">
                                    <?php
                                    $infos = mysqli_query($connect, "SELECT * FROM event_types");
                                    $infos = mysqli_fetch_all($infos);
                                    foreach ($infos as $info) {
                                    ?>
                                        <li class="header__subitem">
                                            <a href="events.php?id=<?= $info[0] ?>" class="header__sublink">
                                                <?= $info[1] ?>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </li>

                            <!-- Пункт меню "Info" с подменю -->
                            <li class="header__item header__item--dropdown">
                                <span class="header__link header__link--dropdown">Info</span>
                                <ul class="header__submenu">
                                    <?php
                                    $infos = mysqli_query($connect, "SELECT * FROM info_types");
                                    $infos = mysqli_fetch_all($infos);
                                    foreach ($infos as $info) {
                                    ?>
                                        <li class="header__subitem">
                                            <a href="<?= $info[1] ?>.php" class="header__sublink">
                                                <?= $info[1] ?>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </li>

                            <!-- Пункт меню "News" -->
                            <li class="header__item">
                                <a href="news.php" class="header__link">News</a>
                            </li>

                            <!-- Пункт меню "Forum" -->
                            <li class="header__item">
                                <a href="forum.php" class="header__link">Forum</a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Контакты и кнопки авторизации -->
                    <div class="header__contacts">
                        <?php if (!$_SESSION['user']) { ?>
                            <button id="openModalBtn" class="header__button">Login</button>
                        <?php } else { ?>
                            <a href="profile.php" class="header__profile-link"><?= $_SESSION['user']['login_user'] ?></a>
                            <button class="header__button header__button--logout" id="logOutButton">
                                <a href="vendor/logout.php" class="header__logout-link">Log Out</a>
                            </button>
                        <?php } ?>

                        <!-- Иконки соцсетей -->
                        <a href="#" class="header__social-link">
                            <i class="fa fa-telegram header__social-icon"></i>
                        </a>
                        <a href="https://www.instagram.com/moldovadancers/" class="header__social-link">
                            <i class="fa fa-instagram header__social-icon"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <main class="main-content">
            <div class="container">
            <!-- Заголовок страницы -->
            <h1 class="h1__title">Styles</h1>
            <div class="main-content__cards">
                <?php
                    $styles = mysqli_query($connect, "SELECT * FROM styles");
                    while ($style = mysqli_fetch_assoc($styles)):
                ?>
                    <div class="card" id="style-<?= $style['id_style'] ?>" style="scroll-margin-top: 100px;"> 

                    <div class="card__image"><img src="<?= $style['image_style'] ?>"></div>
                    <div class="card__content">
                        <h2 class="cartd__title align-right"><?= $style['name_style'] ?></h2>
                        <div class="card__text"><?= $style['about_style'] ?></div>
                        <div class="card__list">
                            <span class="span-accent">Video: </span>
                            <span class="list--inline"><a href="<?= $style['video_style'] ?>"><?= $style['video_style'] ?></a></span>
                        </div>
                        <div class="registration">
                            <button class="button-reg">Dancers & Studios</button>
                            <div class="topic-reg" style="display: none;">
                                <div class="card__list">
                                    <span class="span-accent">Dancers: </span>
                                    <span class="list--inline">
                                    <?php
                                        $id_style = $style['id_style'];
                                        $names = mysqli_query($connect, "SELECT d.name_dancer, d.id_dancer
                                            FROM dancers d
                                            RIGHT JOIN dancer_style ds on d.id_dancer = ds.id_dancer
                                            RIGHT JOIN styles s ON s.id_style = ds.id_style
                                            WHERE ds.id_style = $id_style;");
                                        while ($name = mysqli_fetch_assoc($names)):
                                    ?>
                                        <span class="list--inline__item">
                                            <a href="dancers.php#dancer-<?= $name['id_dancer'] ?>"><?= $name['name_dancer'] ?></a>
                                        </span>
                                    <?php endwhile; ?>                                    
                                     
                                </div>
                                <div class="card__list">
                                    <span class="span-accent">Studios: </span>
                                    <span class="list--inline">
                                    <?php
                                        $studios = mysqli_query($connect, "SELECT std.name_studio, std.id_studio 
                                            FROM studios std
                                            RIGHT JOIN studio_style ss on std.id_studio = ss.id_studio 
                                            RIGHT JOIN styles stl ON stl.id_style = ss.id_style 
                                            WHERE ss.id_style = $id_style");
                                        while ($studio = mysqli_fetch_assoc($studios)):
                                    ?>
                                        <span class="list--inline__item">
                                            <a href="studios.php#studio-<?= $studio['id_studio'] ?>"><?= $studio['name_studio'] ?></a>
                                        </span>
                                    <?php endwhile; ?>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </main>
        <div id="modal" class="modal" >
            <div class="modal__content">
                <div class="modal__header">
                    <span class="modal__title">Authorization</span>
                    <button id="closeModalBtn">Close</button>
                </div>
                
                <div class="modal__body">
                    <form action="vendor/sign_in.php" id="loginForm" method="post" class="form">
                        <div class="form__group">
                            <label for="loginEmail" class="form__label">E-mail</label>
                            <input
                                type="email"
                                id="loginEmail"
                                name="email"
                                placeholder="Enter your E-mail"
                                required
                                class="form__input"
                                aria-describedby="emailHelp"
                            />
                        </div>
                        <div class="form__group">
                            <label for="loginPassword" class="form__label">Password</label>
                            <input
                                type="password"
                                id="loginPassword"
                                name="password"
                                placeholder="Enter your Password"
                                required
                                class="form__input"
                            />
                        </div>
                        <div class="form__group">
                            <span class="form__text">Don't have an account?</span>
                            <a href="registration.php" class="form__link">Registration</a>
                        </div>
                        <button type="submit" class="form__submit-btn">Sign In</button>
                        
                        <!-- Сообщение об ошибке при авторизации -->
                        <?php
                            if ($_SESSION['message']){
                                echo '<p class="form__message"> ' . $_SESSION['message'] . ' </p> ';
                            }
                            unset($_SESSION['message']);
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="footer__body">
                    <!-- Секция контактов -->
                    <div class="footer__section footer__section--contacts">
                        <h3 class="footer__title">Contact Us</h3>
                        <ul class="footer__list">
                            <li class="footer__item">
                                <i class="fa fa-map-marker footer__icon"></i>
                                <span class="footer__text">Chisinau, Moldova</span>
                            </li>
                            <li class="footer__item">
                                <i class="fa fa-phone footer__icon"></i>
                                <span class="footer__text">+373 123 456 789</span>
                            </li>
                            <li class="footer__item">
                                <i class="fa fa-envelope footer__icon"></i>
                                <span class="footer__text">info@moldovadance.com</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Секция навигации -->
                    <div class="footer__section footer__section--navigation">
                        <h3 class="footer__title">Quick Links</h3>
                        <ul class="footer__list">
                            <li class="footer__item">
                                <a href="index.php#aboutus" class="footer__link">About Us</a>
                            </li>
                            <li class="footer__item">
                                <a href="events.php" class="footer__link">Events</a>
                            </li>
                            <li class="footer__item">
                                <a href="news.php" class="footer__link">News</a>
                            </li>
                            <li class="footer__item">
                                <a href="forum.php" class="footer__link">Forum</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Секция соцсетей -->
                    <div class="footer__section footer__section--social">
                        <h3 class="footer__title">Follow Us</h3>
                        <ul class="footer__list footer__list--social">
                            <li class="footer__item">
                                <a href="#" class="footer__link">
                                    <i class="fa fa-telegram footer__icon"></i>
                                </a>
                            </li>
                            <li class="footer__item">
                                <a href="https://www.instagram.com/moldovadancers/" class="footer__link">
                                    <i class="fa fa-instagram footer__icon"></i>
                                </a>
                            </li>
                            <li class="footer__item">
                                <a href="#" class="footer__link">
                                    <i class="fa fa-facebook footer__icon"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Секция копирайта -->
                <div class="footer__copyright">
                    <p class="footer__copyright-text">
                        &copy; 2025 Moldova Dance. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>