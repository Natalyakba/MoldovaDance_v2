<?php 
    session_start();
    require_once './config/connect.php';

    $events = mysqli_fetch_all(mysqli_query($connect, "SELECT id_event, event_name FROM `events` ORDER BY event_name;"));
    $dancers = mysqli_fetch_all(mysqli_query($connect, "SELECT d.id_dancer, 
                                                            d.name_dancer, 
                                                            GROUP_CONCAT(s.name_style SEPARATOR ', ') AS styles_string
                                                        FROM dancers d
                                                        JOIN dancer_style ds ON ds.id_dancer = d.id_dancer
                                                        JOIN styles s ON s.id_style = ds.id_style
                                                        GROUP BY d.id_dancer, d.name_dancer
                                                        ORDER BY d.name_dancer;"));
    $citiesMoldova = mysqli_fetch_all(mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country = 'Moldova' ORDER BY name_city;"));
    $citiesOther = mysqli_fetch_all(mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country != 'Moldova' ORDER BY name_city;"));
    $eventTypes = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM event_types WHERE id_event_type != 4"));
    $styles = mysqli_fetch_all(mysqli_query($connect, "SELECT id_style, name_style FROM styles ORDER BY name_style;"));
    $teams = mysqli_fetch_all(mysqli_query($connect, "SELECT id_team, name_team FROM teams;"));
    $studios = mysqli_fetch_all(mysqli_query($connect, "SELECT id_studio, name_studio FROM studios;"));

    $edit = $_SESSION['edit_event_data'] ?? null;

    
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
        <title>Moldova Dancers: administration</title>
    </head>
    <body>
        <header class="header">
            <div class="container">
                <div class="header__body">
                    <!-- Logo -->
                    <a href="index.php" class="header__logo">
                        <span class="header__logo-text">MOLDOVA DANCE</span>
                    </a>

                    <!-- Burger-menu -->
                    <div class="header__burger">
                        <span class="header__burger-line"></span>
                    </div>

                    <!-- Main menu-->
                    <nav class="header__menu">
                        <ul class="header__list">
                            <!-- About Us -->
                            <li class="header__item">
                                <a href="index.php#aboutus" class="header__link">About Us</a>
                            </li>

                            <!-- Events-->
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
            <h1 class="h1__title">Administration</h1>

            <!-- Секция форм -->
            <div class="main-content__cards">
                <!-- Панель с кнопками -->
                <div class="admin-menu">
                    <button data-target="form_add_event">➕ Add or ✏️ Edit Event</button>
                    <button data-target="form_add_dancer">➕ Add or ✏️ Edit Dancer</button>
                </div>
               
                <div class="card" id="form_add_event" style="display: none;">
                    <h2>Add Event</h2>
                    <div class="form-column">
                    <div class="form-section">
                        <form id="event_form">
                            *or choose for edit  
                            <select name="event_id" id="event_select">
                                <option value="">Choose Event</option>
                                <?php
                                $events = mysqli_query($connect, "SELECT id_event, event_name FROM events ORDER BY event_date DESC");
                                while ($event = mysqli_fetch_assoc($events)):
                                ?>
                                    <option value="<?= $event['id_event'] ?>"><?= $event['event_name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                            <button type="submit" id="submit_event">Enter</button>
                        </form>
                    </div>
                    
                    <form action="vendor/create_event.php" method="post" class="event-form">                        
                        <div class="form-column">
                            <div class="form-section">
                                <h3 class="section-title">Main Information</h3>
                                <div class="form-group">
                                    <input type="text" name="event_name" placeholder="Event Title" class="form-input" required>
                                </div>
                                
                                <div class="form-group">
                                    <input type="date" name="event_date" class="form-input" required>
                                </div>
                                
                                <div class="form-group">
                                    <textarea name="event_about" placeholder="Event Description" class="form-textarea" rows="4"></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" name="event_afisha" placeholder="Poster Image URL" class="form-input">
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Location</h3>
                                <div class="city-selectors">
                                    <div class="form-group">
                                        <label class="form-label">Moldova</label>
                                        <select name="id_city_md" class="form-select city-selector" id="input_md_city" data-other="input_str_city">
                                            <option value="">Select Moldovan City</option>
                                            <?php 
                                            $city1 = mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country = 'Moldova' ORDER BY name_city;");
                                            $city1 = mysqli_fetch_all($city1);
                                            foreach ($city1 as $city): ?>
                                                <option value="<?= $city[0] ?>"><?= $city[1] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label">Other Countries</label>
                                        <select name="id_city_other" class="form-select city-selector" id="input_str_city" data-other="input_md_city">
                                            <option value="">Select International City</option>
                                            <?php 
                                            $city2 = mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country != 'Moldova' ORDER BY name_city;");
                                            $city2 = mysqli_fetch_all($city2);
                                            foreach ($city2 as $city): ?>
                                                <option value="<?= $city[0] ?>"><?= $city[1] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="id_city" id="selected_city">
                            </div>     

                            <div class="form-section">
                                <h3 class="section-title">Event Type</h3>
                                <div class="radio-group">
                                <?php 
                                $type_query = mysqli_query($connect, "SELECT id_event_type as id, title_event_type as name 
                                                                FROM event_types 
                                                                WHERE id_event_type != 4");
                                ?>

                                <?php while ($type = mysqli_fetch_assoc($type_query)): ?>
                                    <label class="radio-label">
                                        <input type="radio" name="event_type" value="<?= $type['id'] ?>" class="radio-input">
                                        <span class="radio-custom"></span>
                                        <?= $type['name'] ?>
                                    </label>
                                <?php endwhile; ?>
                                </div>
                            </div>
                                
                            <div class="form-section">
                                <h3 class="section-title">Dance Styles</h3>
                                <div class="multi-selector">
                                    <div id="selected_styles" class="selected-items"></div>
                                    <select class="style-selector" data-target="selected_styles">
                                        <option value="">Add dance styles</option>
                                        <?php foreach ($styles as $style): ?>
                                            <option value="<?= $style[0] ?>"><?= $style[1] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!-- Контейнер для скрытых input'ов -->
                                    <div id="hidden_styles_container"></div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Featured Dancers</h3>
                                <div class="multi-selector">
                                    <div id="selected_dancers" class="selected-items"></div>
                                    <select class="dancer-selector" data-target="selected_dancers">
                                        <option value="">Add dancers</option>
                                        <?php foreach ($dancers as $dancer): ?>
                                            <option value="<?= $dancer[0] ?>"><?= $dancer[1] ?> (<?= $dancer[2] ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!-- Контейнер для скрытых input'ов -->
                                    <div id="hidden_dancers_container"></div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Price</h3>

                                <div class="form-group">
                                    <input type="text" name="event_price" placeholder="Ticket Price" class="form-input">
                                </div>
                            </div>
                                    
                            <div class="form-section">
                                <h3 class="section-title">Link and contact</h3>

                                <div class="form-group">
                                    <input type="url" name="event_link" placeholder="Event Website URL" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" name="event_contact" placeholder="Organizer Contact" class="form-input">
                                </div>
                            </div>

                            <input type="hidden" name="id_event" value="">
                        </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Create Event</button>
                                <button type="reset" class="btn btn-secondary">Reset Form</button>
                            </div>
                        </div>
                    </form>  
                </div>


                <!-- 🕺 Форма добавления танцора -->
                <div class="card" id="form_add_dancer" style="display: none;">
                    <h2>Add Dancer</h2>
                    <div class="form-column">
                    <div class="form-section">
                        <form id="dancer_form">
                            *or choose for edit  
                            <select name="id_dancer" id="dancer_select">
                                <option value="">Choose Dancer</option>
                                <?php
                                $dancers = mysqli_query($connect, "SELECT id_dancer, name_dancer FROM dancers ORDER BY name_dancer DESC");
                                while ($dancer = mysqli_fetch_assoc($dancers)):
                                ?>
                                    <option value="<?= $dancer['id_dancer'] ?>"><?= $dancer['name_dancer'] ?></option>
                                <?php endwhile; ?>
                            </select>
                            <button type="submit" id="submit_dancer">Enter</button>
                        </form>
                    </div>

                    <form action="vendor/create_dancer.php" method="post" class="dancer-form">
                        <div class="form-column">
                            <div class="form-section">
                                <h3 class="section-title">Main Information</h3>
                                <input type="hidden" name="id_dancer" id="id_dancer">

                                <div class="form-group">
                                    <input type="text" name="name_dancer" placeholder="Full Name" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="photo_dancer" placeholder="Photo URL" class="form-input">
                                </div>

                                <div class="form-group">
                                    <textarea name="about_dancer" placeholder="About the dancer" class="form-textarea" rows="4"></textarea>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">City</h3>

                                <div class="city-selectors">
                                    <div class="form-group">
                                        <label class="form-label">Moldova</label>
                                        <select name="id_city_md_dancer" class="form-select city-selector" id="input_md_city_dancer" data-other="input_str_city">
                                            <option value="">Select Moldovan City</option>
                                            <?php 
                                            $city1 = mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country = 'Moldova' ORDER BY name_city;");
                                            $city1 = mysqli_fetch_all($city1);
                                            foreach ($city1 as $city): ?>
                                                <option value="<?= $city[0] ?>"><?= $city[1] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Other Countries</label>
                                        <select name="id_city_other_dancer" class="form-select city-selector" id="input_str_city_dancer" data-other="input_md_city_dancer">
                                            <option value="">Select International City</option>
                                            <?php 
                                            $city2 = mysqli_query($connect, "SELECT id_city, name_city FROM cities WHERE name_country != 'Moldova' ORDER BY name_city;");
                                            $city2 = mysqli_fetch_all($city2);
                                            foreach ($city2 as $city): ?>
                                                <option value="<?= $city[0] ?>"><?= $city[1] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="id_city_dancer" id="selected_city_dancer">
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Teams</h3>

                                <div class="multi-selector">
                                    <div id="selected_teams" class="selected-items"></div>
                                    <select class="team-selector" data-target="selected_teams">
                                        <option value="">Add Teams</option>
                                        <?php 
                                        $teams = mysqli_query($connect, "SELECT id_team, name_team FROM teams;");
                                        $teams = mysqli_fetch_all($teams);
                                        foreach ($teams as $team): ?>
                                            <option value="<?= $team[0] ?>"><?= $team[1] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="hidden_teams_container"></div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Teaching Activity</h3>

                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="is_teacher" value="1" class="radio-input">
                                        <span class="radio-custom"></span>
                                        Yes
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="is_teacher" value="0" class="radio-input">
                                        <span class="radio-custom"></span>
                                        No
                                    </label>
                                </div>


                                <h3 class="section-title">Studios</h3>

                                <div class="multi-selector">
                                    <div id="selected_studios" class="selected-items"></div>
                                    <select class="studio-selector" data-target="selected_studios">
                                        <option value="">Add Studios</option>
                                        <?php 
                                        $studios = mysqli_query($connect, "SELECT id_studio, name_studio FROM studios;");
                                        $studios = mysqli_fetch_all($studios);
                                        foreach ($studios as $studio): ?>
                                            <option value="<?= $studio[0] ?>"><?= $studio[1] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="hidden_studios_container"></div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Dance Styles</h3>

                                <div class="multi-selector">
                                    <div id="selected_styles_dancer" class="selected-items"></div>
                                    <select class="style-selector" data-target="selected_styles_dancer">
                                        <option value="">Add Dance Styles</option>
                                        <?php 
                                        $styles = mysqli_query($connect, "SELECT id_style, name_style FROM styles ORDER BY name_style;");
                                        $styles = mysqli_fetch_all($styles);
                                        foreach ($styles as $style): ?>
                                            <option value="<?= $style[0] ?>"><?= $style[1] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="hidden_styles_dancer_container"></div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3 class="section-title">Contacts</h3>

                                <div class="form-group">
                                    <input type="url" name="link_dancer" placeholder="Social Media Link" class="form-input">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Add Dancer</button>
                            <button type="reset" class="btn btn-secondary">Reset Form</button>
                        </div>
                    </form>
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
        <script src="js/script.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Обработчики для кнопок меню
                const buttons = document.querySelectorAll('.admin-menu button');
                const sections = document.querySelectorAll('.card');

                buttons.forEach(button => {
                    button.addEventListener('click', () => {
                        const target = button.getAttribute('data-target');
                        sections.forEach(section => {
                            section.style.display = (section.id === target) ? 'block' : 'none';
                        });
                    });
                });

                // Функция для многократного выбора
                function initMultiSelect(selectorClass, inputName) {
                    document.querySelectorAll(selectorClass).forEach(select => {
                        const targetId = select.getAttribute('data-target');
                        const selectedDiv = document.getElementById(targetId);
                        let selectedItems = [];

                        select.addEventListener('change', function () {
                            const value = this.value;
                            if (value && !selectedItems.includes(value)) {
                                selectedItems.push(value);
                                renderSelected();
                            }
                            this.value = ''; // Очистка выбора после добавления
                        });

                        function renderSelected() {
                            selectedDiv.innerHTML = selectedItems.map(id => {
                                const name = select.querySelector(`option[value="${id}"]`).textContent;
                                return `<span class="selected-tag" data-id="${id}">
                                            ${name}
                                            <button type="button" class="remove-btn">×</button>
                                        </span>`;
                            }).join('');

                            const oldInputs = selectedDiv.parentElement.querySelectorAll('input.hidden-dynamic');
                            oldInputs.forEach(input => input.remove());

                            selectedItems.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = inputName;
                                input.value = id;
                                input.classList.add('hidden-dynamic');
                                selectedDiv.parentElement.appendChild(input);
                            });

                            selectedDiv.querySelectorAll('.remove-btn').forEach(btn => {
                                btn.addEventListener('click', function () {
                                    const tag = this.closest('.selected-tag');
                                    const idToRemove = tag.getAttribute('data-id');
                                    selectedItems = selectedItems.filter(id => id !== idToRemove);
                                    renderSelected();
                                });
                            });
                        }
                    });
                }

                // Инициализация многократного выбора для стилей и танцоров
                initMultiSelect('.style-selector', 'id_style[]');
                initMultiSelect('.dancer-selector', 'id_dancer[]');

                // Обработчик для выбора города
                const citySelectors = document.querySelectorAll('.city-selector');
                citySelectors.forEach(select => {
                    select.addEventListener('change', function () {
                        if (this.value) {
                            const otherSelector = document.getElementById(this.dataset.other);
                            otherSelector.value = '';
                            document.getElementById('selected_city').value = this.value;
                        }
                    });
                });

                const selectedCity = [...citySelectors].find(s => s.value);
                if (selectedCity) {
                    document.getElementById('selected_city').value = selectedCity.value;
                }

                // Заполнение формы редактирования данных события при выборе события
                const eventSelect = document.getElementById('event_select');
                const formEditEvent = document.getElementById('form_edit_event');
                const eventForm = document.getElementById('event_form');

                eventForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const eventId = eventSelect.value;
                    if (eventId) {
                        fetchEventData(eventId);
                    } else {
                        alert('Please choose an event!');
                    }
                });

                // Функция для получения данных события по AJAX
                function fetchEventData(eventId) {
                    fetch('vendor/get_event_data.php', {
                        method: 'POST',
                        body: new URLSearchParams({ 'event_id': eventId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            fillEditForm(data);
                            formEditEvent.style.display = 'block';
                        } else {
                            alert(data.message || 'Error fetching event data.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }

                // Функция для заполнения формы редактирования
                function fillEditForm(data) {
                    const event = data.event;

                    // Основная информация
                    document.querySelector('input[name="id_event"]').value = event.id_event;
                    document.querySelector('input[name="event_name"]').value = event.event_name;
                    document.querySelector('input[name="event_date"]').value = event.event_date;
                    document.querySelector('textarea[name="event_about"]').value = event.event_about;
                    document.querySelector('input[name="event_afisha"]').value = event.event_afisha;

                    // Локация
                    document.querySelector('select[name="id_city_md"]').value = event.event_city;

                    // Тип мероприятия
                    const eventTypeRadio = document.querySelector(`input[name="event_type"][value="${event.event_type}"]`);
                    if (eventTypeRadio) eventTypeRadio.checked = true;

                    // Создаем глобальные массивы для хранения выбранных элементов
                    window.selectedStyles = data.styles || [];
                    window.selectedDancers = data.dancers || [];

                    // Функция для рендеринга выбранных элементов
                    function renderSelectedItems(containerId, items, selectorClass, inputName) {
                    const container = document.getElementById(containerId);
                    const select = document.querySelector(selectorClass);
                    const hiddenContainer = document.getElementById(`hidden_${containerId}_container`) || 
                                            document.createElement('div');
                    
                    // Создаем скрытый контейнер, если его еще нет
                    if (!document.getElementById(`hidden_${containerId}_container`)) {
                        hiddenContainer.id = `hidden_${containerId}_container`;
                        container.parentNode.appendChild(hiddenContainer);
                    }
                    
                    // Добавляем новые элементы без очистки контейнера
                    items.forEach(itemId => {
                        const option = select.querySelector(`option[value="${itemId}"]`);
                        if (option) {
                            // Проверяем, не добавлен ли уже элемент
                            if (!container.querySelector(`.selected-tag[data-id="${itemId}"]`)) {
                                // Добавляем скрытый input
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = inputName;
                                hiddenInput.value = itemId;
                                hiddenInput.classList.add('hidden-dynamic');
                                hiddenContainer.appendChild(hiddenInput);
                                
                                // Добавляем тег
                                const tag = document.createElement('span');
                                tag.className = 'selected-tag';
                                tag.dataset.id = itemId;
                                tag.innerHTML = `
                                    ${option.textContent}
                                    <button type="button" class="remove-btn">×</button>
                                `;
                                container.appendChild(tag);
                                
                                // Добавляем обработчик для кнопки удаления
                                tag.querySelector('.remove-btn').addEventListener('click', function() {
                                    if (containerId === 'selected_styles') {
                                        window.selectedStyles = window.selectedStyles.filter(id => id !== itemId);
                                    } else {
                                        window.selectedDancers = window.selectedDancers.filter(id => id !== itemId);
                                    }
                                    hiddenInput.remove();
                                    tag.remove();
                                });
                            }
                        }
                    });
                }


                // Создаем контейнер для скрытых input'ов, если его нет
                function createHiddenContainer(parent, name) {
                    const container = document.createElement('div');
                    container.className = 'hidden-items-container';
                    container.dataset.inputName = name;
                    parent.appendChild(container);
                    return container;
                }

                // Инициализируем рендеринг выбранных элементов
                renderSelectedItems('selected_styles', window.selectedStyles, '.style-selector', 'id_style[]');
                renderSelectedItems('selected_dancers', window.selectedDancers, '.dancer-selector', 'id_dancer[]');

                // Обновляем обработчики для select'ов
                function setupSelectHandler(selector, itemsArray, containerId, inputName) {
                    const select = document.querySelector(selector);
                    select.addEventListener('change', function() {
                        const value = this.value;
                        if (value && !itemsArray.includes(value)) {
                            itemsArray.push(value);
                            renderSelectedItems(containerId, itemsArray, selector, inputName);
                        }
                        this.value = '';
                    });
                }

                setupSelectHandler('.style-selector', window.selectedStyles, 'selected_styles', 'id_style[]');
                setupSelectHandler('.dancer-selector', window.selectedDancers, 'selected_dancers', 'id_dancer[]');

                // Цена
                document.querySelector('input[name="event_price"]').value = event.event_price;

                // Ссылка и контакт
                document.querySelector('input[name="event_link"]').value = event.event_link;
                document.querySelector('input[name="event_contact"]').value = event.event_contact;
            }
            });


        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Основные элементы
                const dancerSelect = document.getElementById('dancer_select');
                const submitButton = document.getElementById('submit_dancer');
                const resetButton = document.querySelector('.dancer-form button[type="reset"]');

                // Глобальные массивы для хранения выбранных элементов
                const selectedItems = {
                    teams: new Set(),
                    studios: new Set(),
                    styles: new Set()
                };

                // Инициализация
                initSelects();
                initEventListeners();

                function initSelects() {
                    // Инициализация всех select элементов
                    initMultiSelect('.team-selector', 'selected_teams', 'hidden_teams_container', 'teams[]', 'teams');
                    initMultiSelect('.studio-selector', 'selected_studios', 'hidden_studios_container', 'studios[]', 'studios');
                    initMultiSelect('.style-selector', 'selected_styles_dancer', 'hidden_styles_dancer_container', 'styles[]', 'styles');
                }

                function initEventListeners() {
                    // Обработчик кнопки "Enter"
                    submitButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (!dancerSelect.value) {
                            alert('Please choose a dancer');
                            return;
                        }
                        loadDancerData(dancerSelect.value);
                    });

                    // Обработчик кнопки "Reset"
                    resetButton.addEventListener('click', function() {
                        clearAllTags();
                    });
                }

                function initMultiSelect(selector, containerId, hiddenId, inputName, type) {
                    const select = document.querySelector(selector);
                    if (!select) return;

                    select.addEventListener('change', function() {
                        if (this.value && !selectedItems[type].has(this.value)) {
                            addTag(containerId, hiddenId, this.value, this.options[this.selectedIndex].text, inputName, type);
                            this.value = '';
                        }
                    });
                }

                function loadDancerData(dancerId) {
                    fetch('vendor/get_dancer_data.php?id_dancer=' + dancerId)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                fillForm(data.dancer);
                            } else {
                                alert('Error: ' + (data.error || 'Failed to load data'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Request failed');
                        });
                }

                function fillForm(dancer) {
                    // Основные поля
                    setValue('input[name="name_dancer"]', dancer.name_dancer);
                    setValue('input[name="photo_dancer"]', dancer.photo_dancer);
                    setValue('textarea[name="about_dancer"]', dancer.about_dancer);
                    setValue('input[name="link_dancer"]', dancer.link_dancer);
                    setValue('input[name="id_dancer"]', dancer.id_dancer);  


                    // Город
                    if (dancer.id_city) {
                        const mdSelect = document.getElementById('input_md_city_dancer');
                        const otherSelect = document.getElementById('input_str_city_dancer');

                        if (mdSelect.querySelector(`option[value="${dancer.id_city}"]`)) {
                            mdSelect.value = dancer.id_city;
                            otherSelect.value = '';
                        } else if (otherSelect.querySelector(`option[value="${dancer.id_city}"]`)) {
                            otherSelect.value = dancer.id_city;
                            mdSelect.value = '';
                        }
                        setValue('#selected_city_dancer', dancer.id_city);
                    }

                    // Преподаватель
                    if (dancer.is_teacher !== undefined) {
                        const radio = document.querySelector(`input[name="is_teacher"][value="${dancer.is_teacher}"]`);
                        if (radio) radio.checked = true;
                    }

                    // Заполняем множественные выборы
                    if (dancer.teams) fillMultiSelect('teams', dancer.teams);
                    if (dancer.studios) fillMultiSelect('studios', dancer.studios);
                    if (dancer.styles) fillMultiSelect('styles', dancer.styles);
                }

                function fillMultiSelect(type, items) {
                    const config = {
                        teams: { container: 'selected_teams', hidden: 'hidden_teams_container', name: 'teams[]' },
                        studios: { container: 'selected_studios', hidden: 'hidden_studios_container', name: 'studios[]' },
                        styles: { container: 'selected_styles_dancer', hidden: 'hidden_styles_dancer_container', name: 'styles[]' }
                    }[type];

                    items.forEach(item => {
                        // Проверяем, существует ли уже этот тег в контейнере
                        if (!selectedItems[type].has(item.id.toString())) {
                            addTag(config.container, config.hidden, item.id, item.name, config.name, type);
                        }
                    });
                }

                function addTag(containerId, hiddenId, value, text, inputName, type) {
                    const container = document.getElementById(containerId);
                    const hiddenContainer = document.getElementById(hiddenId);

                    if (!container || !hiddenContainer) return;

                    // Проверяем, был ли уже добавлен этот тег
                    if (selectedItems[type].has(value.toString())) return;

                    // Добавляем в глобальный массив
                    selectedItems[type].add(value.toString());

                    // Создаем тег
                    const tag = document.createElement('span');
                    tag.className = 'selected-tag';
                    tag.dataset.id = value;
                    tag.innerHTML = `${text} <button type="button" class="remove-tag" data-type="${type}">×</button>`;
                    container.appendChild(tag);

                    // Создаем скрытое поле
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = inputName;
                    hiddenInput.value = value;
                    hiddenContainer.appendChild(hiddenInput);

                    // Обработчик удаления
                    tag.querySelector('.remove-tag').addEventListener('click', function() {
                        selectedItems[type].delete(value.toString());
                        tag.remove();
                        hiddenInput.remove();
                    });
                }

                function clearAllTags() {
                    // Очищаем все контейнеры
                    Object.keys(selectedItems).forEach(type => {
                        const config = {
                            teams: { container: 'selected_teams', hidden: 'hidden_teams_container' },
                            studios: { container: 'selected_studios', hidden: 'hidden_studios_container' },
                            styles: { container: 'selected_styles_dancer', hidden: 'hidden_styles_dancer_container' }
                        }[type];

                        document.getElementById(config.container).innerHTML = '';
                        document.getElementById(config.hidden).innerHTML = '';
                        selectedItems[type].clear();
                    });

                    // Сбрасываем радио-кнопки
                    document.querySelectorAll('input[name="is_teacher"]').forEach(radio => {
                        radio.checked = false;
                    });
                }

                function setValue(selector, value) {
                    const element = document.querySelector(selector);
                    if (element) element.value = value || '';
                }
            });

        </script>

    </body>
</html>