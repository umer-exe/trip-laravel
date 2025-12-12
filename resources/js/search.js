/**
 * Live AJAX Search for Tours
 * 
 * Provides real-time search functionality on the /tours page
 * Displays matching tours in a dropdown as user types
 * 
 * Features:
 * - Debounced search (300ms delay to reduce server requests)
 * - Searches in tour title and location fields
 * - Filters by min/max price if specified
 * - XSS protection via HTML escaping
 * - Click-outside-to-close behavior
 * - Keyboard-friendly (shows results on focus)
 * 
 * Backend endpoint: GET /tours/search/ajax
 * Returns: JSON array of tour objects
 */

document.addEventListener('DOMContentLoaded', function () {
    // Get DOM elements
    const destinationInput = document.getElementById('destination');
    const minPriceInput = document.getElementById('min_price');
    const maxPriceInput = document.getElementById('max_price');
    const searchDropdown = document.getElementById('search-dropdown');

    // Exit if elements not found (not on tours page)
    if (!destinationInput || !searchDropdown) {
        return;
    }

    // Timeout for debouncing search requests
    let searchTimeout = null;

    /**
     * Perform AJAX search and update dropdown
     * Sends GET request to backend with search parameters
     * Updates dropdown with results or "no results" message
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

        // Build search URL with query parameters
        // data-search-url attribute contains the route URL
        const searchUrl = new URL(destinationInput.dataset.searchUrl, window.location.origin);
        searchUrl.searchParams.append('q', query);

        // Add price filters if provided
        if (minPrice) {
            searchUrl.searchParams.append('min_price', minPrice);
        }

        if (maxPrice) {
            searchUrl.searchParams.append('max_price', maxPrice);
        }

        // Perform AJAX request using Fetch API
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
     * Creates HTML for each tour result with:
     * - Tour title and location
     * - Price (formatted with commas)
     * - Type badge (domestic/international)
     * - Clickable link to tour detail page
     * 
     * @param {Array} tours - Array of tour objects from API
     */
    function renderSearchResults(tours) {
        // Show "no results" message if empty
        if (tours.length === 0) {
            searchDropdown.innerHTML = `
                <div class="px-4 py-3 text-sm text-gray-500">
                    No tours found matching your search.
                </div>
            `;
            searchDropdown.classList.remove('hidden');
            return;
        }

        // Build HTML for each tour result
        let html = '';
        tours.forEach(tour => {
            // Different colors for domestic vs international
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

        // Update dropdown content and show it
        searchDropdown.innerHTML = html;
        searchDropdown.classList.remove('hidden');
    }

    /**
     * Escape HTML to prevent XSS attacks
     * Converts special characters to HTML entities
     * 
     * @param {string} text - Raw text to escape
     * @returns {string} HTML-safe text
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Format price with commas and 2 decimal places
     * Example: 1234.5 → "1,234.50"
     * 
     * @param {number|string} price - Price to format
     * @returns {string} Formatted price string
     */
    function formatPrice(price) {
        return parseFloat(price).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // ========================================================================
    // EVENT LISTENERS
    // ========================================================================

    /**
     * Debounced search on keyup (300ms delay)
     * Waits for user to stop typing before sending request
     * Reduces server load and improves UX
     */
    destinationInput.addEventListener('keyup', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 300);
    });

    /**
     * Trigger search when min price filter changes
     * Only if there's already a search query
     */
    if (minPriceInput) {
        minPriceInput.addEventListener('change', function () {
            if (destinationInput.value.trim().length > 0) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            }
        });
    }

    /**
     * Trigger search when max price filter changes
     * Only if there's already a search query
     */
    if (maxPriceInput) {
        maxPriceInput.addEventListener('change', function () {
            if (destinationInput.value.trim().length > 0) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            }
        });
    }

    /**
     * Hide dropdown when clicking outside search area
     * Improves UX by closing dropdown when user clicks elsewhere
     */
    document.addEventListener('click', function (event) {
        if (!destinationInput.contains(event.target) && !searchDropdown.contains(event.target)) {
            searchDropdown.classList.add('hidden');
        }
    });

    /**
     * Show dropdown again when focusing on input
     * Only if there are existing results to show
     * Makes it easy to review previous search results
     */
    destinationInput.addEventListener('focus', function () {
        if (destinationInput.value.trim().length > 0 && searchDropdown.innerHTML.trim() !== '') {
            searchDropdown.classList.remove('hidden');
        }
    });
});
