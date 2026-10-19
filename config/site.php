<?php

return [

    /*
    | Correo que recibe los mensajes del formulario de contacto y que se
    | muestra en el sitio.
    */
    'contact_email' => env('SITE_CONTACT_EMAIL', 'contacto@adconsulting.cl'),

    /*
    | Contraseña del panel /admin. Sin valor, el panel no permite ingresar.
    */
    'admin_password' => env('ADMIN_PASSWORD'),

    /*
    | Disco donde se guardan las imágenes subidas desde el panel.
    | Recuerda ejecutar `php artisan storage:link` si usas el disco "public".
    */
    'uploads_disk' => env('SITE_UPLOADS_DISK', 'public'),

    'whatsapp_url' => 'https://api.whatsapp.com/send/?phone=56984722932&text=Hola%20Ariela!&type=phone_number&app_absent=0',

];
