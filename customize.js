document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('customizationForm');
    const basePrice = parseFloat(document.getElementById('basePrice').textContent.replace('₹', ''));
    
    // Quantity controls
    const quantityInput = document.querySelector('.quantity-input');
    const minusBtn = document.querySelector('.minus');
    const plusBtn = document.querySelector('.plus');

    function updateTotalPrice() {
        let total = basePrice;
        
        // Add radio button selections
        const selectedRoti = document.querySelector('input[name="roti-type"]:checked');
        if (selectedRoti && selectedRoti.dataset.price) {
            total += parseFloat(selectedRoti.dataset.price);
        }

        // Add checkbox selections
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
            if (checkbox.dataset.price) {
                total += parseFloat(checkbox.dataset.price);
            }
        });

        // Multiply by quantity
        total *= parseInt(quantityInput.value);

        // Update display
        document.getElementById('addonsPrice').textContent = '₹' + 
            ((total - (basePrice * parseInt(quantityInput.value))).toFixed(2));
        document.getElementById('totalPrice').textContent = '₹' + total.toFixed(2);
    }

    // Quantity button handlers
    minusBtn.addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        if (value > 1) {
            quantityInput.value = value - 1;
            updateTotalPrice();
        }
    });

    plusBtn.addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        if (value < 10) {
            quantityInput.value = value + 1;
            updateTotalPrice();
        }
    });

    // Listen for changes in radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', updateTotalPrice);
    });

    // Listen for changes in checkboxes
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateTotalPrice);
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Gather all customization data
        const customizationData = {
            itemId: new URLSearchParams(window.location.search).get('item'),
            rotiType: document.querySelector('input[name="roti-type"]:checked').value,
            extras: Array.from(document.querySelectorAll('input[name="extras"]:checked')).map(cb => cb.value),
            spiceLevel: document.querySelector('.spice-slider').value,
            quantity: quantityInput.value,
            instructions: document.querySelector('.special-instructions').value,
            totalPrice: document.getElementById('totalPrice').textContent.replace('₹', '')
        };

        // Redirect to order form with customization details
        const params = new URLSearchParams({
            item: document.querySelector('.preview-details h2').textContent.replace('Customize ', ''),
            price: customizationData.totalPrice,
            quantity: customizationData.quantity,
            customizations: JSON.stringify(customizationData)
        });

        window.location.href = `order_form.php?${params.toString()}`;
    });

    // Initial price calculation
    updateTotalPrice();
});