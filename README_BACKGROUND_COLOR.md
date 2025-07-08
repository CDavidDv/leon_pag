# Sistema de Colores de Fondo

## Descripción
Este sistema permite cambiar dinámicamente el color de fondo del sitio web y guardarlo en la base de datos para que se mantenga consistente en todas las páginas.

## Características

### 1. Base de Datos
- **Tabla**: `site_configs`
- **Campos**:
  - `key`: Clave única de la configuración (ej: 'background_color')
  - `value`: Valor de la configuración (ej: '#0A15E3')
  - `type`: Tipo de configuración ('color', 'string', 'number', 'boolean')
  - `description`: Descripción de la configuración

### 2. API Endpoints
- `GET /api/site-config` - Obtener todas las configuraciones
- `GET /api/site-config/{key}` - Obtener una configuración específica
- `PUT /api/site-config/{key}` - Actualizar una configuración
- `POST /api/site-config/background-color` - Actualizar color de fondo

### 3. Componente Vue
- **Archivo**: `resources/js/Components/BackgroundColorEditor.vue`
- **Funcionalidades**:
  - Selector de color visual
  - Campo de texto para código hexadecimal
  - Vista previa del color
  - Aplicación automática del color

### 4. Variables CSS
- `--site-background-color`: Color de fondo principal
- `--site-primary-color`: Color primario
- `--site-secondary-color`: Color secundario

## Instalación

### 1. Ejecutar Migraciones
```bash
php artisan migrate
```

### 2. Inicializar Configuraciones
```bash
php artisan site:init-config
```

### 3. Compilar Assets
```bash
npm run dev
```

## Uso

### En Modo Edición
1. Ir a la página de edición (`/welcome/edit`)
2. Activar el modo de edición
3. Aparecerá el editor de color de fondo en la esquina superior izquierda
4. Seleccionar un nuevo color o escribir el código hexadecimal
5. El color se aplicará automáticamente y se guardará en la base de datos

### En Código
```vue
<template>
  <div class="bg-site-primary">
    <!-- Contenido con color de fondo dinámico -->
  </div>
</template>
```

### En CSS
```css
.my-element {
    background-color: var(--site-background-color);
}
```

## Archivos Modificados

### Backend
- `database/migrations/2025_06_20_014627_create_site_configs_table.php`
- `app/Models/SiteConfig.php`
- `app/Http/Controllers/SiteConfigController.php`
- `routes/api.php`
- `database/seeders/SiteConfigSeeder.php`
- `app/Console/Commands/InitializeSiteConfig.php`

### Frontend
- `resources/js/Components/BackgroundColorEditor.vue`
- `resources/js/Pages/Welcome/edit.vue`
- `resources/js/Layouts/AppLayoutEdit.vue`
- `resources/css/app.css`

## Notas Técnicas

1. **Compatibilidad**: El sistema funciona tanto con clases CSS personalizadas (`bg-site-primary`) como con clases Tailwind hardcodeadas (`bg-[#0A15E3]`)

2. **Persistencia**: Los cambios se guardan automáticamente en la base de datos

3. **Rendimiento**: Los colores se aplican inmediatamente sin necesidad de recargar la página

4. **Validación**: El código hexadecimal se valida en el backend antes de guardar

## Troubleshooting

### Si los colores no se aplican:
1. Verificar que la base de datos esté funcionando
2. Ejecutar `php artisan site:init-config`
3. Verificar que las variables CSS estén definidas en `app.css`
4. Comprobar que el componente `BackgroundColorEditor` esté importado correctamente

### Si hay errores de conexión a la base de datos:
1. Verificar que XAMPP esté ejecutándose
2. Comprobar la configuración de la base de datos en `.env`
3. Ejecutar `php artisan config:cache` 