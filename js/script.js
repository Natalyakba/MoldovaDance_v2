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
});

// Скрытие регистрации по умолчанию и отображение при клике на кнопку
document.querySelectorAll(".registration").forEach((card) => {
  const showBtn = card.querySelector(".button-reg");
  const topicReg = card.querySelector(".topic-reg");

  if (showBtn && topicReg) {
    showBtn.addEventListener("click", function () {
      topicReg.style.display =
        topicReg.style.display === "none" ? "block" : "none";
    });
  }
});
