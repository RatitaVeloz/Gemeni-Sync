# Mobile Filter Modal Implementation Plan

## Overview

Convertir el sidebar de filtros `[op_sidebar_filters]` en un modal para dispositivos móviles (≤767px), manteniendo la funcionalidad actual del formulario sin cambios.

## Current State

**Situación actual (Imagen 1):**
- El sidebar se muestra directamente en la página móvil
- Ocupa espacio vertical considerable
- No hay interacción modal

**Estado objetivo (Imágenes 2 y 3):**
- Botón "Filtrar por:" visible en mobile
- Modal con overlay oscuro al hacer click
- Botón "X Cerrar" en esquina superior izquierda
- Mismo contenido de filtros dentro del modal

## Proposed Changes

### [shortcodes-filters.php](file:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/inc/shortcodes-filters.php)

**Cambios en estructura HTML:**

1. **Agregar botón trigger** (visible solo en mobile):
   - Texto: "Filtrar por:"
   - Clase: `.op-filters-trigger-btn`
   - Ubicación: Antes del contenedor del sidebar

2. **Envolver formulario en modal**:
   - Crear `.op-filters-modal-wrapper` (overlay)
   - Crear `.op-filters-modal-content` (contenedor del modal)
   - Agregar botón cerrar "X Cerrar" con clase `.op-modal-close`
   - Mantener `.op-sidebar-filters-container` con todo su contenido actual

3. **Estructura propuesta**:
```html
<!-- Botón Trigger (solo mobile) -->
<button class="op-filters-trigger-btn">Filtrar por:</button>

<!-- Modal Wrapper -->
<div class="op-filters-modal-wrapper">
  <div class="op-filters-modal-content">
    <button class="op-modal-close">✕ Cerrar</button>
    
    <!-- Contenido actual del sidebar (sin cambios) -->
    <div class="op-sidebar-filters-container">
      <form>...</form>
    </div>
  </div>
</div>
```

---

### [style.css](file:///c:/xampp/htdocs/ocean/wp-content/themes/hello-elementor-child/style.css)

**Nuevos estilos a agregar:**

#### 1. Botón Trigger (Mobile)
```css
.op-filters-trigger-btn {
  /* Diseño según imagen 2 */
  /* Visible solo en ≤767px */
}
```

#### 2. Modal Wrapper (Overlay)
```css
.op-filters-modal-wrapper {
  /* Overlay oscuro semi-transparente */
  /* Position fixed, full screen */
  /* Oculto por defecto */
  /* Z-index alto */
}
```

#### 3. Modal Content
```css
.op-filters-modal-content {
  /* Contenedor blanco centrado */
  /* Max-height con scroll */
  /* Border-radius */
  /* Animación de entrada */
}
```

#### 4. Botón Cerrar
```css
.op-modal-close {
  /* Diseño según imagen 3 */
  /* Posición superior izquierda */
}
```

#### 5. Estados del Modal
```css
.op-filters-modal-wrapper.active {
  /* Mostrar modal */
}

body.modal-open {
  /* Prevenir scroll */
}
```

#### 6. Responsive
```css
@media (max-width: 767px) {
  /* Ocultar sidebar normal */
  /* Mostrar botón trigger */
  /* Activar modal */
}

@media (min-width: 768px) {
  /* Ocultar botón trigger */
  /* Ocultar modal */
  /* Mostrar sidebar normal */
}
```

---

### JavaScript (Inline en shortcode)

**Funcionalidad a implementar:**

1. **Abrir modal**: Click en `.op-filters-trigger-btn`
   - Agregar clase `.active` a `.op-filters-modal-wrapper`
   - Agregar clase `.modal-open` a `body`

2. **Cerrar modal**: Click en `.op-modal-close`
   - Remover clase `.active`
   - Remover clase `.modal-open`

3. **Cerrar con overlay**: Click en `.op-filters-modal-wrapper` (no en content)
   - Detectar click fuera del modal
   - Cerrar modal

4. **Prevenir propagación**: Click en `.op-filters-modal-content`
   - Evitar que cierre al hacer click dentro

## Verification Plan

### Manual Verification

1. **Desktop (>767px)**:
   - Verificar que el sidebar se muestra normalmente
   - Confirmar que el botón trigger NO es visible
   - Confirmar que el modal NO aparece

2. **Mobile (≤767px)**:
   - Verificar que el sidebar está oculto
   - Confirmar que el botón "Filtrar por:" es visible
   - Click en botón abre el modal correctamente
   - Modal muestra todo el contenido de filtros
   - Botón "X Cerrar" funciona
   - Click en overlay cierra el modal
   - Body no hace scroll cuando modal está abierto

3. **Funcionalidad del formulario**:
   - Todos los filtros funcionan igual que antes
   - Selects, checkboxes, sliders operan correctamente
   - Submit del formulario funciona
   - Botón "Limpiar" funciona

4. **Breakpoint exacto (767px)**:
   - Probar en exactamente 767px
   - Verificar transición suave entre vistas
