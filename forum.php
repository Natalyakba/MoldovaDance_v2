<?php 
    session_start();
    require_once './config/connect.php';

    $topic = mysqli_query($connect, "SELECT * FROM topics");
    $topic = mysqli_fetch_all($topic);
    $today = date("F j, Y, g:i a");
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
        <title>Moldova Dancers: Forum</title>
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
                <h1 class="h1__title">Forum</h1>

                <div class="propose">
                    <button class="propose__button">Suggest a topic for discussion</button>
                    <div class="propose__form topic">
                        <form class="form" action="vendor/create_theme.php" method="post">
                        <input class="form__input" type="text" name="name_theme" placeholder="Name of your theme">
                        <textarea class="form__textarea" name="theme_comment" placeholder="Explain why this topic is relevant"></textarea>
                        <div class="form__actions">
                            <button class="button button--submit" type="submit">Send an offer</button>
                        </div>
                        </form>
                    </div>
                </div>

                <?php foreach ($topic as $topic) { ?>
                    <div class="topic" id="topic_<?= $topic[0] ?>">

                        <div class="topic__head">
                            <span class="topic__title"><?= $topic[1] ?></span>
                            <span class="topic__date"><?= $topic[3] ?></span>
                        </div>
                        
                        <div class="topic__content">                          
                            <div class="topic__text"><?= $topic[2] ?></div>   
                            <div class="topic__buttons">
                                <?php
                                    $num_of_comments_query = mysqli_query($connect, "SELECT COUNT(c.id_comment) AS count FROM comments c
                                                                                    WHERE c.id_topic = $topic[0]");
                                    $num_of_comments = mysqli_fetch_assoc($num_of_comments_query);
                                    $num_of_reviews_query = mysqli_query($connect, "SELECT COUNT(er.id) as count
                                                                                    from event_ratings er
                                                                                    JOIN events e on er.id_event = e.id_event
                                                                                    join topics t on e.id_event = t.id_event
                                                                                    where t.id_topic = $topic[0]");
                                    $num_of_reviews = mysqli_fetch_assoc($num_of_reviews_query);
                                    $isEvent = mysqli_query($connect, "SELECT id_event from topics where id_topic = $topic[0]");
                                    $isEvent = mysqli_fetch_assoc($isEvent);
                                    $avgRating = mysqli_query($connect, "SELECT ROUND(AVG(er.rating), 1) as result from event_ratings er 
                                                                            JOIN events e on er.id_event = e.id_event
                                                                            join topics t on e.id_event = t.id_event
                                                                            where t.id_topic = $topic[0]");
                                    $avgRating = mysqli_fetch_assoc($avgRating);
                                    
                                ?>
                                <button class="button comments__toggle">Show Comments (<?= $num_of_comments['count'] ?>) 
                                <?php 
                                    if ($isEvent['id_event'] != NULL) {?>
                                    
                                    / Rating <?= $avgRating['result'] ?> ⭐ (<?= $num_of_reviews['count']?>)
                                    <?php } ?>
                            
                            </button>
                                
                                <button class="button">Add comment</button>
                                <?php if ($topic[4]){ ?>
                                    <button class="event-btn" data-id="<?= $topic[4] ?>">Show info</button>
                                <?php } ?>
                            </div>  
                        </div>  

                        <div class="comments">
                            <div class="comments__have">
                                <?php
                                    $comment = mysqli_query($connect, "SELECT comments.id_comment, comments.content_comment, comments.date_comment
                                                                    FROM comments 
                                                                    JOIN topics ON comments.id_topic = topics.id_topic
                                                                    WHERE topics.id_topic = $topic[0]");
                                    $comment = mysqli_fetch_all($comment);

                                    foreach ($comment as $comment) {
                                ?>
                                    <div class="comment">
                                        <div class="comment__meta">                                   
                                            <?php
                                                $author_of_comment = mysqli_query($connect, "SELECT u.login_user
                                                                                            FROM users u
                                                                                            JOIN comments c
                                                                                            ON u.id_user = c.id_user
                                                                                            WHERE c.id_comment = $comment[0]
                                                                                            ");
                                                $author_of_comment = mysqli_fetch_assoc($author_of_comment);
                                            ?>
                                            <span class="comment__author"><?= $author_of_comment['login_user'] ?></span>
                                            <span class="comment__date"><?= $comment[2] ?></span>
                                        </div>
                                        <div class="comment__body"><?= $comment[1] ?></div>
                                    </div>
                                <?php } ?>

                                <?php
                                    
                                    $reviews_result = mysqli_query($connect, "SELECT u.login_user, er.rating, er.comment, er.created_at
                                    from event_ratings er
                                    JOIN users u on er.id_user = u.id_user
                                    join events e on er.id_event = e.id_event
                                    join topics t on e.id_event = t.id_event
                                    where t.id_topic = $topic[0];");
                                    while ($review = mysqli_fetch_assoc($reviews_result)) {
                                    ?>
                                        <div class="comment">
                                            <div class="comment__meta">                                   
                                                <span class="comment__author"><?= $review['login_user'] ?></span>
                                                <span class="comment__date"><?= $review['created_at'] ?></span>
                                            </div>
                                            <div class="comment__body">⭐ <?= $review['rating'] ?>: <?= $review['comment'] ?></div>
                                        </div>
                                    <?php } ?>

                                
                            </div>

                            <!-- Форма для добавления комментария -->
                            <div class="comments__add" data-user="<?= isset($_SESSION['user']) ? 'true' : 'false' ?>">
                                <div class="comments__form" style="display: none;">
                                    <form class="form" action="vendor/create_com.php" method="post">
                                        <input type="hidden" name="date_comment" value="<?= $today ?>">
                                        <input type="hidden" name="id_topic" value="<?= $topic[0] ?>">
                                        <input type="hidden" name="id_user" value="<?= $_SESSION['user']['id_user'] ?>">

                                        <?php if ($_SESSION['user']) { ?>
                                            <input class="form__input" type="text" name="login_user" value="<?= $_SESSION['user']['login_user'] ?>" readonly>
                                        <?php } else { ?>
                                            <input class="form__input" type="text" name="login_user" placeholder="Name">
                                        <?php } ?>
                                        
                                        <textarea class="form__textarea" name="content_comment" placeholder="Enter your comment"></textarea>
                                        <div class="form__actions">
                                            <button class="button" type="submit">Send comment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> 
                         
                    </div>
                <?php } ?>
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
            document.addEventListener("DOMContentLoaded", function () {
                // Переключение видимости комментариев
                document.querySelectorAll(".comments__toggle").forEach(function (toggleBtn) {
                    toggleBtn.addEventListener("click", function () {
                        const commentsContainer = this.closest(".topic").querySelector(".comments__have");
                        if (commentsContainer) {
                            commentsContainer.style.display = 
                                commentsContainer.style.display === "none" || commentsContainer.style.display === ""
                                ? "block"
                                : "none";
                        }
                    });
                });

                // Показ формы добавления комментария
                document.querySelectorAll(".topic .button:nth-child(2)").forEach(function (addCommentBtn) {
                    addCommentBtn.addEventListener("click", function () {
                        const commentForm = this.closest(".topic").querySelector(".comments__form");
                        if (commentForm) {
                            commentForm.style.display = 
                                commentForm.style.display === "none" || commentForm.style.display === ""
                                ? "block"
                                : "none";
                        }
                    });
                });

                // Переход по кнопке Show Info
                document.querySelectorAll(".event-btn").forEach(function (btn) {
                    btn.addEventListener("click", function () {
                        const eventId = this.dataset.id;
                        if (eventId) {
                            // Перейти на страницу info, например: event_info.php?id=...
                            window.location.href = `events.php#event-${eventId}`;
                        }
                    });
                });

                // Закрытие модального окна (если понадобится)
                const modal = document.getElementById("modal");
                const closeModalBtn = document.getElementById("closeModalBtn");
                if (closeModalBtn) {
                    closeModalBtn.addEventListener("click", () => {
                        modal.style.display = "none";
                    });
                }

                // Если нужно открыть модальное окно
                const openModalBtn = document.getElementById("openModalBtn");
                if (openModalBtn) {
                    openModalBtn.addEventListener("click", () => {
                        modal.style.display = "block";
                    });
                }
            });

        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/script.js"></script>

        
    </body>
</html>