# Atlas Tours & Travel - Laravel Application

A comprehensive tours and travel booking system built with **Laravel 12**. This project showcases a modern, responsive **User Interface** and a powerful **Admin Panel** features complete **CRUD operations** for managing tours, bookings, and content.
Key highlights include a seamless booking experience, AJAX-powered live search, secure authentication, and dynamic media management.

## 🌟 Features

### Public Features
- **Browse Tours**: View all available domestic and international tour packages
- **AJAX Live Search**: Real-time search with dropdown results as you type
- **Advanced Filtering**: Filter tours by destination, price range, and tour type
- **Tour Details**: Comprehensive tour information with itinerary, highlights, and gallery
- **Shopping Cart**: Add tours to cart and complete bookings
- **Payment Methods**: Secure checkout with Cash on Delivery and Card on Delivery options
- **Contact Form**: Submit inquiries with automatic admin notifications

### Admin Panel Features
- **Tours Management**: Full CRUD operations for tour packages
- **Featured Image Upload**: Upload featured images with live preview (JPEG, PNG, JPG, WEBP, max 1MB)
- **Gallery Images Upload**: Upload up to 4 gallery images per tour (Select all at once, JPEG, PNG, JPG, WEBP, max 1MB each)
- **Reviews Management**: Manage customer testimonials
- **Contact Messages**: View and respond to customer inquiries
- **Authentication**: Secure admin access with Laravel Breeze

### API Features
- **RESTful API**: JSON endpoints for tours data
- **GET /api/tours**: List all active tours
- **GET /api/tours/{id}**: Get single tour details

## 📋 Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL or PostgreSQL database
- Laravel 12.x

## 🚀 Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/umer-exe/trip-laravel
cd trip-laravel
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

The application is pre-configured to use **SQLite**. No complex database setup is required.

1. The `.env` file should already have `DB_CONNECTION=sqlite`.


> **Note**: If you encounter a "driver not found" error, enable the extension in your `php.ini` file by removing the semicolon `;` from the line `;extension=pdo_sqlite`. (usually enabled by default).
> To find your `php.ini` file, run: `php --ini`

### 5. Run Migrations & Seeders

### 5. Run Migrations & Seeders

This command will create the database tables and populate them with sample data.

1. **Run Migrations**: This will set up the database structure.
   - If the database file doesn't exist, Laravel will ask if you want to create it. Type `yes`.

```bash
php artisan migrate
```

2. **Seed Data**: This creates the Admin User and sample content.

```bash
php artisan db:seed
```

> [!IMPORTANT]
> If you don't run `--seed`, you will NOT have an admin account to log in with.

**What the seeder creates:**
- ✅ **Admin User**: `admin@atlastours.pk` / `password123`
- ✅ **8 Sample Tours**: Mix of domestic and international tours
- ✅ **6 Customer Reviews**: Sample testimonials
- ✅ **4 Contact Messages**: Sample inquiries

### 6. Create Storage Symlink

```bash
# Create symbolic link for public storage
php artisan storage:link
```

This is **required** for image uploads to work properly. It creates a symlink from `public/storage` to `storage/app/public`.

### 7. Build Frontend Assets

```bash
# Development build with hot reload (optional)
npm run dev 

# OR Production build (for deployment)
npm run build
```

### 8. Start Development Server

```bash
# Start Laravel development server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 🔐 Admin Access

### Default Admin Credentials

After running `php artisan db:seed`, you can login with:

- **Email**: `admin@atlastours.pk`
- **Password**: `password123`

### Login to Admin Panel

1. Visit `http://localhost:8000/login`
2. Use the credentials above
3. Access admin panel at `http://localhost:8000/admin/tours`

## 🔍 AJAX Live Search Feature

### How It Works

The live search feature provides real-time tour results as users type in the destination field.

**Location**: `/tours` page (filter bar)

**Functionality**:
1. Type in the "Destination" search box
2. Results appear in a dropdown after 300ms (debounced)
3. Search filters by tour title AND location
4. Optionally filters by min/max price if set
5. Click any result to navigate to tour detail page
6. Dropdown hides when input is empty or clicking outside

**Technical Implementation**:
- **Backend**: `SiteController@searchTours` method
- **Route**: `GET /tours/search/ajax`
- **Frontend**: `resources/js/search.js`
- **Returns**: JSON array of matching tours (max 10 results)

### Testing the Search

