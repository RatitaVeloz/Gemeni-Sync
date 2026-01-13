# Guía de Uso Diario de Git: Sincronización Notebook <-> PC

Esta guía te explica el flujo de trabajo (workflow) que debes seguir cada vez que cambies de computadora para mantener tus archivos sincronizados.

## Concepto Clave
Imagina que Git es como un sistema de "Guardado en la Nube" manual.
- **Pull (Jalar):** Descarga lo último de la nube a tu compu.
- **Push (Empujar):** Sube tus cambios de tu compu a la nube.

---

## 1. Al EMPEZAR a trabajar (En cualquier PC)
**Siempre** haz esto antes de tocar cualquier archivo, apenas te sientas en la compu.

1. Abre tu terminal (PowerShell o Git Bash) en la carpeta de tu proyecto.
2. Ejecuta:
   ```powershell
   git pull
   ```
   *Esto descarga los cambios que hayas subido desde la otra computadora. Si dice "Already up to date", es que no había nada nuevo.*

## 2. Durante tu trabajo
Trabaja normalmente. Edita tus archivos, crea nuevos, borra los viejos. Git está observando pero no "guarda" nada todavía en el historial compartido.

## 3. Al TERMINAR de trabajar (Antes de cambiar de PC)
Para guardar tu progreso y que esté disponible en la otra computadora:

1. **Revisar qué cambió (Opcional pero recomendado):**
   ```powershell
   git status
   ```
   *(Te mostrará en rojo lo que modificaste).*

2. **Preparar los archivos (Add):**
   ```powershell
   git add .
   ```
   *(El punto `.` significa "todo". Esto pone todos tus cambios en la "caja" para ser enviados).*

3. **Guardar la versión localmente (Commit):**
   ```powershell
   git commit -m "Descripción breve de lo que hice hoy"
   ```
   *Ejemplo: `git commit -m "Agregue notas de la reunion y actualice precios"`.*

4. **Subir a la nube (Push):**
   ```powershell
   git push
   ```
   *(Esto envía tu "caja" guardada al servidor remoto GitHub/GitLab).*

---

## Resumen Rápido

### Al llegar (PC A)
```powershell
git pull
```

### ... Trabajas ...

### Al irte (PC A)
```powershell
git add .
git commit -m "Avance del dia"
git push
```

### Al llegar (PC B)
```powershell
git pull
# ¡Y verás mágicamente lo que hiciste en la PC A!
```

## Solución de Problemas Comunes

- **Error al hacer `git push` (Updates were rejected):**
  Esto pasa si olvidaste hacer `git pull` antes de empezar y alguien (o tú mismo en la otra PC) subió cambios.
  - Solución: Ejecuta `git pull` primero. Si hay "conflictos" (mismas líneas modificadas), Git te pedirá que elijas qué versión guardar.

- **Olvidé hacer push en la otra PC:**
  Si llegas a la PC B y haces `git pull` pero no baja nada, probablemente olvidaste hacer `git push` en la PC A.
  - Solución: Lamentablemente, tienes que volver a la PC A y hacer el push. O trabajar en la PC B con cuidado de no tocar los mismos archivos, y luego resolver el conflicto cuando ambas tengan cambios.
