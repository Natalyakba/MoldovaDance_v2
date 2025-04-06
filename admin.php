<?php 
    session_start();
    require_once './config/connect.php';

    $events = mysqli_fetch_all(mysqli_query($connect, "SELECT id_event, event_name FROM `events` ORDER BY event_name;"));
    $dancers = mysqli_fetch_all(mysqli_query($connect, "SELECT id_dancer, name_dancer FROM `dancers` ORDER BY name_dancer;"));
    $citiesMoldova = mysqli_fetch_all(mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country = 'Moldova' ORDER BY name_city;"));
    $citiesOther = mysqli_fetch_all(mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country != 'Moldova' ORDER BY name_city;"));
    $eventTypes = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM event_types WHERE id_event_type != 4"));
    $styles = mysqli_fetch_all(mysqli_query($connect, "SELECT id_style, name_style FROM styles ORDER BY name_style;"));
    $teams = mysqli_fetch_all(mysqli_query($connect, "SELECT id_team, name_team FROM teams;"));
    $studios = mysqli_fetch_all(mysqli_query($connect, "SELECT id_studio, name_studio FROM studios;"));

    
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
        <title>Moldova Dancers: administration</title>
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
            <h1 class="h1__title">Administration</h1>
            <div class="main-content__cards">
            <div>Заполните данные для нового мероприятия:</div><br>
                    <div class="topic">
                        <form action="vendor/create_event.php" method="post">
                            <div class="" style="display:flex; gap:15px">
                                <div class="card__image">
                                    <img src="https://i.ibb.co/Lr8KJHw/Group-253.png">
                                </div>
                                <div class="card__content">
                                <div class="div1col" style="display:flex; gap: 10px">
                                            <input name="event_name" placeholder="Название мероприятия">
                                            <input name="event_date" placeholder="Дата формата 08, October">
                                        </div>
                                        <div class="div1row" style="display:flex">
                                            <textarea name="event_about" style="width:100%" placeholder="Общая информация о мероприятии в свободном формате"></textarea>
                                        </div>
                                </div>
                                    
                                </div>
                                <div>
                                    <input class="large_input" name="event_afisha" placeholder="Введите адрес изображения афиши">
                                </div>
                                <div class="divncol">
                                    <div class="div1of4">
                                        <span class="title4">City: </span>

                                        <br>Moldova:
                                        <?php
                                        $city1 = mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country = 'Moldova' ORDER BY name_city;");
                                        $city1 = mysqli_fetch_all($city1);
                                        foreach ($city1 as $city1) {
                                        ?>
                                            <div>
                                                <input id="input_city" type="radio" name="id_city" value="<?= $city1[0] ?>"><?= $city1[1] ?>
                                            </div>
                                        <?php }
                                        ?>
                                        <br>Other:
                                        <?php
                                        $city2 = mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country != 'Moldova' ORDER BY name_city;");
                                        $city2 = mysqli_fetch_all($city2);
                                        foreach ($city2 as $city2) {
                                        ?>
                                            <div>
                                                <input id="input_city" type="radio" name="id_city" value="<?= $city2[0] ?>"><?= $city2[1] ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="div1of4">
                                        <span class="title4">Type of Event: </span>
                                        <fieldset>
                                            <?php
                                            $type = mysqli_query($connect, "SELECT * FROM event_types WHERE id_event_type != 4");
                                            $type = mysqli_fetch_all($type);
                                            foreach ($type as $type) {
                                            ?>
                                                <div>
                                                    <input class="input_style" type="radio" name="event_type" value="<?= $type[0] ?>"><?= $type[1] ?>
                                                </div>
                                            <?php } ?>
                                        </fieldset>
                                    </div>
                                    <div class="div1of4">
                                        <span class="title4">Styles: </span>

                                        <?php
                                        $style = mysqli_query($connect, "SELECT id_style, name_style FROM styles ORDER BY name_style;");
                                        $style = mysqli_fetch_all($style);
                                        foreach ($style as $style) {
                                        ?>
                                            <div>
                                                <input class="input_style" type="checkbox" name="id_style[]" value="<?= $style[0] ?>"><?= $style[1] ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="div1of4">
                                        <span class="title4">Representative: </span>
                                        <fieldset>
                                            <?php
                                            $dancer = mysqli_query($connect, "SELECT id_dancer, name_dancer FROM dancers ORDER BY name_dancer;");
                                            $dancer = mysqli_fetch_all($dancer);
                                            foreach ($dancer as $dancer) {
                                            ?>
                                                <div>
                                                    <input class="input_style" type="checkbox" name="id_dancer[]" value="<?= $dancer[0] ?>"><?= $dancer[1] ?>
                                                </div>
                                            <?php } ?>
                                        </fieldset>
                                    </div>
                                </div>
                                <div>
                                    <input class="large_input" name="event_price" placeholder="Информация о цене: <?= $event['event_price'] ?>">
                                </div>
                                <div>
                                    <input class="large_input" name="event_link" placeholder="Ссылка на источник информации: <?= $event['event_link'] ?>">
                                </div>
                                <div>
                                    <input class="large_input" name="event_contact" placeholder="Контакт с организатором (ссылка или номер телефона): <?= $event['event_contact'] ?>">
                                </div>

                            </div>
                            <button type="submit" class="send">Добавить</button>
                            <button type="reset">Очистить</button>
                        </form>
                    </div>
    
            </div>
        </main>
        <div id="modal" class="modal" >
            <div class="modal__content">
                <div class="modal__header">
                    <span class="modal__title">Authorization</span>
                    <button id="closeModalBtn" class="modal__close-btn">Close</button>
                </div>
                
                <div class="modal__body">
                    <form action="vendor/sign_in.php" id="loginForm" method="post" class="form">
                        <div class="form__group">
                            <label for="email" class="form__label">E-mail</label>
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
                            <label for="password" class="form__label">Password</label>
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