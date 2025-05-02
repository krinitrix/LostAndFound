
function toggleSection(id) {
    const section = document.getElementById(id);
    const toggle = document.getElementById(id + 'Toggle');

    if (section.style.display === 'none') {
        section.style.display = 'block';
        toggle.textContent = '[−]';
    } else {
        section.style.display = 'none';
        toggle.textContent = '[+]';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Add transition effects to toggle icons
    const toggleIcons = document.querySelectorAll('.toggle-icon');
    toggleIcons.forEach(icon => {
        icon.style.transition = 'transform 0.4s ease-in-out';
    });
});