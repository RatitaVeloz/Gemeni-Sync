# Plan de Implementación: Hero "Antes y Después" (Mosaico)

El objetivo es reemplazar el Hero actual de una sola imagen por un mosaico dinámico tipo "Pinterest" (Masonry) que permita comparar fotos antiguas con actuales.

## Requisitos Previos (Acción del Usuario)

Necesitarás crear los siguientes campos en el administrador de WordPress (ACF) para la página "25 Aniversario".

**Nuevo Campo Repeater:** `hero_galeria`
Dentro de este repeater, crear los siguientes sub-campos:
1.  **Imagen Antigua** (`imagen_antigua`) - Tipo: Imagen (Return: ID o Array).
2.  **Imagen Actual** (`imagen_actual`) - Tipo: Imagen (Return: ID o Array).
3.  **Descripción / Año** (`descripcion`) - Tipo: Tekto (Opcional, para tooltips).

## Cambios Propuestos en Código

### 1. Modificar `page-25-aniversario.php`
Reemplazaremos el bloque `<div class="aniversario-hero">` actual con una nueva estructura.

**Estructura HTML Nueva:**
```html
<div class="aniversario-hero-masonry">
    <div class="masonry-grid">
        <!-- Loop PHP de ACF -->
        <div class="masonry-item">
            <div class="ba-card">
                <img class="img-after" src="foto-actual.jpg" />
                <img class="img-before" src="foto-vieja.jpg" /> <!-- Position absolute, z-index superior -->
            </div>
        </div>
        <!-- Fin Loop -->
    </div>
    <!-- Overlay de Títulos (Opcional, para mantener el título h1 original encima del mosaico) -->
    <div class="hero-overlay">
        <h1>25 años construyendo futuro</h1>
    </div>
</div>
```

**Estrategia CSS (Masonry + Efecto):**
Usaremos `column-count` en CSS. Es la forma más robusta de hacer un mosaico con elementos de altura variable (verticales/horizontales) sin JavaScript complejo.
*   `.masonry-grid`: `column-count: 3;` (Escritorio), `2` (Tablet), `1` (Móvil).
*   `.masonry-item`: `break-inside: avoid;` para que no se corten las fotos.
*   **Efecto Reveal**: La foto "Antigua" estará encima. Al hacer `:hover` en el contenedor, la opacidad de la foto antigua bajará a 0, revelando la "Actual" que está debajo.

### 2. Estilos
Agregaremos los estilos directamente en el archivo PHP (bloque `<style>`) o en un archivo CSS parcial si es preferible, para evitar conflictos con el resto del sitio.

## Verificación
1.  Verificar que las imágenes verticales no rompan el layout.
2.  Probar en móvil (colapsar a 1 columna).
3.  Comprobar que el hover funcione suavemente.
