document.addEventListener('DOMContentLoaded', function () {
    const productSelect = document.getElementById('product');
    const productData = JSON.parse(document.getElementById('productData').value || '[]');
    const priceInput = document.getElementById('price');
    const quantityInput = document.getElementById('quantity');
    const totalInput = document.getElementById('total');
    const moneyGivenInput = document.getElementById('money_given');
    const changeInput = document.getElementById('change');
    const submitBtn = document.getElementById('submitBtn');

    function updateTotal() {
        const price = parseFloat(priceInput.value) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        const total = price * quantity;
        totalInput.value = total.toFixed(2);
        updateChange();
    }

    function updateChange() {
        const total = parseFloat(totalInput.value) || 0;
        const money = parseFloat(moneyGivenInput.value) || 0;
        const change = money - total;
        changeInput.value = change >= 0 ? change.toFixed(2) : '0.00';
        // Enable submit only if money >= total and total > 0
        submitBtn.disabled = !(money >= total && total > 0);
    }

    productSelect.addEventListener('change', function () {
        const selectedProductId = this.value;
        const selectedProduct = productData.find(p => p.product_id === selectedProductId);

        if (selectedProduct) {
            priceInput.value = parseFloat(selectedProduct.price).toFixed(2);
            updateTotal();
        }
    });

    quantityInput.addEventListener('input', updateTotal);
    moneyGivenInput.addEventListener('input', updateChange);
});