document.addEventListener("DOMContentLoaded", function () {
  // Модальное окно авторизации
  const modal = document.getElementById("modal");
  const closeBtn = document.getElementById("closeModalBtn");

  function openModal() {
    if (modal) modal.style.display = "flex";
  }

  function closeModal() {
    if (modal) modal.style.display = "none";
  }

  // Кнопка открытия модального окна
  document.querySelectorAll("#openModalBtn").forEach((btn) => {
    btn.addEventListener("click", (event) => {
      event.preventDefault();
      openModal();
    });
  });

  if (modal && closeBtn) {
    closeBtn.addEventListener("click", closeModal);

    window.addEventListener("click", (event) => {
      if (event.target === modal) closeModal();
    });
  }

  // Форма предложения темы
  const proposeBtn = document.querySelector(".propose__button");
  const proposeForm = document.querySelector(".propose__form");

  if (proposeBtn && proposeForm) {
    proposeForm.style.display = "none";
    proposeBtn.addEventListener("click", () => {
      proposeForm.style.display =
        proposeForm.style.display === "none" || proposeForm.style.display === ""
          ? "block"
          : "none";
    });
  }

  // Разворачивание topic__content
  document.querySelectorAll(".topic__head").forEach((head) => {
    const content = head.nextElementSibling;
    if (content && content.classList.contains("topic__content")) {
      content.style.display = "none";
      head.addEventListener("click", () => {
        content.style.display =
          content.style.display === "none" ? "block" : "none";
      });
    }
  });

  // Показ комментариев и формы комментария
  document.querySelectorAll(".topic").forEach((topic) => {
    const showCommentsBtn = topic.querySelector(".comments__toggle");
    const commentsHave = topic.querySelector(".comments__have");
    const addCommentBtn = topic.querySelector(
      ".topic__buttons .button:nth-child(2)"
    );
    const commentsAdd = topic.querySelector(".comments__form");

    if (showCommentsBtn && commentsHave) {
      commentsHave.style.display = "none";
      showCommentsBtn.addEventListener("click", () => {
        commentsHave.style.display =
          commentsHave.style.display === "none" ? "block" : "none";
      });
    }

    if (addCommentBtn && commentsAdd) {
      commentsAdd.parentElement.style.display = "block";
      commentsAdd.style.display = "none";
      addCommentBtn.addEventListener("click", () => {
        commentsAdd.style.display =
          commentsAdd.style.display === "none" ? "block" : "none";
      });
    }
  });

  // Кнопка "Show info" — переход на страницу мероприятия
  document.querySelectorAll(".event-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;
      if (id) {
        window.location.href = `event_info.php?id=${id}`;
      }
    });
  });
});
