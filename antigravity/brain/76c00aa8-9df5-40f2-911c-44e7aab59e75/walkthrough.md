# Walkthrough: PDF Download Button

We have successfully added a "Descargar Catálogo" button to the Shop page, styled to match your theme and responsive for mobile devices.

## Changes Made

### 1. `functions.php` (Theme Functions)
We added code to:
*   Create a reusable shortcode `[koby_boton_pdf]`.
*   Automatically inject this shortcode at the top of the Shop/Catalog page.
*   Wrap the button in a container for custom positioning.

**Modified File:** `c:\xampp\htdocs\koby\wp-content\themes\rappod-child\functions.php`

### 2. `style.css` (Child Theme Styles)
We added CSS to:
*   Align the button to the **Right** on desktop.
*   Align the button to the **Center** on mobile devices.
*   Handle spacing and responsive behavior.

**Modified File:** `c:\xampp\htdocs\koby\wp-content\themes\rappod-child\style.css`

## Deployment Instructions

To apply these changes to your production site:

1.  **Copy `functions.php`**: Copy the entire content of your local file to the production server.
    *   *Critical:* Ensure you include the new URL logic at the bottom.
2.  **Copy `style.css`**: Copy the new CSS rules at the bottom of the file to your production `style.css`.
    *   *Critical:* Don't forget the media query for mobile responsiveness!

## Verification

*   **Desktop:** Button appears right-aligned above products.
*   **Mobile:** Button appears centered.
*   **Click:** Opens the PDF in a new tab.
