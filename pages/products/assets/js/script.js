// Toggle search bar
const searchInput = document.querySelector('.search');
const searchIcon = document.querySelector('.search-icon');
if (searchIcon && searchInput) {
  searchIcon.addEventListener('click', () => {
    searchInput.classList.toggle('show');
    if (searchInput.classList.contains('show')) {
      searchInput.focus();
    }
  });
}

// Cart logic
let cart = JSON.parse(localStorage.getItem('cart')) || [];
updateCartCount();

document.querySelectorAll('.add-to-cart-btn').forEach((btn) => {
  btn.addEventListener('click', () => {
    const card = btn.closest('.product-card');
    const name = card.querySelector('.product-name')?.textContent || '';
    const price = card.querySelector('.product-price')?.textContent || '';
    const bg = card.querySelector('.product-bg')?.style.backgroundImage || '';
    cart.push({ name, price, image: bg });
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
  });
});

function updateCartCount() {
  const badge = document.getElementById('cart-count');
  badge.textContent = cart.length;
  badge.style.display = cart.length > 0 ? 'inline-block' : 'none';
}
