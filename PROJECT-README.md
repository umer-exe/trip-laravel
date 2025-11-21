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


---


# Atlas Tours & Travel – Complete Booking System  
**Phase 2 – Dynamic + Admin Panel + Auth Enabled**

A **fully dynamic travel booking platform** built with **Laravel 12**, **Tailwind CSS**, and **SQLite/MySQL** – featuring:

✔ Database-driven tours  
✔ Admin dashboard with CRUD  
✔ Secure authentication  
✔ Shopping cart + checkout flow  
✔ Slug auto-generation  
✔ Separate admin & public UI layouts  

---

## 🚀 What’s New in Phase 2?

### ✔ Fully Dynamic Tours (From Database)
- All tour data now loads from the **database**
- Admin can manage tours from dashboard
- No more hardcoded tours in controllers

### ✔ Admin Panel – Full CRUD
| Feature | Status |
|--------|--------|
| Create Tour | ✅ |
| Edit Tour | ✅ |
| Delete Tour | ✅ |
| Auto Slug | ✅ |
| Featured Tours Toggle | ✅ |
| Dynamic Images | 🔜 (Phase 3) |

### ✔ Secure Authentication (Laravel Breeze)
- `/login` → Admin login page  
- Public users never see admin buttons  
- Admin toolbar added on admin pages  
- Logged-in admins see **“Return to Admin Panel →”** on frontend  

---

## 🧠 Admin Navigation Flow

| Scenario | Expected Behavior |
|---------|-------------------|
| Visiting `/admin/tours` while logged out | Redirects to `/login` |
| Successful login | Redirects to `/admin/tours` |
| Visiting `/login` while already logged in | Redirects to `/admin/tours` |
| Public pages when logged in | Sees button → **Return to Admin Panel** |
| Logout | Redirects user to homepage `/` |

---

## 🗂 Updated Project Structure

├── app/Http/Controllers/
│ ├── SiteController.php # Frontend views
│ ├── ShoppingCartController.php # Cart + checkout
│ └── Admin/TourController.php # CRUD logic (admin)
│
├── database/migrations/ # Tour table schema
├── database/seeders/TourSeeder.php # Demo tours (8 entries)
│
├── resources/views/
│ ├── layouts/
│ │ ├── app.blade.php # Public layout
│ │ └── admin.blade.php # NEW Admin layout
│ ├── partials/ # Navbar, footer, tour-card
│ ├── home.blade.php # Homepage with featured tours
│ ├── admin/tours/ # CRUD views
│ ├── tours/ # Frontend tour pages
│ ├── shoppingcart/ # Cart + checkout
│ └── contact.blade.php
│
├── routes/web.php # Public + admin routes
├── public/images/tours/ # Thumbnails
├── public/images/gallery/ # Gallery images

pgsql
Copy code

---

## 🧾 Example Tour Data (Stored in DB)

| Field | Example |
|------|---------|
| title | “Swiss Alps Adventure” |
| slug | `swiss-alps-adventure` |
| type | `international` |
| price | 1700 |
| thumbnail_image | `images/tours/swiss.jpg` |
| highlights | JSON array |
| itinerary | JSON array |
| gallery_images | JSON array (Phase 3) |

---

## 📦 Routes (Latest)

```php
// Public Routes
GET  /                         # Home
GET  /tours                    # All tours
GET  /tours/{slug}             # Tour details
GET  /contact                  # Contact page

// Cart Routes
POST /cart/add
POST /cart/update
POST /cart/remove
POST /cart/clear
GET  /shopping-cart
POST /shopping-cart/process
GET  /shopping-cart/success

// Admin Routes (Protected by Middleware)
GET    /admin/tours
GET    /admin/tours/create
POST   /admin/tours
GET    /admin/tours/{id}/edit
PUT    /admin/tours/{id}
DELETE /admin/tours/{id}

// AUTH (Laravel Breeze)
GET  /login
POST /logout