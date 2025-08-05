odocument.addEventListener('DOMContentLoaded', function() {
    // Category filtering
    const categoryTabs = document.querySelectorAll('.category-tab');
    const menuItems = document.querySelectorAll('.menu-item');
    
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const category = tab.textContent.toLowerCase();
            
            categoryTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            menuItems.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Customize button functionality
    document.querySelectorAll('.customize-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            // Redirect to customize page or handle customization logic
            window.location.href = 'customize.php?item=' + itemId;
        });
    });
}); 