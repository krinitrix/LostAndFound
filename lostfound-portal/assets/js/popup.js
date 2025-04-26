document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("popup");
    const mainContent = document.getElementById("main-content");

    function openPopup() {
        popup.style.display = "flex";
        mainContent.classList.add("blur-background");
    }

    function closePopup() {
        popup.style.display = "none";
        mainContent.classList.remove("blur-background");
    }
});
