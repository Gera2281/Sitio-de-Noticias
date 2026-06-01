# 📰 Sitio de Noticias

Plataforma web de gestión y publicación de noticias por categorías, desarrollada con **Laravel 12**. Implementa un flujo de trabajo controlado por roles (Editor, Revisor y Espectador) para garantizar la calidad del contenido publicado.

---

# Contenidos

1. [Descripción del Proyecto](#-descripción-del-proyecto)
2. [Roles del Sistema](#-roles-del-sistema)
3. [Requisitos Previos](#-requisitos-previos)
4. [Instalación Paso a Paso](#-instalación-paso-a-paso)
5. [Configuración de la Base de Datos](#-configuración-de-la-base-de-datos)
6. [Compilación de Assets](#-compilación-de-assets)
7. [Usuarios de Prueba](#-usuarios-de-prueba)
8. [Cómo Usar el Sistema](#-cómo-usar-el-sistema)
9. [Ejecutar las Pruebas](#-ejecutar-las-pruebas)
10. [Solución de Problemas Comunes](#-solución-de-problemas-comunes)
11. [Tecnologías Utilizadas](#-tecnologías-utilizadas)

---

## 📖 Descripción del Proyecto

Sitio de Noticias es una aplicación web que permite la publicación de contenido periodístico organizado en **5 categorías**:

- 🏟️ Deportes
- 💻 Tecnología
- 🌍 Internacionales
- 🌤️ Clima
- 📍 Locales

El contenido pasa por un flujo de aprobación antes de ser visible al público:

```
1. El editor crea noticia → Estado: "Pendiente"
2. El revisor revisa:
   - Si aprueba → Estado: "Aprobada" (Visible al público). El revisor puede eliminarla después.
   - Si rechaza → Estado: "Rechazada". El editor puede eliminarla o editarla para volver a enviarla (vuelve a "Pendiente").
```

Solo las noticias en estado **Aprobada** son visibles para el público general.

---

## 👥 Roles del Sistema

| Rol           |        Permisos
|---------------|----------------
| **Editor**    | Crear noticias. Editar y eliminar únicamente sus propias noticias que hayan sido rechazadas.
| **Revisor**   | Aprobar/rechazar noticias pendientes. Eliminar noticias que ya están aprobadas.
| **Espectador** | Leer noticias aprobadas (rol por defecto al registrarse)
| **Invitado**  | Leer noticias aprobadas sin necesidad de registrarse

---

## ✅ Requisitos Previos

Antes de instalar el proyecto, debes tener instalado lo siguiente en tu computadora. **Todos son obligatorios.**

### 1. PHP 8.2 o superior

**Windows (recomendado: XAMPP)**
- Descarga XAMPP desde: https://www.apachefriends.org/
- Elige la versión que incluya **PHP 8.2 o superior**
- Durante la instalación, selecciona al menos los componentes: **Apache**, **MySQL**, **PHP**
- Después de instalar, agrega PHP al PATH del sistema:
  - Abre el menú Inicio → busca "Variables de entorno"
  - En "Variables del sistema", selecciona `Path` → Editar
  - Agrega una nueva entrada: `C:\xampp\php`
  - Acepta todos los cambios y reinicia la terminal

Verifica la instalación abriendo una terminal (CMD o PowerShell) y ejecutando:
```bash
php -v
```
Debes ver algo como: `PHP 8.2.x ...`

---

### 2. Composer (gestor de dependencias de PHP)

- Descarga el instalador desde: https://getcomposer.org/download/
- Ejecuta el instalador `.exe` y sigue los pasos
- Cuando te pregunte por el ejecutable de PHP, apunta a `C:\xampp\php\php.exe`

Verifica la instalación:
```bash
composer -V
```
Debes ver algo como: `Composer version 2.x.x`

---

### 3. Node.js 18 o superior (incluye npm)

- Descarga desde: https://nodejs.org/en/
- Descarga la versión **LTS (Long Term Support)**
- Instala con las opciones por defecto

Verifica la instalación:
```bash
node -v
npm -v
```
Debes ver los números de versión de ambos.

---

### 4. Git

- Descarga desde: https://git-scm.com/download/win
- Instala con las opciones por defecto

Verifica la instalación:
```bash
git -v
```

---

### 5. MySQL (ya incluido en XAMPP)

Si instalaste XAMPP, ya tienes MySQL disponible.

- Abre el **Panel de Control de XAMPP** (`C:\xampp\xampp-control.exe`)
- Inicia el servicio **MySQL** haciendo clic en el botón "Start"
- El servicio debe aparecer en verde con el puerto `3306`

---

## 🚀 Instalación Paso a Paso

> ⚠️ **Importante:** Sigue los pasos **en el orden exacto indicado**. No saltes ningún paso.

### Paso 1 — Clonar el repositorio

Abre una terminal (CMD o PowerShell) y navega hasta la carpeta donde quieras instalar el proyecto. Se recomienda usar la carpeta `htdocs` de XAMPP:

```bash
cd C:\xampp\htdocs
```

Clona el repositorio:
```bash
git clone https://github.com/TU_USUARIO/Sitio-de-Noticias.git
```
> ⚠️ Reemplaza `TU_USUARIO` con el nombre de usuario real de GitHub.

Entra a la carpeta del proyecto:
```bash
cd Sitio-de-Noticias
```

---

### Paso 2 — Instalar dependencias de PHP

Este comando descarga todas las librerías de PHP que el proyecto necesita (carpeta `vendor`):

```bash
composer install
```

> ⏳ Este proceso puede tardar entre 1 y 3 minutos según tu conexión a internet. Espera a que termine completamente antes de continuar.

---

### Paso 3 — Instalar dependencias de Node.js

Este comando descarga las herramientas de compilación de CSS/JS (carpeta `node_modules`):

```bash
npm install
```

---

### Paso 4 — Crear el archivo de configuración

El proyecto necesita un archivo `.env` con la configuración del entorno. Cópialo desde el archivo de ejemplo:

```bash
copy .env.example .env
```

---

### Paso 5 — Generar la clave de seguridad de la aplicación

Laravel necesita una clave única para encriptar sesiones y datos. Genera esta clave con:

```bash
php artisan key:generate
```

Deberías ver el mensaje: `Application key set successfully.`

---

## 🗄️ Configuración de la Base de Datos

### Paso 6 — Crear la base de datos en MySQL

1. Asegúrate de que el servicio **MySQL** esté corriendo en el Panel de Control de XAMPP.
2. Abre tu navegador y ve a: `http://localhost/phpmyadmin`
3. En el panel izquierdo, haz clic en **"Nueva"** (o "New").
4. En el campo **Nombre de la base de datos**, escribe exactamente: `Snoticias`
5. En el selector de cotejamiento (collation), elige: `utf8mb4_unicode_ci`
6. Haz clic en **"Crear"**.

---

### Paso 7 — Configurar la conexión en el archivo `.env`

Abre el archivo `.env` (que copiaste en el Paso 4) con cualquier editor de texto (bloc de notas, VSCode, etc.) y verifica que las siguientes líneas coincidan con tu configuración de XAMPP:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Snoticias
DB_USERNAME=root
DB_PASSWORD=
```

> ℹ️ En XAMPP, el usuario por defecto de MySQL es `root` y la contraseña está **vacía** (sin escribir nada). Si tu instalación tiene una contraseña diferente, escríbela después de `DB_PASSWORD=`.

Guarda los cambios en el archivo `.env`.

---

### Paso 8 — Ejecutar las migraciones

Este comando crea todas las tablas necesarias en la base de datos `Snoticias`:

```bash
php artisan migrate
```

Cuando pregunte `Do you want to run this command? [yes/no]`, escribe `yes` y presiona Enter.

Deberías ver una lista de todas las migraciones ejecutadas con ✓.

---

### Paso 9 — Poblar la base de datos con usuarios de prueba

Este comando crea los 3 usuarios de prueba (Editor, Revisor, Espectador):

```bash
php artisan db:seed
```

Deberías ver el mensaje: `Database seeding completed successfully.`

---

### Paso 10 — Crear el enlace de almacenamiento de imágenes

El proyecto almacena las imágenes que suben los editores en una carpeta especial. Este comando crea el acceso público a esa carpeta:

```bash
php artisan storage:link
```

Deberías ver el mensaje: `The [public/storage] link has been connected to [storage/app/public].`

---

## 🎨 Compilación de Assets

### Paso 11 — Compilar CSS y JavaScript

El proyecto usa **Vite** para compilar los estilos y scripts. Ejecuta este comando para generar los archivos para producción:

```bash
npm run build
```

> ⏳ Este proceso puede tardar entre 30 segundos y 1 minuto. Espera hasta que veas el mensaje final con los archivos generados.

---

## ▶️ Iniciar el Servidor

### Paso 12 — Levantar el servidor de desarrollo

```bash
php artisan serve
```

Deberías ver:

```
INFO  Server running on [http://127.0.0.1:8000].
```

Abre tu navegador y visita: **http://127.0.0.1:8000**

¡Listo! El proyecto ya está funcionando

> ℹ️ **Nota:** Mantén esta terminal abierta mientras uses el proyecto. Para detener el servidor, presiona `Ctrl + C`.

---

## 👤 Usuarios de Prueba

El seeder del Paso 9 crea automáticamente los siguientes usuarios para que puedas probar todas las funciones del sistema de inmediato:

| Rol | Correo Electrónico | Contraseña |
|-----|--------------------|------------|
| **Espectador** | espectador@example.com | password123 |
| **Editor** | editor@example.com | password123 |
| **Revisor** | revisor@example.com | password123 |

> ℹ️ También puedes registrar un nuevo usuario desde el sitio web. Por defecto, todos los usuarios nuevos reciben el rol de **Espectador**.

---

## 📱 Cómo Usar el Sistema

### Como Espectador / Invitado
1. Visita `http://127.0.0.1:8000`
2. Navega por las categorías en el menú superior (Deportes, Tecnología, etc.)
3. Haz clic en cualquier noticia aprobada para leer su contenido completo

### Como Editor
1. Inicia sesión con `editor@example.com` / `password123`
2. En el menú de cualquier categoría, aparecerá el botón **"Nueva Noticia"**
3. Completa el formulario: Título, Descripción, Contenido e Imagen (opcional, máx. 2 MB, formatos: jpg, png, webp)
4. Envía el formulario. La noticia quedará en estado **"Pendiente"** hasta que un Revisor la apruebe

### Como Revisor
1. Inicia sesión con `revisor@example.com` / `password123`
2. Visita cualquier categoría para ver la lista de noticias **pendientes de revisión**
3. Haz clic en **"Aprobar"** para publicar la noticia, o en **"Rechazar"** para descartarla

---

## 🧪 Ejecutar las Pruebas

El proyecto incluye una suite de pruebas automatizadas. Para ejecutarlas:

```bash
php artisan test
```

Deberías ver: `Tests: 25 passed (61 assertions)`

---

## 🔧 Solución de Problemas Comunes

### ❌ Error: "No application encryption key has been specified"
**Solución:** Ejecuta el comando del Paso 5:
```bash
php artisan key:generate
```

---

### ❌ Error: "SQLSTATE: Connection refused" o "Unknown database"
**Causas posibles:**
1. MySQL no está iniciado → Abre XAMPP y haz clic en "Start" en MySQL
2. La base de datos no existe → Créala en phpMyAdmin (Paso 6)
3. Las credenciales en `.env` son incorrectas → Verifica el Paso 7

---

### ❌ Error: "Class not found" o errores al cargar la página
**Solución:** Regenera el autoloader de Composer:
```bash
composer dump-autoload
```

---

### ❌ La página carga pero sin estilos (CSS)
**Solución:** El CSS no está compilado. Ejecuta:
```bash
npm run build
```

---

### ❌ Las imágenes subidas no aparecen
**Solución:** El enlace de almacenamiento no está creado. Ejecuta:
```bash
php artisan storage:link
```

---

### ❌ Error al ejecutar `composer install`: "Your lock file does not contain..."
**Solución:**
```bash
composer update
```

---

### ❌ Error: "php is not recognized as an internal or external command"
**Causa:** PHP no está en el PATH del sistema.

**Solución:** Agrega `C:\xampp\php` al PATH del sistema (ver Paso 1 de los Requisitos Previos) y reinicia la terminal.

---

### ❌ Error: "npm is not recognized..."
**Causa:** Node.js no está instalado o no se agregó al PATH.

**Solución:** Reinstala Node.js desde https://nodejs.org asegurándote de marcar la opción "Add to PATH" durante la instalación.

---

## 🛠️ Tecnologías Utilizadas

| Tecnología        | Versión | Uso                     |
|-------------------|---------|-------------------------|
| **PHP**           | ^8.2    | Lenguaje backend        |
| **Laravel**       | ^12.0   | Framework principal     |
| **MySQL**         | 5.7+    | Base de datos relacional |
| **Vite**          | ^7.0    | Compilación de assets   |
| **TailwindCSS**   | ^4.0    | Framework de estilos CSS |
| **Alpine.js**     | ^3.4    | Interactividad del frontend |
| **Bootstrap**     | 5 (CDN) | Componentes de UI adicionales |
| **Laravel Breeze**| ^2.4    | Autenticación y gestión de usuarios |

---

## 📁 Estructura de Carpetas Relevante

```
Sitio-de-Noticias/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── TareaController.php     # Lógica principal de noticias
│   │   │   └── Auth/                   # Controladores de autenticación
│   │   └── Middleware/
│   │       └── RoleMiddleware.php      # Control de acceso por roles
│   └── Models/                         # Modelos Eloquent (Deporte, Clima, etc.)
├── database/
│   ├── migrations/                     # Estructura de tablas
│   └── seeders/                        # Datos iniciales (usuarios de prueba)
├── public/
│   └── img/                            # Imágenes estáticas del sitio
├── resources/
│   └── views/                          # Plantillas Blade (HTML)
├── routes/
│   └── web.php                         # Definición de rutas y middlewares
├── storage/
│   └── app/public/images/              # Imágenes subidas por editores
└── .env                                # Configuración del entorno (NO subir a Git)
```

---

## 📝 Licencia

Este proyecto fue desarrollado como trabajo académico para la materia de Desarrollo de Aplicaciones Web.
