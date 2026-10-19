# AD Consulting — sitio web

Sitio de AD Consulting construido con **Laravel 13**, **Livewire 4** (con Alpine.js) y **Tailwind CSS 4**. Requiere **PHP 8.3** o superior.

## Estructura

| Ruta | Vista / componente |
| --- | --- |
| `/` | `resources/views/site/home.blade.php` |
| `/nosotros` | `site/nosotros.blade.php` (modal del equipo con Alpine) |
| `/servicios` | `site/servicios.blade.php` + Livewire `ServiceExplorer` |
| `/noticias` | `site/noticias.blade.php` + Livewire `ExperienceList` |
| `/ad50`, `/black` | `site/ad50.blade.php`, `site/black.blade.php` (`/adblack` redirige a `/black`) |
| `/admin` | Livewire `Admin\ExperienceManager` |

- Textos importados del sitio anterior: `resources/content/source.json`.
- Datos editoriales (fotos, equipo, servicios, clientes): `app/Support/SiteContent.php`.
- Estilos: `resources/css/app.css`. Interacciones de cliente (menú móvil, video, modal, animaciones): `resources/js/app.js`.
- El formulario de contacto (`App\Livewire\ContactForm`) envía un correo a `SITE_CONTACT_EMAIL`.

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate        # crea las tablas e importa las Experiencias actuales
php artisan storage:link   # publica las imágenes subidas desde /admin
npm install && npm run build
```

Desarrollo local: `composer dev` (o `php artisan serve` + `npm run dev`).

## Configuración (`.env`)

- `ADMIN_PASSWORD`: contraseña larga y única para entrar a `/admin`. Sin ella el panel no permite ingresar.
- `SITE_CONTACT_EMAIL`: correo que recibe el formulario de contacto.
- `MAIL_*`: configura un servidor SMTP real en producción (por defecto `MAIL_MAILER=log` solo escribe el correo en `storage/logs`).
- `DB_*`: SQLite por defecto; también funciona con MySQL/MariaDB o PostgreSQL.
- `SITE_UPLOADS_DISK`: disco para las imágenes de Experiencias (`public` por defecto; puede ser `s3`).

## Administración de Experiencias

En `/admin` se pueden crear, editar, publicar/despublicar y eliminar Experiencias. Las imágenes son opcionales (máx. 4 MB) y se guardan en `storage/app/public/experiencias`. Si la base de datos no está disponible, la página pública muestra la lista incluida en el proyecto.

## Despliegue

Cualquier hosting con PHP 8.3+ (Forge, Ploi, Laravel Cloud, VPS con Nginx/Apache, cPanel). El document root debe apuntar a `public/`. En cada despliegue:

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan optimize
```

## Pruebas

```bash
php artisan test
```
