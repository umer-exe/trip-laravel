/**
 * Shopping Cart Interactivity
 * 
 * Handles client-side behavior for the shopping cart page.
 * Primarily manages form submission states to prevent double-submission
 * and provide visual feedback (disabling buttons, showing loading state).
 */

// Cart functionality with loading states
document.addEventListener('DOMContentLoaded', function () {
    // Handle quantity update forms
    const quantityForms = document.querySelectorAll('form[action*="cart/update"]');

    quantityForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const button = form.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');

                // Re-enable after a short delay
                setTimeout(() => {
                    button.disabled = false;
                    button.classList.remove('opacity-50', 'cursor-not-allowed');
                }, 1000);
            }
        });
    });

    // Handle remove forms
    const removeForms = document.querySelectorAll('form[action*="cart/remove"]');

    removeForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const button = form.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
    });

    // Handle clear cart form
    const clearForm = document.querySelector('form[action*="cart/clear"]');
    if (clearForm) {
        clearForm.addEventListener('submit', function (e) {
            const button = clearForm.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
    }
});




