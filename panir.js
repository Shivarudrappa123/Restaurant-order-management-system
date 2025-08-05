document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paneerCustomizationForm');
    const basePrice = 249;

    // Calculate total price
    function updatePrice() {
        let total = basePrice;
        let addonsTotal = 0;

        // Paneer options
        document.querySelectorAll('input[name="paneerOptions"]:checked').forEach(option => {
            addonsTotal += parseInt(option.dataset.price);
        });

        // Additional extras
        document.querySelectorAll('input[name="extras"]:checked').forEach(extra => {
            addonsTotal += parseInt(extra.dataset.price);
        });


        // Bread selection
        document.querySelectorAll('input[name="bread"]:checked').forEach(bread => {
            addonsTotal += parseInt(bread.dataset.price);
        });

        // Multiply by quantity
        const quantity = parseInt(document.querySelector('.quantity-input').value);
        total = (total + addonsTotal) * quantity;

        // Update price displays
        document.getElementById('addonsPrice').textContent = `₹${addonsTotal * quantity}`;
        document.getElementById('totalPrice').textContent = `₹${total}`;
    }

    // Quantity controls
    document.querySelector('.minus').addEventListener('click', function() {
        const input = document.querySelector('.quantity-input');
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
            updatePrice();
        }
    });

    document.querySelector('.plus').addEventListener('click', function() {
        const input = document.querySelector('.quantity-input');
        if (input.value < 10) {
            input.value = parseInt(input.value) + 1;
            updatePrice();
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const customization = {
            item: 'Palak Paneer',
            consistency: document.querySelector('input[name="consistency"]:checked').value,
            paneerOptions: Array.from(document.querySelectorAll('input[name="paneerOptions"]:checked'))
                .map(option => option.value),
            spiceLevel: document.querySelector('.spice-slider').value,
            extras: Array.from(document.querySelectorAll('input[name="extras"]:checked'))
                .map(extra => extra.value),
            breadSelection: Array.from(document.querySelectorAll('input[name="bread"]:checked'))
                .map(bread => bread.value),
            quantity: parseInt(document.querySelector('.quantity-input').value),
            specialInstructions: document.querySelector('.special-instructions').value,
            totalPrice: parseFloat(document.getElementById('totalPrice').textContent.replace('₹', ''))
        };

        // Add to cart (using localStorage)
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart.push(customization);
        localStorage.setItem('cart', JSON.stringify(cart));

        // Show confirmation and redirect
        alert('Palak Paneer added to cart!');
        window.location.href = 'menu.html';
    });

    // Add event listeners for price updates
    document.querySelectorAll('input[type="radio"], input[type="checkbox"], input[type="range"], .quantity-input')
        .forEach(input => input.addEventListener('change', updatePrice));
});