# Atlas Tours & Travel - Phase 1

A comprehensive travel agency website built with Laravel 12 and Tailwind CSS, featuring a complete booking system.

## Features

- **5 Responsive Pages**: Home, Tours, Tour Detail, Contact, Shopping Cart
- **Shopping Cart System**: Add tours to cart with date selection and quantity management
- **Order Processing**: Complete checkout flow with customer information and payment methods
- **Modular Components**: Reusable Blade partials (header, footer, tour cards, etc.)
- **Responsive Design**: Mobile-first approach, works on all devices
- **Browser Compatible**: Tested on Chrome, Firefox, Edge, Opera

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


## Tech Stack

- **Laravel 12** - PHP framework
- **Laravel Breeze** - Authentication system
- **Blade Templates** - Server-side templating
- **Tailwind CSS** - Utility-first CSS framework
- **Session Storage** - Cart and order data management

---