# Walkthrough: Nuevo Hero "25 Aniversario"

Hemos transformado el encabezado de la página en un mosaico interactivo que muestra la evolución de la empresa.

## Cambios Realizados

1.  **Reemplazo del Hero Estático**: Se eliminó la imagen de fondo única y el título simple.
2.  **Cuadrícula Masonry**: Implementación CSS (`column-count`) que permite mezclar fotos verticales y horizontales sin huecos extraños.
3.  **Efecto "Reveal"**:
    *   La imagen **Antigua** se muestra por defecto.
    *   Al pasar el mouse, esta se desvanece suavemente revelando la imagen **Actual** en el mismo lugar.
4.  **Responsive**:
    *   3 columnas en Escritorio.
    *   2 columnas en Tablets.
    *   1 columna en Móviles.

## Instrucciones para el Usuario (Admin)

Para que el diseño funcione, debes cargar contenido en los nuevos campos creados:

1.  Ve a la edición de la página **25 Aniversario**.
2.  Busca el campo **Hero Galeria** (Repeater).
3.  Agrega filas ("Add Row"):
    *   **Imagen Antigua**: Sube la foto vieja (Blanco y negro o vintage).
    *   **Imagen Actual**: Sube la foto nueva (Mismo encuadre preferiblemente, o similar).
    *   **Descripción**: (Opcional) Texto como "1999 vs 2024" que aparecerá al pie de la foto en hover.

> [!TIP]
> Para mejor resultado, intenta que el par de imágenes (Antigua y Actual) tengan las mismas dimensiones o proporción (aspect ratio). Si una es vertical y la otra horizontal, el efecto de transición puede verse "saltarín" ya que la altura de la tarjeta cambiará.

## Verificación Visual

El título principal "25 AÑOS DE EVOLUCIÓN" ahora aparece flotando sobre el mosaico con un estilo moderno y legible.
