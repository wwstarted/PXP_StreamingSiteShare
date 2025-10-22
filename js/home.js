// Xử lý section banner
const prevBtn = document.querySelector(".banner-section-prev");
const nextBtn = document.querySelector(".banner-section-back");
const slider = document.querySelector(".banner-section-slide");

prevBtn.addEventListener("click", () => {
  slider.scrollBy({
    left: -320,
    behavior: "smooth",
  });
});

nextBtn.addEventListener("click", () => {
  slider.scrollBy({
    left: 320,
    behavior: "smooth",
  });
});

// Xử lý section read more
function toggleContent(button) {
  // Tìm section chứa button được click
  const section = button.closest(".info-section");
  const content = section.querySelector(".info-content");
  const btnText = button.querySelector(".text");
  const fadeOverlay = section.querySelector(".fade-overlay");

  // Toggle class expanded
  content.classList.toggle("expanded");
  button.classList.toggle("expanded");

  // Thay đổi text và ẩn/hiện fade overlay
  if (content.classList.contains("expanded")) {
    btnText.textContent = "Read Less";
    fadeOverlay.classList.add("hidden");
  } else {
    btnText.textContent = "Read More";
    fadeOverlay.classList.remove("hidden");
  }
}
