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
        <title>Moldova Dancers</title>
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
        <section class="hero">
        <img src="img/main_image.png" alt="main_image" class="hero__image">
        </section>
        <main class="main-content__index">

            <div class="index-page">
                <div class="index-page__content">
                    <div class="index-page__block" style="width: 50%;">
                        <div class="main-title">Coming soon</div>
                        <img src="https://i.ibb.co/4gRk0Bnp/image-3.png" alt="dancers_girls">
                        <h2 class="index-page__title">Dance Convention</h2>
                        <div class="index-page__date">August, 16</div>
                    </div>
                    <div class="index-page__block">
                        <h2 class="index-page__title" style="text-align: end">First Championship</h2>
                        <div class="index-page__date" style="text-align: end">Juny, 16</div>
                        <img src="https://i.ibb.co/WvGQM2hd/image-2.png" alt="dancer-girl">
                    </div>
                </div>
                <a class="index-page__link" href="events.php">more events -></a>
            </div>
            <div class="index-page greyback">
                <div class="main-title" style="text-align: center;">news</div>
                <div class="index-page__content" style="flex-direction: column; ">
                    <div class="index-page__block" style="flex-direction: row; gap: 30px;">
                        <div class="div">
                            <img src="img/news_1.png" style="width: 350px" alt="dancers_girls">
                        </div>                       
                        <div class="div">
                            <h2 class="index-page__title" style="text-align: end">SPACE VISION [September, 17]</h2>
                            <div class="index-page__text">We have great news! 🌟 On Sunday at 20:30 the most grandiose concert in Moldova
                                 will be broadcast - “SPACE VISION” on @gurinel_tv. This is a concert in which all the groups
                                  in our studio participated, from talented beginners to real professionals! Don't miss this unique
                                   chance to see the most talented people in the country! Sit back, invite your family and spend time with us.</div>
                        </div>              
                    </div>
                    <div class="index-page__block" style="flex-direction: row; gap: 30px;">
                        <div class="div">
                            <img src="img/news_2.png" style="width: 350px" alt="dancers_girls">
                        </div>                       
                        <div class="div">
                            <h2 class="index-page__title" style="text-align: end">STRIP Convention</h2>
                            <div class="index-page__text">What is the High Heels - Strip Convention?
                This is first and foremost a place where everyone can be themselves. A place where everyone manifests themselves as they wish.
                A place of heels, beautiful dancing and incredible energy
                And secondly, this is a place of growth. Not only dance, but also personal! After 
                the convention you will definitely not be the same again. We bring you only 
                the best teachers and personalities who will make this convention incredible.</div>
                        </div>              
                    </div>
                    <div class="index-page__block" style="flex-direction: row; gap: 30px;">
                        <div class="div">
                            <img src="img/news_3.png" style="width: 350px" alt="dancers_girls">
                        </div>                       
                        <div class="div">
                            <h2 class="index-page__title" style="text-align: end">R.a.r. Team</h2>
                            <div class="index-page__text">We went to @worldofdance_france in February with two teams and this was our first experience of this scale 🤩 Here are our first favorites: RAR adults X Bumblebi. Together we took 4th place: 87/100 points (1st place – 89 points). We are taking confident steps to the global level. And we're not going to stop. And don’t forget about RAR juniors - KINDER GARDEN 👶🏼👧🧒🏻 They were even invited to America for the championship finals🇺🇸 We hope to go next year. Therefore, if you want to become our SPONSORS, we will be very glad. We feel so happy and motivated to keep working! Expect further criticism from us.</div>
                        </div>              
                    </div>
                </div>
                <a class="index-page__link" href="news.php">more news -></a>
            </div>
            <div class="index-page">
                <div class="index-page__content">
                    <div class="index-page__block" style="width: 50%;">
                        
                        <h2 class="index-page__title" style="text-align: center;">MOLDOVA DANCE</h2>
                        <div class="index-page__text">
                            is an information dance community of Moldova. Here we announce the events of the republic
                            and neighboring countries: competitions, 
                            classes, intensives, castings. We will introduce
                            you to our best dancers, teachers and studios.</div>
                        <img src="img/about_1.jpg" alt="about_girls">
                    </div>
                    <div class="index-page__block" style="width: 50%;">
                        <div class="main-title">about us</div>
                        <img src="img/about_2.png" style="width: 350px" alt="logo_md">
                    </div>
                </div>
                <a class="index-page__link" href="events.php">more events -></a>
            </div>
            <div class="index-page greyback">
                <div class="main-title" style="text-align: center;">FORMATIONS</div>
                <div class="index-page__content">
                    <div class="index-page__block" style="width: 50%;">
                        <img src="img/teams_1.png" style="height: 500px;
    width: fit-content;" alt="team_1">
                        <h2 class="index-page__title">COBRAS TEAM</h2>
                        <a class="index-page__link" href="teams.php">more info -></a>
                    </div>
                    <div class="index-page__block" style="width: 50%;">
                        <img src="img/teams_2.png" alt="team_2">
                        <h2 class="index-page__title">KINJAZ CREWn</h2>
                        <a class="index-page__link" href="teams.php">more info-></a>
                    </div>
                </div>
                <a class="index-page__link" href="teams.php">more teams -></a>
            </div>
            <div class="index-page">
                <div class="index-page__content">
                    <div class="main-title" style="text-align: center; writing-mode: vertical-rl; transform: scale(-1)">articles</div>
                    <div class="index-page__block" style="width: 50%;">
                        <h2 class="index-page__title" style="text-align: center; ">SOME THEORIES OF DANCE IN CONTEMPORARY SOCIETY</h2>
                        <div class="index-page__text">
                            What “counts” as philosophy is a perennial issue that has been debated both within and outside of the American Philosophical 
                            Association. Is interdisciplinary philosophy that incorporates not just insights from other fields but their methods, commitments, 
                            and forms of discourse still “philosophy”?
                            This article assumes that it is, holding that a philosophy of something can make recourse to conversations and practices in 
                            all the domains that are relevant to what it is of (in this case dance) so long as doing so aids our thinking about the 
                            meaning of that domain. “Philosophy” is thus construed broadly here in keeping with how the term is used in the 
                            rapidly growing field of the philosophy of dance. The potential for dance philosophy is enormous, in part because dance 
                            itself is multifaceted enough to make it connect with many branches of philosophy. Indeed, dance has been practiced 
                            throughout history for artistic, educational, therapeutic, social, political, religious and other purposes.</div>
                    </div>
                    <div class="index-page__block" style="width: 50%;">
                        <h2 class="index-page__title" style="text-align: center;">THE PHILOSOPHY OF DANCE</h2>
                        <div class="index-page__text">
                            T. S. Eliot has claimed that ballet is valuablebecause it has unconsciously concerned itself with a permanent form! 
                            The majority of intellectuals agree with him in feeling that whatever ballet, or dance generally, has achieved is
                             the result of intuitively sound construction on the part of a few naturally gifted, but uncultivated, individuals.
                             That practical accomplishments in dance have been largely independent of serious theoretical formulations can
                              hardly be denied by those who have seen the rhapsodic effusions of recent dance "criticism." How-ever, philosophical
                               discussions of the art do exist, and they may yet be influential if attention is called to their significance. 
                               Among the contemporary writers some have chosen to diseuss dance by locating their subject matter in the field of 
                               the social sciences. Rather than considering the art as an isolated phenomenon, they hold that it may be most 
                               profitably illuminated when viewed in a context not specifically aesthetic. Yet their conclusions are aesthetic, 
                               not sociological. These men are primarily concerned with the nature of an art form; with the process of its creation, 
                               the relationships of its parts, and the sources of its effectiveness.</div>
                    </div>
                </div>
                <a class="index-page__link" href="teams.php">more articles -></a>

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