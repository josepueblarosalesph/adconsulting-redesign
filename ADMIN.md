# Administración de Experiencias

El sitio incluye un panel privado en `/admin`. Desde allí se pueden crear, editar, publicar, despublicar y eliminar Experiencias. Las imágenes son opcionales y se cargan en Vercel Blob.

## Configuración en Vercel

1. En el proyecto de Vercel, abre **Storage** y agrega la integración **Neon** desde el Marketplace. Selecciona la misma cuenta y proyecto. La integración crea `DATABASE_URL` automáticamente.
2. En **Storage**, crea un almacén **Vercel Blob** de tipo público. Vercel agregará `BLOB_READ_WRITE_TOKEN`.
3. Ve a **Settings → Environment Variables** y agrega:
   - `ADMIN_PASSWORD`: una contraseña larga y única para acceder a `/admin`.
   - `ADMIN_SESSION_SECRET`: un valor aleatorio, largo y distinto de la contraseña.
4. Marca las variables para **Production**, **Preview** y **Development** si quieres usar el panel en los tres entornos.
5. Haz un nuevo despliegue. Al primer acceso con la base configurada, las Experiencias actuales se importan una vez en Neon y luego se administran desde `/admin`.

Las imágenes se limitan a 4 MB por carga, lo que mantiene la subida compatible con Vercel. Usa imágenes optimizadas para web.

## Desarrollo local

Copia `.env.example` como `.env.local` y completa las mismas variables. Sin `DATABASE_URL`, la página pública conserva la lista actual incluida en el proyecto; el panel informa que falta conectar Neon.
