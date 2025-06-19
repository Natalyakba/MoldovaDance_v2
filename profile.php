<?php 
    session_start();
    require_once './config/connect.php';
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
        <title>Moldova Dancers: Profile</title>
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
            <!-- Main content of page -->
            <div class="container">
                <h1 class="h1__title">My Profile</h1>
                <div class="main-content__cards" style="gap: 0px">
                    <?php
                        if ($_SESSION['user']['login_user'] == 'ADMIN'){ ?>
                        <button style="width: 70%;" onclick="window.location.href='admin.php'">Administration</button>                   
                    <?php } ?>

                    <div class="topic card" id="card_of_user" style="flex-direction: column;">   
                        <div class="topic__head">
                            <h2 class="no-margin">My information</h2>
                        </div> 
                        <div class="topic__content">
                        <table>
                            <tr>
                                <td class="span-accent">Login</td>
                                <td><?= $_SESSION['user']['login_user']?></td>
                            </tr>
                            <tr>
                                <td class="span-accent">First Name</td>
                                <td><?= $_SESSION['user']['first_name']?></td>
                            </tr>
                            <tr>
                                <td class="span-accent">Last Name</td>
                                <td><?= $_SESSION['user']['last_name']?></td>
                            </tr>
                            <tr>
                                <td class="span-accent">Date of birth</td>
                                <td><?= $_SESSION['user']['date_of_birth']?></td>
                            </tr>
                            <tr>
                                <td class="span-accent">City</td>
                                <td><?= $_SESSION['user']['city_user'] ?></td>
                            </tr>
                            <tr>
                                <td class="span-accent">Email</td>
                                <td><?= $_SESSION['user']['email_user']?></td>
                            </tr>
                            <tr>
                                <td class="span-accent">Phone</td>
                                <td><?= $_SESSION['user']['phone_user']?></td>
                            </tr>
                        </table>
                        <button>Update my information</button>

                        </div>                     
                        
                   
                    </div>

                    <div class="topic card" id="card_of_registrations" style="flex-direction: column;">
                        <div class="topic__head">
                            <h2 class="no-margin">My Registrations</h2>
                        </div>       
                        <div class="topic__content">
                            <table>
                                <tr>
                                    <td>Event</td>
                                    <td>City</td>
                                    <td>Date</td>
                                </tr>
                                
                                <?php
                                    $id_user = $_SESSION['user']['id_user'];
                                    $reg_events = mysqli_query($connect, "SELECT e.id_event, e.event_name, e.event_date, c.name_city 
                                                                    FROM events e
                                                                    JOIN registrations r ON e.id_event = r.id_event
                                                                    JOIN cities c ON c.id_city = e.event_city
                                                                    WHERE r.id_user = $id_user AND e.event_date >= CURDATE()");
                                    $reg_events = mysqli_fetch_all($reg_events);
                                    foreach ($reg_events as $event){
                                ?>
                                    <tr class="clickable-row" data-href="events.php#event-<?= $event[0] ?>">
                                    <!-- <a href="events.php#event-<?= $event_id ?>">Перейти к событию</a> -->
                                        <td><a href="#"><?= $event[1]?></a></td>
                                        <td><a href="#"><?= $event[3]?></a></td>
                                        <td><a href="#"><?= $event[2]?></a></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                            <button onclick="toggleEventsTable()" id="eventsToggleBtn">Show previous events</button>

                            <table id="eventsTable" style="display: none;">
                                <tr>
                                    <td>Event</td>
                                    <td>City</td>
                                    <td>Date</td>
                                    <td>Rating</td>
                                </tr>
                                
                                <?php
                                    $id_user = $_SESSION['user']['id_user'];
                                    $reg_events = mysqli_query($connect, "SELECT 
                                                                                e.id_event, 
                                                                                e.event_name, 
                                                                                e.event_date, 
                                                                                c.name_city,
                                                                                er.rating
                                                                            FROM events e
                                                                            JOIN registrations r ON e.id_event = r.id_event
                                                                            JOIN cities c ON c.id_city = e.event_city
                                                                            LEFT JOIN event_ratings er 
                                                                                ON er.id_event = e.id_event AND er.id_user = r.id_user
                                                                            WHERE r.id_user = $id_user 
                                                                            AND e.event_date < CURDATE()
                                                                            ");
                                    $reg_events = mysqli_fetch_all($reg_events);
                                    foreach ($reg_events as $event){
                                ?>
                                    <tr class="clickable-row" data-href="events.php#event-<?= $event[0] ?>">
                                        <td><a href="#"><?= $event[1]?></a></td>
                                        <td><a href="#"><?= $event[3]?></a></td>
                                        <td><a href="#"><?= $event[2]?></a></td>
                                        <td><a href="#"><?= $event[4]?> ⭐</a></td>

                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>  
                    </div>

                    <div class="topic card" id="card_of_interactions" style="flex-direction: column;">
                        <div class="topic__head">
                            <h2 class="no-margin">My Interactions</h2>
                        </div>       
                        <div class="topic__content">
                            <table>
                                <tr>
                                    <th style="background-color: var(--color-accent)">Liked</th>
                                </tr>
                                <tr>
                                    <td>Event</td>
                                    <td>City</td>
                                    <td>Date</td>
                                </tr>
                                
                                <?php
                                    $id_user = $_SESSION['user']['id_user'];
                                    $reg_events = mysqli_query($connect, "SELECT e.id_event, e.event_name, e.event_date, c.name_city 
                                                                    FROM events e
                                                                    JOIN user_event_interactions uei ON e.id_event = uei.id_event
                                                                    JOIN cities c ON c.id_city = e.event_city
                                                                    WHERE uei.id_user = $id_user AND e.event_date >= CURDATE()
                                                                    AND uei.interaction_type = 1");
                                    $reg_events = mysqli_fetch_all($reg_events);
                                    foreach ($reg_events as $event){
                                ?>
                                    <tr class="clickable-row" data-href="events.php#event-<?= $event[0] ?>">
                                    <!-- <a href="events.php#event-<?= $event_id ?>">Перейти к событию</a> -->
                                        <td><a href="#"><?= $event[1]?></a></td>
                                        <td><a href="#"><?= $event[3]?></a></td>
                                        <td><a href="#"><?= $event[2]?></a></td>
                                    </tr>
                                <?php
                                    }
                                ?>

                                <th>Skipped</th>
                                <?php
                                    $id_user = $_SESSION['user']['id_user'];
                                    $reg_events = mysqli_query($connect, "SELECT e.id_event, e.event_name, e.event_date, c.name_city 
                                                                    FROM events e
                                                                    JOIN user_event_interactions uei ON e.id_event = uei.id_event
                                                                    JOIN cities c ON c.id_city = e.event_city
                                                                    WHERE uei.id_user = $id_user AND e.event_date >= CURDATE()
                                                                    AND uei.interaction_type = 0");
                                    $reg_events = mysqli_fetch_all($reg_events);
                                    foreach ($reg_events as $event){
                                ?>
                                    <tr class="clickable-row" data-href="events.php#event-<?= $event[0] ?>">
                                    <!-- <a href="events.php#event-<?= $event_id ?>">Перейти к событию</a> -->
                                        <td><a href="#"><?= $event[1]?></a></td>
                                        <td><a href="#"><?= $event[3]?></a></td>
                                        <td><a href="#"><?= $event[2]?></a></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                            <button onclick="toggleInteractionsTable()" id="interactionsToggleBtn">Show previous interactions</button>

                            <table id="interactionsTable" style="display: none;">                           
                                <tr>
                                    <th>Liked</th>
                                </tr>
                                <tr>
                                    <td>Event</td>
                                    <td>City</td>
                                    <td>Date</td>
                                </tr>
                                
                                <?php
                                    $id_user = $_SESSION['user']['id_user'];
                                    $reg_events = mysqli_query($connect, "SELECT e.id_event, e.event_name, e.event_date, c.name_city 
                                                                    FROM events e
                                                                    JOIN user_event_interactions uei ON e.id_event = uei.id_event
                                                                    JOIN cities c ON c.id_city = e.event_city
                                                                    WHERE uei.id_user = $id_user AND e.event_date < CURDATE()
                                                                    AND uei.interaction_type = 1");
                                    $reg_events = mysqli_fetch_all($reg_events);
                                    foreach ($reg_events as $event){
                                ?>
                                    <tr class="clickable-row" data-href="events.php#event-<?= $event[0] ?>">
                                    <!-- <a href="events.php#event-<?= $event_id ?>">Перейти к событию</a> -->
                                        <td><a href="#"><?= $event[1]?></a></td>
                                        <td><a href="#"><?= $event[3]?></a></td>
                                        <td><a href="#"><?= $event[2]?></a></td>
                                    </tr>
                                <?php
                                    }
                                ?>

                                <th>Skipped</th>
                                <?php
                                    $id_user = $_SESSION['user']['id_user'];
                                    $reg_events = mysqli_query($connect, "SELECT e.id_event, e.event_name, e.event_date, c.name_city 
                                                                    FROM events e
                                                                    JOIN user_event_interactions uei ON e.id_event = uei.id_event
                                                                    JOIN cities c ON c.id_city = e.event_city
                                                                    WHERE uei.id_user = $id_user AND e.event_date >= CURDATE()
                                                                    AND uei.interaction_type = 0");
                                    $reg_events = mysqli_fetch_all($reg_events);
                                    foreach ($reg_events as $event){
                                ?>
                                    <tr class="clickable-row" data-href="events.php#event-<?= $event[0] ?>">
                                    <!-- <a href="events.php#event-<?= $event_id ?>">Перейти к событию</a> -->
                                        <td><a href="#"><?= $event[1]?></a></td>
                                        <td><a href="#"><?= $event[3]?></a></td>
                                        <td><a href="#"><?= $event[2]?></a></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>  
                    </div>

                    <div class="topic card" id="card_of_styles" style="flex-direction: column;" >
                        <div class="topic__head">
                            <h2 class="no-margin">My Styles</h2>
                        </div>       
                            <div class="topic__content">
                                <div class="card__list" style="justify-content: center;">
                                    
                                    <span class="list--inline">
                                        <?php
                                            $style = mysqli_query($connect, "SELECT DISTINCT s.id_style, s.name_style
                                                                            FROM styles s
                                                                            JOIN event_style
                                                                            ON s.id_style = event_style.id_style
                                                                            JOIN events  
                                                                            ON events.id_event = event_style.id_event
                                                                            JOIN registrations r
                                                                            ON r.id_event = events.id_event
                                                                            WHERE r.id_user = $id_user
                                                                            ORDER BY s.name_style");
                                            $style = mysqli_fetch_all($style);
                                            foreach ($style as $style) {
                                        ?>
                                            <span class="list--inline__item">
                                                <a href="styles.php#style-<?= $style[0] ?>"><?= $style[1] ?></a>
                                            </span>
                                        <?php
                                            }
                                            ?>
                                    </span>
                                </div>

                            </div>                  
                    </div>

                    <div class="topic card" id="card_of_dancers" style="flex-direction: column;" >
                        <div class="topic__head">
                            <h2 class="no-margin">My Dancers</h2>
                        </div>       
                            <div class="topic__content">
                                <div class="card__list" style="justify-content: center;">
                                    
                                    <span class="list--inline">
                                        <?php
                                            $dancers = mysqli_query($connect, "SELECT DISTINCT d.id_dancer, d.name_dancer
                                                                                FROM dancers d
                                                                                JOIN event_guest eg ON d.id_dancer = eg.id_dancer
                                                                                JOIN events e ON e.id_event = eg.id_event
                                                                                JOIN registrations r ON r.id_event = e.id_event
                                                                                WHERE r.id_user = $id_user
                                                                                ORDER BY d.name_dancer;");
                                            $dancers = mysqli_fetch_all($dancers);
                                            foreach ($dancers as $dancer) {
                                        ?>
                                            <span class="list--inline__item">
                                                <a href="dancers.php#dancer-<?= $dancer[0] ?>"><?= $dancer[1] ?></a>
                                            </span>
                                        <?php
                                            }
                                            ?>
                                    </span>
                                </div>

                            </div>                  
                    </div>

                    <div class="topic card" id="card_of_comments" style="flex-direction: column;">
                        <div class="topic__head">
                            <h2 class="no-margin">My comments</h2>
                        </div>       
                        <div class="topic__content">
                            <table>
                                <tr>
                                    <td>Topic</td>
                                    <td>Comment</td>
                                    <td>Date</td>
                                </tr>
                                
                                <?php
                                    $id_user = $_SESSION['user']['id_user'];
                                    $comments = mysqli_query($connect, "SELECT t.title_topic, c.content_comment, c.date_comment
                                                                    FROM comments c
                                                                    JOIN topics t ON t.id_topic = c.id_topic
                                                                    WHERE c.id_user = $id_user");

                                    $comments  = mysqli_fetch_all($comments);
                                    // print_r($comments);
                                    foreach ($comments as $com){
                                ?>
                                    <!-- <tr class="clickable-row" data-href="events.php#event-<?= $event[0] ?>"> -->
                                    <!-- <a href="events.php#event-<?= $event_id ?>">Перейти к событию</a> -->
                                        <td><a href="#"><?= $com[0]?></a></td>
                                        <td><a href="#"><?= $com[1]?></a></td>
                                        <td><a href="#"><?= $com[2]?></a></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                            <!-- <button onclick="toggleEventsTable()" id="eventsToggleBtn">Show other comments</button> -->

                            <table id="eventsTable" style="display: none;">
                                <tr>
                                    <td>Event</td>
                                    <td>City</td>
                                    <td>Date</td>
                                </tr>
                                
                                <?php
                                    $id_user = $_SESSION['user']['id_user'];
                                    $reg_events = mysqli_query($connect, "SELECT e.id_event, e.event_name, e.event_date, c.name_city 
                                                                        FROM events e
                                                                        JOIN registrations r ON e.id_event = r.id_event
                                                                        JOIN cities c ON c.id_city = e.event_city
                                                                        WHERE r.id_user = $id_user AND e.event_date < CURDATE()");
                                    $reg_events = mysqli_fetch_all($reg_events);
                                    foreach ($reg_events as $event){
                                ?>
                                    <tr class="clickable-row" data-href="events.php#event-<?= $event[0] ?>">
                                        <td><a href="#"><?= $event[1]?></a></td>
                                        <td><a href="#"><?= $event[3]?></a></td>
                                        <td><a href="#"><?= $event[2]?></a></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>  
                    </div>

                    <div class="card">
                        <div class="chat-container">
                            
                            
                            <div class="input-container">
                                <input type="text" id="userInput" placeholder="Enter what do you want to find" />
                                <button onclick="sendGeneralMessage()">Search</button>                 
                                <button onclick="clearChat()">Clear chat</button>
                            </div>

                            <div class="button-container" id="action-buttons" style="display: none;">
                                <button onclick="sendButtonMessage('events')">Events</button>
                                <button onclick="sendButtonMessage('dancers')">Dancers</button>
                                <button onclick="sendButtonMessage('studios')">Studios</button>
                                <button onclick="sendButtonMessage('styles')">Styles</button>
                            </div>

                            <div class="message-container" id="chat"></div>
                        </div>
                    </div>
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
            function sendGeneralMessage() {
                const userInput = document.getElementById('userInput').value;
                const chat = document.getElementById('chat');
                // Очищаем чат перед новым запросом
                chat.innerHTML = '';

                if (!userInput) {
                    alert('Please, enter the message');
                    return;
                }

                fetch('http://localhost:5002/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message: userInput })
                })
                .then(response => response.json())
                .then(data => {
                    displayMessage(data.response);
                    if (data.summary) displaySummary(data.summary);
                    
                    const buttons = document.getElementById('action-buttons');
                    buttons.style.display = data.show_buttons ? 'flex' : 'none';
                    
                    // Устанавливаем значение стиля для кнопок
                    if (data.style_name) {
                        document.getElementById('userInput').value = data.style_name;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            function sendButtonMessage(buttonValue) {
                const userInput = document.getElementById('userInput').value;
                const chat = document.getElementById('chat');
                // Очищаем чат перед новым запросом
                chat.innerHTML = '';
                if (!userInput) {
                    alert('Please, enter the message');
                    return;
                }

                fetch('http://localhost:5002/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ 
                        message: userInput,
                        button: buttonValue 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    displayMessage(data.response);
                    // Скрываем кнопки после выбора
                    document.getElementById('action-buttons').style.display = 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }

            function displayMessage(response, autoAction = null) {
                const chat = document.getElementById('chat');
                const messageDiv = document.createElement('div');
                messageDiv.innerHTML = response; 
                chat.appendChild(messageDiv);
            }

            function displaySummary(summary) {
                const chat = document.getElementById('chat');
                const summaryDiv = document.createElement('div');
            }

            function clearChat() {
                document.getElementById('chat').innerHTML = '';
                document.getElementById('userInput').value = '';
                document.getElementById('action-buttons').style.display = 'none';
            }

            document.addEventListener('DOMContentLoaded', () => {
                const rows = document.querySelectorAll('.clickable-row');
                rows.forEach(row => {
                    row.addEventListener('click', () => {
                        window.location.href = row.dataset.href;
                    });
                });
            });

            function toggleEventsTable() {
                const table = document.getElementById('eventsTable');
                const button = document.getElementById('eventsToggleBtn');
                
                if (table.style.display === 'none') {
                    table.style.display = 'table';
                    button.textContent = 'Hide previous events';
                } else {
                    table.style.display = 'none';
                    button.textContent = 'Show previous events';
                }
            }

            function toggleInteractionsTable() {
                const table = document.getElementById('interactionsTable');
                const button = document.getElementById('interactionsToggleBtn');
                
                if (table.style.display === 'none') {
                    table.style.display = 'table';
                    button.textContent = 'Hide previous interactions';
                } else {
                    table.style.display = 'none';
                    button.textContent = 'Show previous interactions';
                }
            }
            
        </script>
        <style>
            .topic{
                margin:5px;
            }
        </style>
        
        <script src="js/script.js"></script>
    </body>
</html>