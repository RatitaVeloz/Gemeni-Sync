# Guía de Edición - Padding de Links del Menú Móvil

## 📍 Ubicaciones para Editar Padding

Aquí están las líneas exactas del archivo `style.css` donde puedes ajustar el espaciado:

---

### 1. Padding de Links Normales (Apartamentos, El Pavilion, Nosotros)

**Ubicación:** Línea **1215** del `style.css`

```css
.elementor-nav-menu--dropdown .elementor-item {
    padding: 18px 28px !important;  /* ← EDITA AQUÍ */
}
```

**Qué hace:**
- Primer valor (`18px`): padding vertical (arriba/abajo)
- Segundo valor (`28px`): padding horizontal (izquierda/derecha)

**Ejemplo para más espaciado:**
```css
padding: 22px 32px !important;  /* Más espacio arriba/abajo y a los lados */
```

**Ejemplo para menos espaciado:**
```css
padding: 14px 24px !important;  /* Menos espacio */
```

---

### 2. Margen Entre Items (Separación entre links)

**Ubicación:** Línea **1206** del `style.css`

```css
.elementor-nav-menu--dropdown .menu-item {
    margin-bottom: 16px !important;  /* ← EDITA AQUÍ */
}
```

**Qué hace:**
- Controla el espacio entre cada item del menú

**Ejemplo para más separación:**
```css
margin-bottom: 24px !important;  /* Más espacio entre items */
```

**Ejemplo para menos separación:**
```css
margin-bottom: 12px !important;  /* Menos espacio entre items */
```

---

### 3. Padding de Botones (Contacto y Reservar Ahora)

**Botón "Contacto"** - Línea **1242**
```css
.elementor-nav-menu--dropdown .boton-azul a {
    padding: 14px 32px !important;  /* ← EDITA AQUÍ */
}
```

**Botón "Reservar Ahora"** - Línea **1259**
```css
.elementor-nav-menu--dropdown .boton-oscuro a {
    padding: 14px 32px !important;  /* ← EDITA AQUÍ */
}
```

**Ejemplo:**
```css
padding: 16px 36px !important;  /* Botones más grandes */
```

---

### 4. Padding del Selector de Idioma "ESP"

**Ubicación:** Línea **1288** del `style.css`

```css
.elementor-nav-menu--dropdown .pll-parent-menu-item > a {
    padding: 12px 20px !important;  /* ← EDITA AQUÍ */
}
```

---

## 🔧 Cambios Aplicados en Esta Corrección

### Problema 1: ✅ Dropdown de idiomas infinito
- **Solución:** Agregué `max-height: 80px` y `overflow: hidden`
- **Línea:** 1301-1302

### Problema 2: ✅ Línea blanca arriba
- **Solución:** Agregué `right: 0`, `bottom: 0`, `margin: 0` y reduje `padding-top` a `80px`
- **Líneas:** 1168-1169, 1172, 1182

### Problema 3: ✅ Iconos pequeños
- **Solución:** Aumenté el tamaño de iconos de `28px` a `36px`
- **Líneas:** 1344-1345

### Problema 4: ✅ Padding de links
- **Solución:** Aumenté padding de `16px 24px` a `18px 28px` y margin de `8px` a `16px`
- **Líneas:** 1206, 1215

---

## 📝 Notas Importantes

1. **Siempre usa `!important`** - Necesario para sobrescribir los estilos de Elementor
2. **Sintaxis del padding:** `padding: [arriba/abajo] [izquierda/derecha]`
3. **Refresh del navegador:** Después de editar, limpia caché (Ctrl+Shift+R)
4. **Media queries:** Estos estilos solo aplican cuando el ancho es ≤ 1250px

---

## 🎯 Valores Recomendados según Diseño

| Elemento | Padding Actual | Sugerencia Compacto | Sugerencia Espacioso |
|----------|---------------|---------------------|----------------------|
| Links normales | `18px 28px` | `14px 24px` | `22px 32px` |
| Margin entre items | `16px` | `12px` | `20px` |
| Botones | `14px 32px` | `12px 28px` | `16px 36px` |
| Selector idioma | `12px 20px` | `10px 16px` | `14px 24px` |

---

## ⚡ Testing Rápido

Después de editar:
1. Guarda el archivo `style.css`
2. Abre tu sitio en el navegador
3. Presiona **Ctrl + Shift + R** (hard refresh)
4. Redimensiona el navegador a menos de 1250px de ancho
5. Abre el menú hamburger
6. Verifica el espaciado

Si no ves cambios, puede que necesites limpiar el caché de WordPress (si tienes plugin de caché activo).

---

## 🔧 Correcciones Adicionales Aplicadas

### ✅ Centrado de Botones
**Problema:** Los botones "Contacto" y "Reservar Ahora" estaban desalineados (corridos a la izquierda)

**Solución:** Agregué flexbox al contenedor `.menu-item` (línea 1211-1212)
```css
display: flex !important;
justify-content: center !important;
```

### ✅ Altura del Dropdown de Idiomas
**Problema:** El dropdown de idiomas era muy alto con mucho espacio vacío

**Solución:** Reduje `max-height` de 200px a 60px (línea 1330)
```css
max-height: 60px !important;  /* Antes era 200px */
```

**Para ajustar la altura del dropdown:**
- Ir a la línea 1330 en `style.css`
- Cambiar el valor `60px` por el que prefieras
- Valores sugeridos: `50px` (muy compacto), `60px` (actual), `80px` (espacioso)
