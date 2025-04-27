function updateCounter(inputId, counterId, maxLength) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(counterId);
    
    input.addEventListener('input', function() {
        const currentLength = this.value.length;
        counter.textContent = `${currentLength}/${maxLength}`;
        
        // Visual feedback when approaching character limit
        if (currentLength > maxLength * 0.8) {
            counter.style.color = '#ff9900';
        } else {
            counter.style.color = '#777';
        }
    });
}

// Initialize character counters
updateCounter('item_name', 'itemNameCount', 100);
updateCounter('description', 'descriptionCount', 500);
updateCounter('location_lost', 'locationCount', 200);
