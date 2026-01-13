# Plan de Acción: Header Responsive con Elementor Pro

## Análisis de la Situación Actual

### Diseños Objetivo (de las imágenes)
**Imagen 1:** Configuración de Elementor
- Breakpoint: Tablet vertical (< 1024px)
- Toggle Button: Hamburger
- Mobile Dropdown activado

**Imagen 2:** Diseño móvil deseado (pantalla completa)
- Fondo azul (#006AE4) ocupando toda la pantalla
- Links en color blanco, centrados verticalmente
- Botones "Contacto" (blanco con borde) y "Reservar ahora" (oscuro #1B003C)
- Selector de idioma "ESP ▼" con dropdown de banderas

**Imagen 3:** Estado actual móvil cerrado
- Logo a la izquierda
- Hamburger a la derecha

**Imagen 4:** Desktop actual
- Menu horizontal funcionando
- Botones estilizados (azul y oscuro)
- **PROBLEMA:** El botón "Contacto" tiene colores invertidos

### Estructura HTML Actual
- Container: `.elementor-element-0c9087a` (sticky header)
- Logo: `.elementor-element-6212a84`
- Menu Widget: `.elementor-element-de19016`
  - Menu horizontal: `.elementor-nav-menu--main`
  - Toggle hamburger: `.elementor-menu-toggle`
  - Menu dropdown móvil: `.elementor-nav-menu--dropdown`
- Items con clases especiales:
  - `.boton-azul` (Contacto)
  - `.boton-oscuro` (Reservar Ahora)
  - `.pll-parent-menu-item` (Selector de idioma)

### CSS Actual en style.css
**Situación de los botones (líneas 157-186):**
- ✅ Estilos desktop funcionan correctamente
- ❌ No hay estilos específicos para el menú móvil
- ❌ El problema de inversión de colores es porque los botones mantienen el mismo estilo en el dropdown

**Selector de idioma (líneas 188-260):**
- ✅ Desktop funcionando (muestra "ESP" en vez de texto completo)
- ✅ Dropdown con banderas funcional
- ❌ No hay estilos para versión móvil

## Problemas Identificados

### 1. Color del botón "Contacto" invertido
**Causa:** Los estilos actuales aplican a todos los breakpoints. En móvil, Elementor probablemente está aplicando estilos por defecto que invierten los colores.

### 2. Menu móvil sin diseño personalizado
**Problema:** El `.elementor-nav-menu--dropdown` no tiene estilos custom, aparece con el diseño por defecto de Elementor.

### 3. Selector de idioma no optimizado para móvil
**Falta:** Diseño compacto para el selector "ESP" en móvil con dropdown.

## Plan de Acción Propuesto

### Opción A: Solo CSS (RECOMENDADO)
**Ventajas:**
- No modifica el backend de WordPress
- Fácil de mantener
- Funciona con Elementor sin conflictos
- Cambios rápidos y seguros

**Qué haremos:**

#### 1. Fijar el problema de inversión de colores del botón "Contacto"
```css
/* Asegurar que los botones mantengan sus colores en el dropdown móvil */
@media (max-width: 1024px) {
  .elementor-nav-menu--dropdown .boton-azul a {
    background-color: #006AE4 !important;
    color: #ffffff !important;
    border: 1px solid #006AE4 !important;
  }
  
  .elementor-nav-menu--dropdown .boton-oscuro a {
    background-color: #1B003C !important;
    color: #ffffff !important;
    border: 1px solid #1B003C !important;
  }
}
```

#### 2. Diseñar el menú móvil fullscreen con fondo azul
```css
@media (max-width: 1024px) {
  /* Dropdown ocupando toda la pantalla con fondo azul */
  .elementor-nav-menu--dropdown {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    background-color: #006AE4 !important;
    z-index: 9999 !important;
    padding-top: 80px !important;
  }
  
  /* Links en blanco y centrados */
  .elementor-nav-menu--dropdown .elementor-item {
    color: #ffffff !important;
    font-size: 20px !important;
    text-align: center !important;
    padding: 16px 24px !important;
  }
}
```

#### 3. Optimizar selector de idioma para móvil
```css
@media (max-width: 1024px) {
  /* Selector compacto en móvil */
  .elementor-nav-menu--dropdown .pll-parent-menu-item > a span:not(.sub-arrow)::after {
    content: 'ESP';
    color: #ffffff !important;
  }
  
  .elementor-nav-menu--dropdown .pll-parent-menu-item .sub-arrow svg {
    fill: #ffffff !important;
  }
  
  /* Dropdown de idiomas dentro del menú móvil */
  .elementor-nav-menu--dropdown .pll-parent-menu-item .sub-menu {
    background-color: rgba(255, 255, 255, 0.15) !important;
    border-radius: 8px !important;
    margin-top: 8px !important;
  }
}
```

#### 4. Ajustar el botón hamburger y header sticky
```css
@media (max-width: 1024px) {
  /* Asegurar que el toggle esté siempre visible */
  .elementor-menu-toggle {
    z-index: 10000 !important;
  }
  
  /* Cambiar color del hamburger cuando el menú está abierto */
  .elementor-menu-toggle[aria-expanded="true"] svg {
    fill: #ffffff !important;
  }
}
```

### Opción B: CSS + JavaScript
**Ventajas:**
- Mayor control sobre animaciones
- Puede añadir funcionalidades extra (cerrar al hacer clic en un link, etc.)

**Desventajas:**
- Más complejo de mantener
- Requiere enqueue de scripts en WordPress
- Potencialmente puede crear conflictos con Elementor

**Recomendación:** NO necesario para este caso.

### Opción C: Custom Widget de Elementor
**Ventajas:**
- Control total

**Desventajas:**
- Requiere desarrollo de plugin
- Se pierde la facilidad de edición desde Elementor
- Sobreprogramación para un problema simple

**Recomendación:** NO recomendado.

## Breakpoints a Utilizar

Según tu configuración:
- **Móvil:** ≤ 767px (hamburger visible, dropdown activado)
- **Tablet:** 768px - 1250px (hamburger visible, dropdown activado)
- **Laptop:** 1251px - 1500px (puede mostrar menú horizontal o hamburger según tu configuración)
- **Desktop:** > 1500px (menú horizontal visible)

**Media queries principales:**
- `@media (max-width: 767px)` - Móvil
- `@media (min-width: 768px) and (max-width: 1250px)` - Tablet  
- `@media (max-width: 1250px)` - Móvil + Tablet (dropdown activado)
- `@media (min-width: 1251px)` - Laptop + Desktop (menú horizontal)

## Archivos a Modificar

### Solo 1 archivo:
- `c:\xampp\htdocs\ocean\wp-content\themes\hello-elementor-child\style.css`

## Orden de Implementación

1. ✅ Revisar CSS actual (COMPLETADO)
2. ⏳ Agregar media queries para tablet/mobile
3. ⏳ Fijar problema de botón "Contacto"
4. ⏳ Diseñar dropdown fullscreen azul
5. ⏳ Optimizar selector de idioma
6. ⏳ Ajustar botón hamburger
7. ⏳ Probar en diferentes breakpoints
8. ⏳ Ajustes finales

## Consideraciones Importantes

### ⚠️ Especificidad CSS
Elementor usa `!important` en muchos estilos. Por eso la mayoría de nuestros overrides necesitarán `!important` también.

### ⚠️ Clases duplicadas
Elementor duplica el menú en el HTML (uno para desktop, uno para dropdown). Asegurarnos de apuntar al correcto:
- Desktop: `.elementor-nav-menu--main`
- Móvil: `.elementor-nav-menu--dropdown`

### ⚠️ z-index
El menú abierto debe estar por encima del header sticky y cualquier otro elemento:
- Header: sticky (probablemente z-index ~1000)
- Dropdown: z-index 9999
- Toggle: z-index 10000

### ⚠️ Testing
Probar en:
- Chrome/Edge DevTools (responsive mode)
- Dispositivo real si es posible
- Diferentes anchos: 375px, 768px, 1024px, 1200px+

## Siguiente Paso

¿Procedo con la **Opción A (Solo CSS)** como plan recomendado?

Esto implicará:
1. Agregar ~80-100 líneas de CSS al final de tu `style.css`
2. No tocar ningún archivo de Elementor o WordPress core
3. Mantener toda la funcionalidad de edición desde Elementor
4. Solucionar todos los problemas identificados

¿Te parece bien este enfoque o prefieres alguna modificación al plan?
