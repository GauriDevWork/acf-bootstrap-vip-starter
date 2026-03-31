# ACF Bootstrap VIP Layout System

This project is a custom WordPress theme built to create reusable page layouts without relying on heavy page builders like Elementor or WPBakery.

The goal is to have full control over markup, improve performance, and build a system that can be reused across multiple projects.

---

## Overview

The theme uses Advanced Custom Fields (ACF) Flexible Content as a layout engine and Bootstrap as the grid system.

Instead of drag-and-drop builders, pages are constructed using structured, reusable layout blocks. Each layout is designed to be simple, consistent, and performance-friendly.

---

## Why This Approach

Page builders are convenient, but they often introduce unnecessary complexity:

* Large DOM size
* Poor performance (especially LCP and CLS)
* Limited control over HTML structure
* Difficult to reuse across projects

This system is built to avoid those issues by keeping everything lightweight and developer-controlled.

---

## How It Works

Each page uses ACF Flexible Content:

```php
if (have_rows('page_builder')):
    while (have_rows('page_builder')): the_row();
        get_template_part('acf-flex/' . get_row_layout());
    endwhile;
endif;
```

Each layout lives in the `acf-flex/` folder and is fully independent.

---

## Project Structure

```
acf-bootstrap-vip-starter/
│
├── acf-flex/
│   ├── hero_section.php
│   ├── cta_section.php
│
├── inc/
│   └── helpers.php
│
├── assets/
│   ├── css/
│   │   ├── hero.css
│   │   ├── cta.css
│   │   └── bootstrap.min.css
│   │
│   ├── js/
│   │   ├── hero-swiper.js
│   │   └── swiper-bundle.min.js
│
├── acf-json/
├── functions.php
└── page.php
```

---

## Implemented Layouts

### Hero Section

* Supports single image and slider modes
* Uses Swiper for slider functionality
* Each slide can have its own content
* Only one H1 is used for accessibility
* Swiper is loaded only when needed

---

### CTA Section

* Supports background color or background image
* Includes overlay for readability when image is used
* Uses predefined color options (light, dark, primary, secondary)
* Fully reusable across pages

---

## Reusability

Common logic is handled through helper functions:

* Button rendering
* Image output (using WordPress responsive images)
* Text alignment
* Section class handling

All helpers are located in:

```
inc/helpers.php
```

This makes it easy to update behavior globally without touching every layout.

---

## Performance Considerations

This project is built with performance in mind:

* Swiper is loaded only when a slider is present
* CSS is structured per layout (ready for conditional loading)
* Images use `wp_get_attachment_image()` for responsive output
* Unnecessary WordPress assets like emojis and embeds are removed
* Scripts are loaded in the footer and deferred where possible

---

## Accessibility

Basic accessibility practices are followed:

* Proper heading hierarchy (single H1 per page)
* Meaningful link text (no generic labels like “Click here”)
* ARIA labels on buttons
* Overlay handling for readable text on images

---

## Design System

Instead of using random colors, the theme uses predefined background options:

* light
* dark
* primary
* secondary

This keeps the UI consistent and easier to maintain across projects.

---

## Local Development

The project uses Docker for local development.

Run:

```
docker compose up -d
```

Then access:

* WordPress: http://localhost:8000
* phpMyAdmin: http://localhost:8001

---

## Current Status

So far, the following are completed:

* ACF-based layout system
* Hero section (single + slider)
* CTA section
* Helper functions for reusability
* Conditional loading for slider assets

---

## Next Steps

Planned improvements:

* Content + Image layout
* Grid layout (services/features)
* Testimonials
* FAQ section
* Conditional CSS loading per layout
* Gutenberg compatibility

---

## About

This project is part of a focused effort to build a reusable, performance-oriented WordPress system that can be used across client work and personal projects.

It’s designed to be simple to extend, easy to maintain, and reliable in production.
