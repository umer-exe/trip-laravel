/**
 * Live AJAX Search for Tours
 * Provides real-time search results as user types in the destination field
 */

document.addEventListener('DOMContentLoaded', function() {
    const destinationInput = document.getElementById('destination');
    const minPriceInput = document.getElementById('min_price');
    const maxPriceInput = document.getElementById('max_price');
    const searchDropdown = document.getElementById('search-dropdown');
    
    if (!destinationInput || !searchDropdown) {
        return; // Exit if elements not found on this page
    }

    let searchTimeout = null;

    /**
     * Perform AJAX search and update dropdown
     */
    function performSearch() {
        const query = destinationInput.value.trim();
        const minPrice = minPriceInput ? minPriceInput.value : '';
        const maxPrice = maxPriceInput ? maxPriceInput.value : '';

        // Hide dropdown if query is empty
        if (query.length === 0) {
            searchDropdown.classList.add('hidden');
            return;
        }

        // Build search URL with parameters
        const searchUrl = new URL(destinationInput.dataset.searchUrl, window.location.origin);
        searchUrl.searchParams.append('q', query);
        
        if (minPrice) {
            searchUrl.searchParams.append('min_price', minPrice);
        }
        
        if (maxPrice) {
            searchUrl.searchParams.append('max_price', maxPrice);
        }

        // Perform AJAX request
        fetch(searchUrl)
            .then(response => response.json())
            .then(tours => {
                renderSearchResults(tours);
            })
            .catch(error => {
                console.error('Search error:', error);
                searchDropdown.classList.add('hidden');
            });
    }

    /**
     * Render search results in dropdown
     */
    function renderSearchResults(tours) {
        if (tours.length === 0) {
            searchDropdown.innerHTML = `
                <div class="px-4 py-3 text-sm text-gray-500">
                    No tours found matching your search.
                </div>
            `;
            searchDropdown.classList.remove('hidden');
            return;
        }

        // Build HTML for results
        let html = '';
        tours.forEach(tour => {
            const typeColor = tour.type === 'international' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800';
            html += `
                <a href="/tours/${tour.slug}" 
                   class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100 last:border-b-0">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">${escapeHtml(tour.title)}</div>
                            <div class="text-sm text-gray-600 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                ${escapeHtml(tour.location)}
                            </div>
                        </div>
                        <div class="ml-4 text-right">
                            <div class="text-lg font-bold text-indigo-600">$${formatPrice(tour.price)}</div>
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold ${typeColor}">
                                ${tour.type}
                            </span>
                        </div>
                    </div>
                </a>
            `;
        });

        searchDropdown.innerHTML = html;
        searchDropdown.classList.remove('hidden');
    }

    /**
     * Escape HTML to prevent XSS
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Format price with commas
     */
    function formatPrice(price) {
        return parseFloat(price).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    /**
     * Debounced search on keyup (300ms delay)
     */
    destinationInput.addEventListener('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 300);
    });

    /**
     * Also trigger search when price filters change
     */
    if (minPriceInput) {
        minPriceInput.addEventListener('change', function() {
            if (destinationInput.value.trim().length > 0) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            }
        });
    }

    if (maxPriceInput) {
        maxPriceInput.addEventListener('change', function() {
            if (destinationInput.value.trim().length > 0) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            }
        });
    }

    /**
     * Hide dropdown when clicking outside
     */
    document.addEventListener('click', function(event) {
        if (!destinationInput.contains(event.target) && !searchDropdown.contains(event.target)) {
            searchDropdown.classList.add('hidden');
        }
    });

    /**
     * Show dropdown again when focusing on input (if there are results)
     */
    destinationInput.addEventListener('focus', function() {
        if (destinationInput.value.trim().length > 0 && searchDropdown.innerHTML.trim() !== '') {
            searchDropdown.classList.remove('hidden');
        }
    });
});
