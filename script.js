function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
}

const navbarToggle = document.getElementById('navbarToggle');
const navLinks = document.querySelector('.nav-links');

navbarToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});