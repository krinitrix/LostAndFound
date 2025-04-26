
    const popup = document.getElementById("popup");
    const mainContent = document.getElementById("main-content");

    function openPopup(button) {
        const itemId = button.getAttribute('data-item-id');
        document.getElementById("popup-item-id").value = itemId;
        popup.style.display = "flex";
        mainContent.classList.add("blur-background");
    }

    function closePopup() {
        popup.style.display = "none";
        mainContent.classList.remove("blur-background");
    }

