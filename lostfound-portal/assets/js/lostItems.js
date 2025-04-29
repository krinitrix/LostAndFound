console.log("lostitems test")
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