1. Navigate to `/tours`
2. Type "Tokyo" or "Pakistan" in the destination field
3. Watch the dropdown appear with matching results
4. Set a price range and search again to see filtered results

### Feature Overview

Admin users can upload featured images and gallery images for tours with instant preview before submission.

**Supported Formats**: JPEG, PNG, JPG, WEBP  
**Featured Image Max Size**: 1MB  
**Gallery Images**: Up to 4 images, 1MB each  
**Storage**: `storage/app/public/tours/`

#### Creating a New Tour

1. Login to admin panel
2. Navigate to **Admin > Tours > Create Tour**
3. Fill in tour details
4. Scroll to "Featured Image Upload" section
5. Click "Choose File" and select an image (max 1MB)
6. **Preview appears instantly** below the file input
7. Optionally, upload **Gallery Images** (Select up to 4 images AT ONCE, max 1MB each)
8. Complete other fields and click "Create Tour"

#### Editing Existing Tour

1. Navigate to **Admin > Tours**
2. Click "Edit" on any tour
3. Existing featured image and gallery images are displayed in preview area
4. To replace featured image: select new file (old image is automatically deleted)
5. To replace gallery images: select new files (Select all 4 images at once - replaces all previous images)
6. Click "Update Tour"

### Image Display

Uploaded images are displayed in:
- **Admin Tours Index**: Featured image thumbnail in table
- **Public Tours Listing**: Featured image on tour cards on `/tours` page
- **Tour Detail Page**: Featured image as hero image on `/tours/{slug}` page
- **Tour Detail Page Gallery**: Gallery images displayed in a grid on `/tours/{slug}` page

### Technical Details

- Images stored in `storage/app/public/tours/`
- Database fields: 
  - `featured_image` (stores relative path to featured image)
  - `gallery_images` (JSON array storing paths to gallery images)
- Fallback: Uses `thumbnail_image` or `banner_image` if `featured_image` not set
- **FileReader API** used for client-side preview
- Validation:
  - Featured Image: `image|mimes:jpeg,png,jpg,webp|max:1024` (1MB)
  - Gallery Images: `array|max:4` with each image `image|mimes:jpeg,png,jpg,webp|max:1024` (1MB)

## 🔌 API Endpoints

### Base URL

```
http://localhost:8000/api
```

### Available Endpoints

#### 1. List All Tours

**Endpoint**: `GET /api/tours`

**Description**: Returns all active tours with key information

**Response Example**:

```json
{
  "success": true,
  "count": 8,
  "data": [
    {
      "id": 1,
      "title": "Discover Japan",
      "slug": "discover-japan",
      "location": "Tokyo, Kyoto, Osaka",
      "duration": "10 Days / 9 Nights",
      "price": "2499.00",
      "type": "international",
      "overview": "Experience the perfect blend...",
      "highlights": ["Visit iconic Tokyo Tower"],
      "is_featured": true,
      "featured_image": null,
      "thumbnail_image": "images/tours/japan.jpg"
    }
  ]
}
```

#### 2. Get Single Tour

**Endpoint**: `GET /api/tours/{id}`

**Description**: Returns complete details for a specific tour

**Parameters**:
- `id` (integer, required): Tour ID

**Response Example**:

```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Discover Japan",
    "slug": "discover-japan",
    "overview": "Experience the perfect blend...",
    "location": "Tokyo, Kyoto, Osaka",
    "duration": "10 Days / 9 Nights",
    "price": "2499.00",
    "type": "international",
    "highlights": ["Visit iconic Tokyo Tower"],
    "itinerary": [
      {
        "day": 1,
        "title": "Arrival in Tokyo",
        "description": "Arrive at Narita Airport..."
      }
    ],
    "available_dates": {
      "2024-03-15": "March 15, 2024"
    },
    "is_featured": true,
    "featured_image": null,
    "thumbnail_image": "images/tours/japan.jpg",
    "banner_image": "images/gallery/japan-1.jpg",
    "gallery_images": ["images/gallery/japan-1.jpg"]
  }
}
```

**Error Response** (404):

```json
{
  "success": false,
  "message": "Tour not found"
}
```

### Testing API Endpoints

#### Using cURL

```bash
# List all tours
curl http://localhost:8000/api/tours

# Get single tour
curl http://localhost:8000/api/tours/1
```

#### Using Browser

Simply visit:
- `http://localhost:8000/api/tours`
- `http://localhost:8000/api/tours/1`

