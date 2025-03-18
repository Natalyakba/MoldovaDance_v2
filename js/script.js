document.addEventListener("DOMContentLoaded", function () {
  // Модальное окно
  const modal = document.getElementById("modal");
  const closeBtn = document.getElementById("closeModalBtn");

  function openModal() {
    if (modal) modal.style.display = "flex";
  }

  function closeModal() {
    if (modal) modal.style.display = "none";
  }

  if (modal && closeBtn) {
    closeBtn.addEventListener("click", closeModal);

    window.addEventListener("click", (event) => {
      if (event.target === modal) {
        closeModal();
      }
    });
  } else {
    console.error("Модальное окно не найдено.");
  }

  // Обработчик для кнопки входа в шапке
  document.querySelectorAll("#openModalBtn").forEach((btn) => {
    btn.addEventListener("click", (event) => {
      event.preventDefault();
      openModal();
    });
  });

  // Форма предложения темы
  const button = document.querySelector(".propose__button");
  const form = document.querySelector(".propose__form");

  if (button && form) {
    form.style.display = "none";

    button.addEventListener("click", function () {
      form.style.display =
        form.style.display === "none" || form.style.display === ""
          ? "block"
          : "none";
    });
  }

  // Разворачивание topic__content при клике на topic__head
  document.querySelectorAll(".topic__head").forEach((head) => {
    const content = head.nextElementSibling;
    if (content && content.classList.contains("topic__content")) {
      content.style.display = "none";

      head.addEventListener("click", function () {
        content.style.display =
          content.style.display === "none" ? "block" : "none";
      });
    }
  });

  // Разворачивание comments__form или открытие модального окна
  document.querySelectorAll(".comments__add").forEach((commentAdd) => {
    const commentBtn = commentAdd.querySelector(".button");
    const commentForm = commentAdd.querySelector(".comments__form");
    const isUserLoggedIn = commentAdd.dataset.user === "true"; // Проверяем авторизацию

    if (commentBtn) {
      commentBtn.addEventListener("click", function () {
        if (isUserLoggedIn && commentForm) {
          commentForm.style.display =
            commentForm.style.display === "none" ? "block" : "none";
        } else {
          openModal();
        }
      });
    }
  });

  // Скрытие комментариев по умолчанию и отображение при клике на кнопку
  document.querySelectorAll(".comments").forEach((commentsBlock) => {
    const showBtn = commentsBlock.querySelector(".button");
    const commentsHave = commentsBlock.querySelector(".comments__have");

    if (showBtn && commentsHave) {
      commentsHave.style.display = "none";

      showBtn.addEventListener("click", function () {
        commentsHave.style.display =
          commentsHave.style.display === "none" ? "block" : "none";
      });
    }
  });

  // Проверка на пустые комментарии перед отправкой формы
  document.querySelectorAll(".form").forEach((form) => {
    form.addEventListener("submit", function (event) {
      const textarea = form.querySelector(".form__textarea");
      if (!textarea.value.trim()) {
        event.preventDefault();
        alert("Комментарий не может быть пустым!");
      }
    });
  });
});
