<?php 
    session_start();
    require_once './config/connect.php';

    $id_eventtype = $_GET['id']; // id раздела мероприятий

    if ($id_eventtype != 0 && $id_eventtype != 4) {
        $events = mysqli_query($connect, "SELECT * FROM `events`WHERE event_type = '$id_eventtype'");

        $type = mysqli_query($connect, "SELECT title_event_type FROM `event_types`where id_event_type = '$id_eventtype'");
        $type = mysqli_fetch_array($type); // получаем тип, который мы выбрали в меню и ставим в название
    } else {
        $events = mysqli_query($connect, "SELECT * FROM `events`");
    }
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
        <title>Moldova Dancers: events</title>
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
                <h1 class="h1__title"><?= $type[0] ?></h1>

                <?php if ($_SESSION['user']) { ?>
                    <div class="slider-container">
                        <div class="slider">
                            <?php if ($_SESSION['user']) {
                                $id_user = $_SESSION['user']['id_user'];
                                $recEvents = mysqli_query($connect, "SELECT e.id_event, e.event_afisha, e.event_date, e.event_name, e.event_about, c.name_city
                                                                        FROM events e
                                                                        JOIN cities c
                                                                        ON e.event_city = c.id_city
                                                                        WHERE 
                                                                            e.id_event NOT IN (
                                                                                SELECT id_event 
                                                                                FROM registrations 
                                                                                WHERE id_user = $id_user
                                                                            )
                                                                            AND e.id_event NOT IN (
                                                                                SELECT id_event 
                                                                                FROM user_event_interactions 
                                                                                WHERE id_user = $id_user
                                                                            )
                                                                            and e.event_date >= CURDATE()
                                                                        ORDER BY RAND()
                                                                        LIMIT 3;");
                                while ($recEvent = mysqli_fetch_assoc($recEvents)) {
                            ?>
                            <div class="mini-card card">
                                <div class="mini-card__content">
                                    <div class="mini-card__image">
                                        <img style="width: 200px; opacity: 0.8" src="<?= $recEvent['event_afisha'] ?>">
                                    </div>
                                    <div>
                                    <div class="mini-card__city span-accent"><?= $recEvent['name_city'] ?></div>
                                    <div class="mini-card__date">[<?= $recEvent['event_date'] ?>]</div>
                                    </div>
                                    
                                </div>
                                <div class="mini-card__content">
                                    <div class="mini-card__title">
                                        <?= $recEvent['event_name'] ?></div>                        
                                    <div class="mini-card__content"><?= mb_substr($recEvent['event_about'], 0, 300) ?>...</div>
                                    <div class="card__list">
                                        <span class="span-accent">Styles: </span>
                                        <span class="list--inline">
                                            <?php
                                            $id_event = $recEvent['id_event'];
                                        
                                            $styles = mysqli_query($connect, "SELECT s.id_style, s.name_style
                                                                            FROM styles s
                                                                            RIGHT JOIN event_style es
                                                                            ON s.id_style = es.id_style
                                                                            RIGHT JOIN events e 
                                                                            ON e.id_event = es.id_event
                                                                            WHERE es.id_event = $id_event");
                                            while ($style = mysqli_fetch_assoc($styles)):
                                            ?>
                                            <span class="list--inline__item">
                                                <a href="styles.php#style-<?= $style['id_style'] ?>"><?= $style['name_style'] ?></a>
                                            </span>
                                            <?php endwhile; ?>
                                        </span>
                                    </div>
                                    <div class="card__list">
                                        <span class="span-accent">Representative: </span>
                                        <span class="list--inline">
                                        <?php
                                                $guests = mysqli_query($connect, "SELECT d.id_dancer, d.name_dancer 
                                                    FROM dancers d
                                                    RIGHT JOIN event_guest eg
                                                    ON d.id_dancer = eg.id_dancer 
                                                    RIGHT JOIN events e
                                                    on e.id_event = eg.id_event 
                                                    WHERE eg.id_event = $id_event;");
                                                while ($guest = mysqli_fetch_assoc($guests)):
                                            ?>
                                            <span class="list--inline__item">
                                                <a href="dancers.php#dancer-<?= $guest['id_dancer'] ?>"><?= $guest['name_dancer'] ?></a>
                                            </span>                                
                                            <?php endwhile; ?>
                                        </span>
                                    </div>
                                    <div class="buttons" data-id-event="<?= $recEvent['id_event'] ?>" data-id-user="<?= $id_user ?>">
                                        <button class="skip-button">Skip</button>
                                        <button class="like-button">I like it</button>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                }}
                            ?>
                        </div>
                        <button class="prev">❮</button>
                        <button class="next">❯</button>
                        <div class="slider-dots"></div>
                    </div>
                <?php } ?>
                <!-- Список карточек -->
                <div class="main-content__cards">

                    <div class="search-container">
                        <input type="text" id="event-search" placeholder="Searching events..." class="search-input">
                        <button id="search-button" class="search-button">Search</button>
                        <button id="reset-search" class="search-button">Reset</button>
                    </div>

                    <?php while ($event = mysqli_fetch_assoc($events)): ?>
                        <!-- Карточка -->
                        <div class="card" id="event-<?= $event['id_event'] ?>" style="scroll-margin-top: 100px;"> 
                            <div class="card__image">
                                <img src="<?= $event['event_afisha'] ?>">
                            </div>

                            <div class="card__content">
                                <h2 class="card__title"><?= $event['event_name'] ?></h2>
                                <h3 class="card__date align-right">[<?= $event['event_date'] ?>]</h3>
                                <?php
                                    $city = mysqli_query($connect, "SELECT c.name_city 
                                                                    FROM cities c
                                                                    JOIN events e ON c.id_city = e.event_city
                                                                    where e.id_event = {$event['id_event']}");
                                    $city = mysqli_fetch_array($city);
                                ?>
                                <h3 class="card__city align-right"><?= $city[0] ?></h3>

                                <p class="card__text"><?= $event['event_about'] ?></p>
                                
                                <div class="card__list">
                                    <span class="span-accent">Styles: </span>
                                    <span class="list--inline">
                                        <?php
                                            $styles = mysqli_query($connect, "SELECT s.id_style, s.name_style
                                                                            FROM styles s
                                                                            RIGHT JOIN event_style es
                                                                            ON s.id_style = es.id_style
                                                                            RIGHT JOIN events e 
                                                                            ON e.id_event = es.id_event
                                                                            WHERE es.id_event = {$event['id_event']}");
                                            while ($style = mysqli_fetch_assoc($styles)):
                                        ?>
                                        <span class="list--inline__item">
                                            <a href="styles.php#style-<?= $style['id_style'] ?>"><?= $style['name_style'] ?></a>
                                        </span>
                                        <?php endwhile; ?>
                                    </span>
                                </div>

                                <div class="card__list">
                                    <span class="span-accent">Representative: </span>
                                    <span class="list--inline">
                                        <?php
                                            $guests = mysqli_query($connect, "SELECT d.id_dancer, d.name_dancer 
                                                FROM dancers d
                                                RIGHT JOIN event_guest eg
                                                ON d.id_dancer = eg.id_dancer 
                                                RIGHT JOIN events e
                                                on e.id_event = eg.id_event 
                                                WHERE eg.id_event = {$event['id_event']}");
                                            while ($guest = mysqli_fetch_assoc($guests)):
                                        ?>
                                        <span class="list--inline__item">
                                            <a href="dancers.php#dancer-<?= $guest['id_dancer'] ?>"><?= $guest['name_dancer'] ?></a>
                                        </span>                                
                                        <?php endwhile; ?>
                                    </span>
                                </div>

                                <div class="card__list">
                                    <span class="span-accent">Price: </span>
                                    <span class="list--inline"><?= $event['event_price'] ?></span>
                                </div>

                                <div class="card__list">
                                    <span class="span-accent">Information: </span>
                                    <span class="list--inline"><a href="<?= $event['event_link'] ?>"><?= $event['event_link'] ?></a></span>
                                </div>

                                <div class="card__list">
                                    <?php              
                                        $event_id = intval($event['id_event']);
                                        $organizator = mysqli_query($connect, "SELECT 'user' AS organizer_type, u.first_name AS organizer_name, u.id_user AS organizer_id
                                                                                FROM event_organizers eo
                                                                                JOIN users u ON eo.organizer_type = 'user' AND eo.organizer_id = u.id_user
                                                                                WHERE eo.id_event = $event_id

                                                                                UNION

                                                                                SELECT 'studio' AS organizer_type, s.name_studio AS organizer_name, s.id_studio AS organizer_id
                                                                                FROM event_organizers eo
                                                                                JOIN studios s ON eo.organizer_type = 'studio' AND eo.organizer_id = s.id_studio
                                                                                WHERE eo.id_event = $event_id

                                                                                UNION

                                                                                SELECT 'team' AS organizer_type, t.name_team AS organizer_name, t.id_team AS organizer_id
                                                                                FROM event_organizers eo
                                                                                JOIN teams t ON eo.organizer_type = 'team' AND eo.organizer_id = t.id_team
                                                                                WHERE eo.id_event = $event_id

                                                                                UNION

                                                                                SELECT 'dancer' AS organizer_type, d.name_dancer AS organizer_name, d.id_dancer AS organizer_id
                                                                                FROM event_organizers eo
                                                                                JOIN dancers d ON eo.organizer_type = 'dancer' AND eo.organizer_id = d.id_dancer
                                                                                WHERE eo.id_event = $event_id");
                                        $organizator = mysqli_fetch_all($organizator, MYSQLI_ASSOC);               
                                    ?>
                                    <span class="span-accent">Organizator: </span>
                                    <span class="list--inline">
                                        <?php
                                            foreach ($organizator as $org) {
                                                $name = htmlspecialchars($org['organizer_name']);
                                                $id = intval($org['organizer_id']);
                                                $type = $org['organizer_type'];

                                                // Определяем путь в зависимости от типа
                                                switch ($type) {
                                                    case 'dancer':
                                                        $url = "dancers.php?id=$id";
                                                        break;
                                                    case 'studio':
                                                        $url = "studios.php?id=$id";
                                                        break;
                                                    case 'team':
                                                        $url = "teams.php#team-$id";
                                                        break;
                                                    case 'user':
                                                        $url = "profile.php?id=$id";
                                                        break;
                                                    default:
                                                        $url = "#";
                                                }
                                        ?>
                                            <span class="list--inline__item">
                                                <a href="<?= $url ?>"><?= $name ?></a>
                                            </span>
                                        <?php
                                            }
                                        ?>
                                    </span>                            
                                </div>

                                <div class="card__list">
                                    <span class="span-accent">Contact: </span>
                                    <span class="list--inline"><a href="<?= $event['event_contact'] ?>"><?= $event['event_contact'] ?></a></span>
                                </div>
                                <!-- Ссылка, если она есть -->
                                <?php if ($news[4]) { ?>
                                    <div class="card__link"><span style="color: #ca4581">Link: </span><a href="<?= $news[4] ?>"><?= $news[4] ?></a></div>
                                <?php } ?>

                                <?php 
                                    $id_topic = mysqli_query($connect, "SELECT t.id_topic FROM topics t JOIN events e ON t.id_event = e.id_event WHERe e.id_event = {$event['id_event']};");
                                    $id_topic = mysqli_fetch_assoc($id_topic);
                                ?>
                                <div class="div_of_buttons">
                                    <button class="button-topic" onclick="window.location.href='forum.php#topic_<?= $id_topic['id_topic'] ?>'">Reviews</button>
                                    <button class="button-reg" data-event-id="<?= $event['id_event'] ?>">Registration</button>
                                    <?php
                                        if ($_SESSION['user']['login_user'] == 'ADMIN'){                       
                                    ?>
                                    <button class="button-list" data-event-id="<?= $event['id_event'] ?>">Participants</button>
                                    <?php } ?>
                                    <?php
                                        $user_id = (int)($_SESSION['user']['id_user'] ?? 0);
                                        $event_id = (int)($event['id_event'] ?? 0);
                                        $isRegistered = false;

                                        if ($user_id > 0 && $event_id > 0) {
                                            $result = mysqli_query($connect, "SELECT EXISTS (
                                                    SELECT 1 
                                                    FROM registrations 
                                                    WHERE id_event = $event_id AND id_user = $user_id
                                                ) AS is_registered
                                            ");
                                            
                                            if ($result) {
                                                $row = mysqli_fetch_assoc($result);
                                                $isRegistered = (bool)$row['is_registered'];
                                                mysqli_free_result($result);
                                            }
                                        }

                                        if ($isRegistered) {
                                            echo '<button class="button-rate" data-event-id="' . $event_id . '">Rate Event</button>';
                                        }
                                    ?>                                       
                                </div>
                                

                                <div class="registration" id="registration-<?= $event['id_event'] ?>" style="display: none;">
                                    <form action="vendor/create_reg.php" method="post">
                                    
                                        <?php if ($_SESSION['user']) { ?>
                                            <input type="text" name="first_name" class="first_name" value="<?= $_SESSION['user']['first_name'] ?>">
                                            <input type="text" name="second_name" class="second_name" value="<?= $_SESSION['user']['last_name'] ?>">
                                            <input type="text" name="phone_number" class="phone_number" value="<?= $_SESSION['user']['phone_user'] ?>">
                                            <input type="hidden" name="id_user" class="id_user" value="<?= $_SESSION['user']['id_user'] ?>">
                                        <?php } else { ?>
                                            <input type="text" name="first_name" class="first_name" placeholder="First Name">
                                            <input type="text" name="second_name" class="second_name" placeholder="Last Name">
                                            <input type="text" name="phone_number" class="phone_number" placeholder="Phone Number">
                                        <?php } ?>
                                        
                                            <input type="hidden" name="id_event" class="id_event" value="<?= $event['id_event'] ?>">
                                            <br>
                                            <button type="submit" class="send">READY</button>
                                            <button type="reset">RESET</button>
                                    
                                    </form>
                                </div>

                    
                                <div class="registration_list" id="registration_list-<?= $event['id_event'] ?>" style="display: none;">
                                    <table>
                                        <tr>
                                            <td>Имя</td>
                                            <td>Фамилия</td>
                                            <td>Номер телефона</td>
                                        </tr>
                                        <?php
                                            $registration = mysqli_query($connect, "SELECT * FROM registrations WHERE id_event = {$event['id_event']};");
                                            $registration = mysqli_fetch_all($registration);
                                            foreach ($registration as $reg) {
                                        ?>
                                            <tr>
                                                <td><?= $reg[3] ?></td>
                                                <td><?= $reg[4] ?></td>
                                                <td><?= $reg[5] ?></td>
                                            </tr>
                                        <?php
                                            }
                                        ?>  
                                    </table>
                                </div>


                                <div class="rate" id="rate-<?= $event['id_event'] ?>" style="display: none;">
                                    
                                    <form action="vendor/create_rating.php" method="post">
                                        
                                            
                                        <input type="hidden" name="id_user" class="id_user" value="<?= $_SESSION['user']['id_user'] ?>">
                                        <input type="hidden" name="id_event" class="id_event" value="<?= $event['id_event'] ?>">

                                        <input type="text" name="comment" class="" placeholder="Enter your comment">
                                        <input type="number" name="rating" min="1" max="10" placeholder="Enter your rating 1-10">                                            
                                        <br>
                                        <button type="submit" class="send">READY</button>
                                        <button type="reset">RESET</button>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?> 
                    
                </div>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Обработчик для всех кнопок регистрации
                document.querySelectorAll('.button-reg').forEach(button => {
                    button.addEventListener('click', function() {
                        const eventId = this.getAttribute('data-event-id');
                        const regForm = document.getElementById(`registration-${eventId}`);
                        const allLists = document.querySelectorAll('.registration_list');

                        // Скрываем все списки участников
                        allLists.forEach(list => list.style.display = 'none');

                        // Скрываем все формы оценок
                        document.querySelectorAll('.rate').forEach(rate => rate.style.display = 'none');

                        // Переключаем текущую форму регистрации
                        regForm.style.display = regForm.style.display === 'none' ? 'block' : 'none';
                    });
                });

                // Обработчик для всех кнопок участников (только у админа)
                document.querySelectorAll('.button-list').forEach(button => {
                    button.addEventListener('click', function() {
                        const eventId = this.getAttribute('data-event-id');
                        const regList = document.getElementById(`registration_list-${eventId}`);
                        const allForms = document.querySelectorAll('.registration');

                        // Скрываем все формы регистрации
                        allForms.forEach(form => form.style.display = 'none');

                        // Скрываем все формы оценок
                        document.querySelectorAll('.rate').forEach(rate => rate.style.display = 'none');

                        // Переключаем текущий список участников
                        regList.style.display = regList.style.display === 'none' ? 'block' : 'none';
                    });
                });

                // Обработчик для всех кнопок Rate Event
                document.querySelectorAll('.button-rate').forEach(button => {
                    button.addEventListener('click', function() {
                        const eventId = this.getAttribute('data-event-id');

                        if (!eventId) {
                            console.error('data-event-id attribute is missing');
                            return;
                        }

                        const rateList = document.getElementById(`rate-${eventId}`);
                        if (!rateList) {
                            console.error(`Element with ID 'rate-${eventId}' not found`);
                            return;
                        }

                        // Скрываем все формы регистрации
                        document.querySelectorAll('.registration').forEach(form => form.style.display = 'none');

                        // Скрываем все списки участников
                        document.querySelectorAll('.registration_list').forEach(list => list.style.display = 'none');

                        // Скрываем все формы оценок
                        document.querySelectorAll('.rate').forEach(form => {
                            if (form) form.style.display = 'none';
                        });

                        // Переключаем текущую форму оценки
                        const currentDisplay = window.getComputedStyle(rateList).display;
                        rateList.style.display = currentDisplay === 'none' ? 'block' : 'none';
                    });
                });
                
                const slider = document.querySelector('.slider');
                const slides = document.querySelectorAll('.mini-card');
                const prevBtn = document.querySelector('.prev');
                const nextBtn = document.querySelector('.next');
                const dotsContainer = document.querySelector('.slider-dots');
                let currentIndex = 0;

                // Рассчитываем ширину одной карточки с учетом отступов
                const slideWidth = slides[0].offsetWidth + parseInt(window.getComputedStyle(slider).gap);

                // Создание точек
                slides.forEach((_, index) => {
                    const dot = document.createElement('div');
                    dot.classList.add('slider-dot');
                    if (index === 0) dot.classList.add('active');
                    dot.addEventListener('click', () => {
                        currentIndex = index;
                        updateSlider();
                    });
                    dotsContainer.appendChild(dot);
                });

                const updateSlider = () => {
                    const offset = -currentIndex * slideWidth;
                    slider.style.transform = `translateX(${offset}px)`;
                    
                    document.querySelectorAll('.slider-dot').forEach((dot, i) => {
                        dot.classList.toggle('active', i === currentIndex);
                    });
                    
                    // Блокировка кнопок на границах
                    prevBtn.disabled = currentIndex === 0;
                    nextBtn.disabled = currentIndex === slides.length - 1;
                };

                prevBtn.addEventListener('click', () => {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateSlider();
                    }
                });

                nextBtn.addEventListener('click', () => {
                    if (currentIndex < slides.length - 1) {
                        currentIndex++;
                        updateSlider();
                    }
                });

                // Обновляем при изменении размера окна
                window.addEventListener('resize', () => {
                    const newSlideWidth = slides[0].offsetWidth + parseInt(window.getComputedStyle(slider).gap);
                    if (newSlideWidth !== slideWidth) {
                        updateSlider();
                    }
                });

                updateSlider();

                document.querySelectorAll('.buttons').forEach(container => {
                        const eventId = container.getAttribute('data-id-event');
                        const userId = container.getAttribute('data-id-user');

                        const skipButton = container.querySelector('.skip-button');
                        const likeButton = container.querySelector('.like-button');

                        if (skipButton) {
                    skipButton.addEventListener('click', function() {
                        handleInteraction(eventId, userId, 0, true); // передаем флаг показать алерт
                    });
                }


                        if (likeButton) {
                            likeButton.addEventListener('click', function() {
                                handleInteraction(eventId, userId, 1); // 1 - Like
                            });
                        }
                    });

                    function handleInteraction(eventId, userId, interactionType) {
                    fetch('/md_new/vendor/handle_interaction.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id_event: eventId,
                            id_user: userId,
                            interaction_type: interactionType
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Ошибка сети: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            if (interactionType === 1) {
                                // Только если Like
                                window.location.href = `/md_new/events.php#event-${eventId}`;
                            } else if (interactionType === 0) {
                                // Если Skip - показать алерт
                                alert('Это событие больше не будет показываться вам в рекомендациях.');
                            }
                        } else {
                            console.error('Ошибка сервера:', data.message);
                            alert('Произошла ошибка: ' + (data.message || 'Попробуйте позже.'));
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка при запросе:', error);
                        alert('Не удалось отправить действие. Проверьте соединение.');
                    });
                }



            });
        </script>
        <script src="js/script.js"></script>
    </body>
</html>