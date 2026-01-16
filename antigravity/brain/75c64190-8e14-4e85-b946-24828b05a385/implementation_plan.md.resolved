# Fix Mobile Carousel Responsiveness

The goal is to ensure the carousel displays a single slide effectively occupying 100% width on mobile devices (screen width <= 767px), fixing the issue where multiple or partial slides are shown.

## User Review Required
> [!IMPORTANT]
> To apply this fix to the specific carousel, you will need to add the CSS class `mobile-carousel-fix` to the carousel widget's settings in Elementor (Advanced > Layout > CSS Classes).

## Proposed Changes

### Theme CSS
#### [MODIFY] [style.css](file:///c:/xampp/htdocs/beatwines/wp-content/themes/hello-elementor-child/style.css)
- Update the media query for `max-width: 767px`.
### Theme CSS
#### [MODIFY] [style.css](file:///c:/xampp/htdocs/beatwines/wp-content/themes/hello-elementor-child/style.css)
- Target the `.swiper` container within `.mobile-carousel-fix`.
- Override the `width: calc(100% - 60px)` limitation caused by "Arrows Outside".
- Code:
  ```css
  @media (max-width: 767px) {
      .mobile-carousel-fix.elementor-arrows-position-outside .swiper {
          width: 100% !important;
      }
      /* Optional: Ensure arrows act correctly with the new width if needed, essentially bringing them 'inside' visually or just relying on the width fix */
  }
  ```

## Verification Plan

### Manual Verification
1.  Agent submits the CSS changes.
2.  **User Action**: User confirms the class `mobile-carousel-fix` is applied.
3.  User saves and views on mobile.
4.  Confirm the carousel now takes the full width and slides appear one by one.
