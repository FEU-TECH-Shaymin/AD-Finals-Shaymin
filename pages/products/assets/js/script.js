const searchInput = document.querySelector('.search');
const searchIcon = document.querySelector('.search-icon');
searchIcon.addEventListener('click', () => {
searchInput.classList.toggle('show');
if (searchInput.classList.contains('show')) {
    searchInput.focus();
}
});
