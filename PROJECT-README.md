# Atlas Tours & Travel - Complete Travel Booking System - Phase 1 - Frontend Only


A comprehensive travel agency website built with Laravel 12 and Tailwind CSS, featuring a complete booking system with shopping cart functionality and date selection.

## Features

- **5 Responsive Pages**: Home, Tours, Tour Detail, Contact, Shopping Cart
- **8 Tour Packages**: 4 international + 4 domestic tours with complete itineraries
- **Shopping Cart System**: Add tours to cart with date selection and quantity management
- **Date Selection**: Choose departure dates directly on tour details
- **Order Processing**: Complete checkout flow with customer information and payment methods
- **Modular Components**: Reusable Blade partials (header, footer, tour cards, etc.)
- **Responsive Design**: Mobile-first approach, works on all devices
- **Browser Compatible**: Tested on Chrome, Firefox, Edge, Opera
- **Image Gallery**: Tour images, destination cards, and photo galleries


## Project Structure

```
├── app/Http/Controllers/
│   ├── SiteController.php                  # Main controller with tour data
│   └── ShoppingCartController.php          # Cart management & checkout
├── routes/web.php                          # Route definitions
├── resources/views/
│   ├── layouts/app.blade.php              # Main layout
│   ├── partials/                          # Reusable components
│   ├── home.blade.php                     # Homepage
│   ├── tours/
│   │   ├── index.blade.php                # All tours page
│   │   └── show.blade.php                 # Tour details with date selection
│   ├── shoppingcart/
│   │   ├── index.blade.php                # Shopping cart & checkout
│   │   └── success.blade.php              # Order confirmation
│   └── contact.blade.php                  # Contact page
└── public/images/                         # Tour & destination images
```


## Pages

- **Home** (`/`) - Featured tours, destinations, testimonials
- **Tours** (`/tours`) - All tours with type filtering
- **Tour Detail** (`/tours/{slug}`) - Full itinerary with date selection & add to cart
- **Shopping Cart** (`/shopping-cart`) - Cart management, checkout, and order processing
- **Order Success** (`/shopping-cart/success`) - Order confirmation with departure dates
- **Contact** (`/contact`) - Contact form & company info

## Key Features

### Shopping Cart System
- **Date Selection**: Choose departure dates (max 3 options per tour) directly on tour details
- **Cart Management**: Add, update, and remove tours with specific dates
- **Multiple Instances**: Same tour with different dates treated as separate cart items
- **Quantity Control**: Adjust number of travelers for each tour
- **Session Storage**: Cart data persisted across browser sessions

### Order Processing
- **Customer Information**: Complete booking form with validation
- **Payment Methods**: Credit card, bank transfer, cash on delivery options
- **Order Confirmation**: Success page with departure dates and order details
- **Special Requests**: Optional field for additional requirements

### Tour Management
- **8 Complete Tours**: 4 international + 4 domestic with full itineraries
- **Available Dates**: Each tour has 4 departure date options
- **Rich Content**: Detailed itineraries, highlights, photo galleries
- **Type Filtering**: Filter tours by domestic/international

## Tech Stack

- **Laravel 12** - PHP framework
- **Laravel Breeze** - Authentication system
- **Blade Templates** - Server-side templating
- **Tailwind CSS** - Utility-first CSS framework
- **Session Storage** - Cart and order data management

## Routes

```php
// Public Routes
GET  /                           # Home page
GET  /tours                      # All tours
GET  /tours/{slug}              # Tour details
GET  /contact                    # Contact page

// Cart Routes
POST /cart/add                   # Add tour to cart
POST /cart/update                # Update cart item quantity
POST /cart/remove                # Remove tour from cart
POST /cart/clear                 # Clear entire cart

// Shopping Cart Routes
GET  /shopping-cart             # Cart & checkout page
POST /shopping-cart/process      # Process order
GET  /shopping-cart/success     # Order confirmation
```

## Phase 2 Roadmap

- Database integration for persistent storage
- User authentication for order history
- Email notifications for bookings
- Admin panel for tour management

---

