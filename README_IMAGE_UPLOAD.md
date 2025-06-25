# Sistema de Subida de Imágenes

Este sistema permite subir y gestionar imágenes en diferentes secciones de la aplicación Laravel + Vue.js.

## 🚀 Características

- ✅ Subida de imágenes con validación
- ✅ Vista previa antes de confirmar
- ✅ Actualización automática de la base de datos
- ✅ Componente reutilizable
- ✅ Soporte para múltiples secciones
- ✅ Mensajes de estado
- ✅ Validación de tipos y tamaños de archivo

## 📁 Estructura de Archivos

```
app/
├── Http/Controllers/
│   └── MediaController.php          # Controlador para manejar imágenes
├── Models/
│   └── Media.php                    # Modelo para la tabla media

resources/js/
├── Components/
│   ├── ImageUploader.vue           # Componente genérico para subir imágenes
│   ├── ApplicationMarkEdit.vue     # Componente específico para el logo
│   └── Work/
│       └── ProjectImageEditor.vue  # Componente para editar imágenes de proyectos

public/
└── images/                         # Imágenes estáticas y subidas
    ├── logo.svg
    ├── hero-bg.svg
    ├── project-1.svg
    ├── project-2.svg
    ├── project-3.svg
    ├── service-web.svg
    ├── service-mobile.svg
    ├── service-consulting.svg
    ├── about-team.svg
    ├── favicon.svg
    └── placeholder.svg
```

## 🛠️ Instalación y Configuración

### 1. Base de Datos

Las migraciones ya están creadas:
- `2025_07_20_014735_create_media_table.php`
- `2025_06_19_234724_create_work_contents_table.php`

### 2. Ejecutar Migraciones y Seeders

```bash
php artisan migrate
php artisan db:seed --class=WorkContentSeeder
```

### 3. Enlace Simbólico

```bash
php artisan storage:link
```

### 4. Rutas

Las rutas ya están configuradas en `routes/web.php`:

```php
Route::post('/api/media/upload', [MediaController::class, 'uploadImage'])->name('media.upload');
Route::delete('/api/media/delete', [MediaController::class, 'deleteImage'])->name('media.delete');
Route::get('/api/media/{section}', [MediaController::class, 'getSectionImages'])->name('media.getSection');
```

## 📖 Uso

### Componente ImageUploader (Genérico)

```vue
<template>
    <ImageUploader
        :current-image="imagenActual"
        section="hero"
        name="background"
        alt="Imagen de fondo"
        image-class="w-full h-64 object-cover"
        :button-text="'Cambiar imagen de fondo'"
        :show-edit-button="true"
        @image-updated="handleImageUpdated"
    />
</template>

<script setup>
import ImageUploader from '@/Components/ImageUploader.vue';

const handleImageUpdated = (data) => {
    console.log('Imagen actualizada:', data);
    // data contiene: { id, path, url }
};
</script>
```

### Props del Componente ImageUploader

| Prop | Tipo | Requerido | Descripción |
|------|------|-----------|-------------|
| `currentImage` | String | No | Ruta de la imagen actual |
| `section` | String | Sí | Sección de la aplicación |
| `name` | String | Sí | Nombre único de la imagen |
| `alt` | String | No | Texto alternativo |
| `imageClass` | String | No | Clases CSS para la imagen |
| `previewClass` | String | No | Clases CSS para la vista previa |
| `buttonText` | String | No | Texto del botón |
| `showEditButton` | Boolean | No | Mostrar botón de edición en hover |
| `maxSize` | Number | No | Tamaño máximo en MB (default: 5) |

### Componente ApplicationMarkEdit (Logo)

```vue
<template>
    <ApplicationMarkEdit @image-updated="handleLogoUpdated" />
</template>

<script setup>
import ApplicationMarkEdit from '@/Components/ApplicationMarkEdit.vue';

const handleLogoUpdated = (data) => {
    console.log('Logo actualizado:', data);
};
</script>
```

### Componente ProjectImageEditor (Proyectos)

```vue
<template>
    <ProjectImageEditor
        title="Mi Proyecto"
        section="project_1"
        name="main"
        :current-image="getMediaImage('project_1', 'main')"
        alt="Imagen del proyecto"
        @image-updated="handleImageUpdated"
    />
</template>

<script setup>
import ProjectImageEditor from '@/Components/Work/ProjectImageEditor.vue';

const getMediaImage = (section, name) => {
    const sectionMedia = media.value[section] || [];
    const image = sectionMedia.find(item => item.name === name);
    return image ? image.path : '';
};
</script>
```

## 🔧 API Endpoints

### Subir Imagen

```javascript
const formData = new FormData();
formData.append('image', file);
formData.append('section', 'hero');
formData.append('name', 'background');

const response = await axios.post('/api/media/upload', formData, {
    headers: {
        'Content-Type': 'multipart/form-data',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});
```

### Eliminar Imagen

```javascript
const response = await axios.delete('/api/media/delete', {
    data: {
        section: 'hero',
        name: 'background'
    }
});
```

### Obtener Imágenes de una Sección

```javascript
const response = await axios.get('/api/media/hero');
```

## 📊 Estructura de la Base de Datos

### Tabla `media`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int | ID único |
| `section` | string | Sección de la aplicación |
| `type` | string | Tipo de archivo |
| `name` | string | Nombre único |
| `path` | string | Ruta del archivo |
| `description` | string | Descripción |
| `order` | int | Orden de visualización |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de actualización |

### Tabla `work_contents`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int | ID único |
| `section` | string | Sección de la aplicación |
| `field_type` | string | Tipo de campo (text, image, link) |
| `field_name` | string | Nombre del campo |
| `content` | text | Contenido del campo |
| `order` | int | Orden de visualización |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de actualización |

## 🎨 Personalización

### Cambiar Colores

Los componentes usan clases de Tailwind CSS. Puedes personalizar los colores modificando las clases:

```vue
<!-- Cambiar color del botón -->
<ImageUploader
    button-class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
    ...
/>
```

### Agregar Validaciones

Puedes agregar validaciones personalizadas en el controlador:

```php
// En MediaController.php
$request->validate([
    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120|dimensions:min_width=100,min_height=100',
]);
```

### Cambiar Directorio de Almacenamiento

```php
// En MediaController.php
$path = $file->storeAs('custom-folder', $fileName, 'public');
```

## 🐛 Solución de Problemas

### Error: "Storage link already exists"

```bash
# Eliminar el enlace existente
rm public/storage

# Crear nuevo enlace
php artisan storage:link
```

### Error: "Permission denied"

```bash
# Dar permisos al directorio storage
chmod -R 775 storage
chmod -R 775 public/storage
```

### Error: "File too large"

Aumentar el límite en `php.ini`:

```ini
upload_max_filesize = 10M
post_max_size = 10M
```

Y en el controlador:

```php
$request->validate([
    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // 10MB
]);
```

## 📝 Notas Importantes

1. **CSRF Token**: Asegúrate de que el meta tag CSRF esté presente en tu layout
2. **Permisos**: El directorio `storage/app/public` debe ser escribible
3. **Validación**: Las imágenes se validan por tipo y tamaño
4. **Backup**: Considera hacer backup de las imágenes antes de actualizaciones
5. **Optimización**: Para producción, considera usar un CDN para las imágenes

## 🔄 Actualizaciones Futuras

- [ ] Soporte para múltiples formatos de imagen
- [ ] Redimensionamiento automático
- [ ] Compresión de imágenes
- [ ] Integración con CDN
- [ ] Galería de imágenes
- [ ] Drag & drop
- [ ] Vista previa en tiempo real 