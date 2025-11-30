// Admin Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const adminMenuToggle = document.getElementById('adminMenuToggle');
    const adminMenu = document.getElementById('adminMenu');
    
    if (adminMenuToggle && adminMenu) {
        adminMenuToggle.addEventListener('click', function() {
            adminMenuToggle.classList.toggle('active');
            adminMenu.classList.toggle('active');
        });
        
        // Close menu when clicking on a link
        const menuLinks = adminMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                adminMenuToggle.classList.remove('active');
                adminMenu.classList.remove('active');
            });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = adminMenu.contains(event.target) || adminMenuToggle.contains(event.target);
            
            if (!isClickInside && adminMenu.classList.contains('active')) {
                adminMenuToggle.classList.remove('active');
                adminMenu.classList.remove('active');
            }
        });
    }
});