## 📁 Project Structure

```
myapp/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── TourController.php       # Admin CRUD for tours
│   │   │   ├── ReviewController.php     # Reviews management
│   │   │   └── ContactMessageController.php
│   │   ├── SiteController.php           # Public pages + AJAX search
│   │   ├── ApiController.php            # API endpoints
│   │   └── ShoppingCartController.php
│   └── Models/
│       ├── Tour.php
│       ├── Review.php
│       └── ContactMessage.php
├── database/
│   ├── migrations/
│   │   ├── 2025_11_21_133110_create_tours_table.php
│   │   └── 2025_12_11_160104_add_featured_image_to_tours_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php           # Main seeder orchestrator
│       ├── UserSeeder.php               # Creates admin user
│       ├── TourSeeder.php               # Creates 8 sample tours
│       ├── ReviewSeeder.php             # Creates 6 reviews
│       └── ContactMessageSeeder.php     # Creates 4 messages
├── resources/
│   ├── js/
│   │   ├── app.js
│   │   ├── search.js                    # AJAX search functionality
│   │   ├── cart.js                      # Cart interaction & loading states
│   └── views/
│       ├── admin/tours/                 # Admin tour views
│       ├── tours/                       # Public tour views
│       └── partials/
│           └── filter-bar.blade.php     # Search bar with dropdown
├── routes/
│   ├── web.php                          # Web routes
│   └── api.php                          # API routes
└── storage/app/public/tours/            # Uploaded images
```

## 🛠️ Key Technologies

- **Backend**: Laravel 12, PHP 8.1+
- **Frontend**: Blade Templates, Alpine.js, Tailwind CSS
- **Build Tool**: Vite
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze
- **Image Storage**: Laravel Storage (public disk)

## 📝 Database Migrations

### Tours Table Fields

- `id`: Primary key
- `title`: Tour name
- `slug`: URL-friendly identifier
- `overview`: Tour description
- `location`: Destination
- `duration`: Trip length
- `price`: Tour cost (decimal)
- `type`: domestic | international
- `highlights`: JSON array
- `itinerary`: JSON array
- `available_dates`: JSON object
- `status`: active | inactive
- `is_featured`: Boolean
- `thumbnail_image`: Text path (legacy)
- `banner_image`: Text path (legacy)
- `featured_image`: Uploaded file path (max 1MB)
- `gallery_images`: JSON array of uploaded file paths (max 4 images, 1MB each)
- `timestamps`: Created/updated dates

### Running Migrations

```bash
# Run all pending migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Refresh all migrations (WARNING: deletes data)
php artisan migrate:fresh

# Refresh and seed
php artisan migrate:fresh --seed
```

## 🧪 Testing

### Manual Testing Checklist

#### AJAX Search
- [ ] Navigate to `/tours`
- [ ] Type in destination field
- [ ] Verify dropdown appears with results
- [ ] Test with price filters
- [ ] Click result to navigate to detail page

#### Image Upload
- [ ] Login to admin
- [ ] Create new tour with featured image
- [ ] Upload gallery images (up to 4)
- [ ] Verify preview appears before submit
- [ ] Check images display on public pages
- [ ] Edit tour and replace images
- [ ] Verify old images are deleted

#### API Endpoints
- [ ] Visit `/api/tours` in browser
- [ ] Verify JSON response with 8 tours
- [ ] Visit `/api/tours/1`
- [ ] Test with invalid ID (should return 404)

#### Admin Panel
- [ ] Login with seeded credentials
- [ ] Create, edit, update, delete tours
- [ ] Manage reviews
- [ ] View contact messages
- [ ] Test all CRUD operations

## 🐛 Troubleshooting

### Images Not Displaying

**Problem**: Uploaded images return 404

**Solution**:
```bash
php artisan storage:link
```

### AJAX Search Not Working

**Problem**: Dropdown doesn't appear

**Solutions**:
1. Rebuild assets: `npm run build`
2. Clear browser cache
3. Check browser console for JavaScript errors

### Migration Errors

**Problem**: Migration fails

**Solution**:
```bash
# Check database connection
php artisan migrate:status

# Rollback and retry
php artisan migrate:rollback
php artisan migrate
```

### No Sample Data Showing

**Problem**: Tours/reviews not displaying after setup

**Solution**:
```bash
# Run the database seeder
php artisan db:seed

# Or refresh everything
php artisan migrate:fresh --seed
```
