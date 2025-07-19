document.addEventListener('DOMContentLoaded', function () {
    const productData = JSON.parse(document.getElementById('productData').value || '[]');
    const productSelect = document.getElementById('product');
    const quantityInput = document.getElementById('quantity');
    const addBtn = document.getElementById('addProductBtn');
    const orderTableBody = document.querySelector('#orderTable tbody');
    const totalInput = document.getElementById('total');
    const moneyGivenInput = document.getElementById('money_given');
    const changeInput = document.getElementById('change');
    const orderItemsInput = document.getElementById('orderItems');
    const submitBtn = document.getElementById('submitBtn');
    const orderForm = document.getElementById('orderForm');

    let orderItems = [];

    function renderTable() {
        const orderTableWrapper = document.getElementById('orderTableWrapper');
        orderTableBody.innerHTML = '';
        let grandTotal = 0;

        // Remove old hidden inputs
        document.querySelectorAll('.dynamic-order-input').forEach(el => el.remove());

        if (orderItems.length === 0) {
            orderTableWrapper.style.display = 'none';
        } else {
            orderTableWrapper.style.display = 'block';
        }

        orderItems.forEach((item, index) => {
            const rowTotal = item.price * item.quantity;
            grandTotal += rowTotal;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.product_name}</td>
                <td>
                    <input type="number" class="form-control form-control-sm quantity-input" 
                           data-index="${index}" min="1" value="${item.quantity}" />
                </td>
                <td>${item.price.toFixed(2)}</td>
                <td class="row-total">${rowTotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-sm btn-danger remove-btn" data-index="${index}">X</button>
                </td>
            `;
            orderTableBody.appendChild(row);

            // Create hidden inputs for form submission
            const hiddenProductId = document.createElement('input');
            hiddenProductId.type = 'hidden';
            hiddenProductId.name = 'product_id[]';
            hiddenProductId.value = item.product_id;
            hiddenProductId.classList.add('dynamic-order-input');
            orderForm.appendChild(hiddenProductId);

            const hiddenQty = document.createElement('input');
            hiddenQty.type = 'hidden';
            hiddenQty.name = 'quantity[]';
            hiddenQty.value = item.quantity;
            hiddenQty.classList.add('dynamic-order-input');
            orderForm.appendChild(hiddenQty);
        });

        totalInput.value = grandTotal.toFixed(2);
        orderItemsInput.value = JSON.stringify(orderItems);
        updateChange();
    }

    function updateChange() {
        const total = parseFloat(totalInput.value) || 0;
        const money = parseFloat(moneyGivenInput.value) || 0;
        const change = money - total;
        changeInput.value = change >= 0 ? change.toFixed(2) : '0.00';
        submitBtn.disabled = !(money >= total && total > 0);
    }

    addBtn.addEventListener('click', function () {
        const selectedId = parseInt(productSelect.value);
        const quantity = parseInt(quantityInput.value);

        if (!selectedId || quantity < 1) return;

        const product = productData.find(p => p.product_id === selectedId);
        const existing = orderItems.find(item => item.product_id === selectedId);

        if (existing) {
            existing.quantity += quantity;
        } else {
            orderItems.push({ 
                product_id: product.product_id, 
                product_name: product.product_name, 
                price: product.price, 
                quantity 
            });
        }

        renderTable();
    });

    orderTableBody.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-btn')) {
            const index = parseInt(e.target.dataset.index);
            orderItems.splice(index, 1);
            renderTable();
        }
    });

    moneyGivenInput.addEventListener('input', updateChange);

    orderTableBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('quantity-input')) {
            const index = parseInt(e.target.dataset.index);
            const newQty = parseInt(e.target.value);

            if (newQty > 0) {
                orderItems[index].quantity = newQty;
                renderTable();
            }
        }
    });
});
