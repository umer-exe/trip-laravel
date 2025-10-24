# Atlas Tours & Travel - Phase 1

A responsive travel agency website built with Laravel 12 and Tailwind CSS, showcasing international and domestic tour packages.

## Features

- **4 Responsive Pages**: Home, Tours, Tour Detail, Contact
- **8 Tour Packages**: 4 international + 4 domestic tours with complete itineraries
- **Modular Components**: Reusable Blade partials (header, footer, tour cards, etc.)
- **Responsive Design**: Mobile-first approach, works on all devices
- **Browser Compatible**: Tested on Chrome, Firefox, Edge
- **Image Gallery**: Tour images, destination cards, and photo galleries

## Project Structure

```
├── app/Http/Controllers/SiteController.php  # Main controller with tour data
├── routes/web.php                           # Route definitions
├── resources/views/
│   ├── layouts/app.blade.php               # Main layout
│   ├── partials/                           # Reusable components
│   ├── home.blade.php                      # Homepage
│   ├── tours/index.blade.php               # All tours page
│   ├── tours/show.blade.php                # Tour details
│   └── contact.blade.php                   # Contact page
└── public/images/                          # Tour & destination images
```


## Pages

- **Home** (`/`) - Featured tours, destinations, testimonials
- **Tours** (`/tours`) - All tours with type filtering
- **Tour Detail** (`/tours/{slug}`) - Full itinerary & enquiry form
- **Contact** (`/contact`) - Contact form & company info

## Tech Stack

- Laravel 12
- Breeze (Authentication)
- Blade Templates

## Phase 2 Roadmap

- Database integration
- Functional contact forms
- Tour booking system
- Admin panel

---

