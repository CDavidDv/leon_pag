# Configuración de Email para Notificaciones de Contacto

## Configuración en .env

Para que el sistema de notificaciones de contacto funcione, necesitas configurar el email en tu archivo `.env`:

```env
# Configuración de Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicación
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="Tu Nombre"
```

## Configuración del Email de Administrador

El email de administrador se configura automáticamente en la base de datos con el valor `admin@tudominio.com`. Para cambiarlo:

1. Ve a la base de datos
2. Busca la tabla `site_configs`
3. Cambia el valor de la clave `admin_email` por tu email real

O ejecuta este comando SQL:
```sql
UPDATE site_configs SET value = 'tu-email@ejemplo.com' WHERE `key` = 'admin_email';
```

## Configuración para Gmail

Si usas Gmail:

1. Activa la verificación en dos pasos en tu cuenta de Google
2. Genera una "Contraseña de aplicación" en la configuración de seguridad
3. Usa esa contraseña en `MAIL_PASSWORD`

## Configuración para otros proveedores

### Outlook/Hotmail:
```env
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
```

### Yahoo:
```env
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
```

## Prueba de configuración

Para probar que el email funciona:

1. Envía un mensaje desde el formulario de contacto
2. Verifica que recibes el email de notificación
3. Revisa los logs en `storage/logs/laravel.log` si hay errores

## Solución de problemas

Si no recibes emails:

1. Verifica que las credenciales sean correctas
2. Asegúrate de que el puerto no esté bloqueado por el firewall
3. Revisa que el email de administrador esté configurado correctamente
4. Verifica los logs de Laravel para errores específicos 