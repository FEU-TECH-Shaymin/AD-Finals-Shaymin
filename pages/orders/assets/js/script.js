document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('orderForm');
    const productSelect = document.getElementById('product');
    const quantityInput = document.getElementById('quantity');
    const orderItemsInput = document.getElementById('orderItems');
    const moneyGivenInput = document.getElementById('money_given');
    const totalField = document.getElementById('total');
    const changeField = document.getElementById('change');
    const submitBtn = document.getElementById('submitBtn');

    const productsData = JSON.parse(form.getAttribute('data-products'));
    let selectedItem = null;

    // Reset dropdown texts to original
    function resetDropdownTexts() {
        Array.from(productSelect.options).forEach(option => {
            const original = productsData.find(p => p.product_id === option.value);
            if (original) {
                option.textContent = `${original.product_name} (${parseFloat(original.price).toFixed(2)} ZCRY)`;
            }
        });
    }

    // Update selected option with quantity and total
    function updateSelectedOption(productId, quantity) {
        const product = productsData.find(p => p.product_id === productId);
        if (!product) return;

        const total = product.price * quantity;
        const option = productSelect.querySelector(`option[value="${productId}"]`);
        if (option) {
            option.textContent = `${product.product_name} x${quantity} (${total.toFixed(2)} ZCRY)`;
        }
    }

    // Update total and change
    function updateTotalAndChange() {
        if (!selectedItem) {
            totalField.value = '0.00';
            changeField.value = '0.00';
            submitBtn.disabled = true;
            return;
        }

        const product = productsData.find(p => p.product_id === selectedItem.product_id);
        if (!product) return;

        const total = product.price * selectedItem.quantity;
        totalField.value = total.toFixed(2);

        const given = parseFloat(moneyGivenInput.value) || 0;
        const change = given - total;
        changeField.value = change >= 0 ? change.toFixed(2) : '0.00';

        submitBtn.disabled = !(given >= total && selectedItem.quantity > 0);
    }

    productSelect.addEventListener('change', () => {
        quantityInput.disabled = false;
        quantityInput.value = 1; // reset to default
        resetDropdownTexts();
    });

    quantityInput.addEventListener('input', () => {
        const productId = productSelect.value;
        const quantity = parseInt(quantityInput.value, 10);

        if (!productId || isNaN(quantity) || quantity <= 0) {
            selectedItem = null;
            orderItemsInput.value = '';
            updateTotalAndChange();
            return;
        }

        selectedItem = { product_id: productId, quantity };
        orderItemsInput.value = JSON.stringify([selectedItem]);

        resetDropdownTexts();
        updateSelectedOption(productId, quantity);
        updateTotalAndChange();
    });

    moneyGivenInput.addEventListener('input', updateTotalAndChange);
});
