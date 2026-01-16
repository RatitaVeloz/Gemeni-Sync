
# Implementation Plan - Full Screen Mobile Menu

## Goal Description
Transform the standard Elementor mobile dropdown menu into a full-screen ("overlay") experience. This involves handling the background color, sizing, spacing, and font sizes specifically for the mobile breakpoint to match the user's design reference (black background, centered large text).

## User Review Required
> [!NOTE]
> This solution relies on overriding Elementor's default classes. It assumes the standard Elementor mobile breakpoint is being used.

## Proposed Changes
### Hello Elementor Child Theme
#### [MODIFY] [style.css](file:///c:/xampp/htdocs/beatwines/wp-content/themes/hello-elementor-child/style.css)
- Add CSS to target `.elementor-nav-menu--dropdown`.
- Set position to `fixed`, covering the entire viewport (`100vh` height, `100vw` width).
- Set background color to black (`#000000`).
- Use Flexbox to center list items vertically and horizontally.
- Increase font sizes for menu links.
- Adjust padding for the language switcher within this full-screen view.

## Verification Plan
### Manual Verification
- Resize browser to mobile width.
- Open the menu and verify it covers the full screen with a black background.
- Check that menu items are centered and legible.
- Confirm the language switcher is present and styled correctly.
