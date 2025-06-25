# Sistema de Media para Proyectos

## 📋 Descripción

Este sistema permite gestionar imágenes y videos para cada proyecto de manera individual, guardando en la base de datos el nombre, ruta y metadatos de cada archivo.

## 🗄️ Estructura de la Base de Datos

### Tabla `media`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int | ID único |
| `section` | string | Sección del proyecto (project_1, project_2, etc.) |
| `type` | string | Tipo de archivo (image, video) |
| `name` | string | Nombre del archivo (image_1, video_1, etc.) |
| `path` | string | Ruta del archivo en storage |
| `description` | string | Descripción del archivo |
| `order` | int | Orden de visualización |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de actualización |

## 🔧 API Endpoints

### Subir Imagen
```http
POST /api/media/upload
Content-Type: multipart/form-data

{
    "image": [archivo],
    "section": "project_1",
    "name": "image_1"
}
```

### Subir Video
```http
POST /api/media/upload-video
Content-Type: multipart/form-data

{
    "video": [archivo],
    "section": "project_1",
    "name": "video_1"
}
```

### Obtener Archivos de un Proyecto
```http
GET /api/media/project/{section}
```

### Obtener Todas las Imágenes de una Sección
```http
GET /api/media/images/{section}
```

### Obtener Todos los Videos de una Sección
```http
GET /api/media/videos/{section}
```

### Eliminar Archivo
```http
DELETE /api/media/{id}
```

## 📁 Estructura de Archivos

Los archivos se guardan en:
- **Imágenes**: `storage/app/public/images/work/`
- **Videos**: `storage/app/public/videos/`

## 🎯 Convención de Nombres

### Para Imágenes
- `image_1`, `image_2`, `image_3`, etc.
- Se ordenan automáticamente por número

### Para Videos
- `video_1`, `video_2`, `video_3`, etc.
- Se ordenan automáticamente por número

## 🔄 Flujo de Funcionamiento

1. **Carga inicial**: Se cargan imágenes de placeholder si no hay archivos en la BD
2. **API check**: Se verifica si hay archivos en la tabla `media`
3. **Ordenamiento**: Los archivos se ordenan por nombre (image_1, image_2, etc.)
4. **Edición**: Al activar modo edición, se puede subir nuevos archivos
5. **Guardado**: Los archivos se guardan en storage y en la BD

## 💾 Ejemplo de Datos en la Base de Datos

```sql
INSERT INTO media (section, type, name, path, description, order) VALUES
('project_1', 'image', 'image_1', 'images/work/swish-fibre/1.png', 'SWISH FIBRE - Imagen 1', 1),
('project_1', 'image', 'image_2', 'images/work/swish-fibre/2.png', 'SWISH FIBRE - Imagen 2', 2),
('project_1', 'video', 'video_1', 'videos/work/swish-fibre/1.mp4', 'SWISH FIBRE - Video 1', 3);
```

## 🎨 Uso en el Frontend

### Componente ProjectImage
```vue
<ProjectImage
    :project-id="project_1"
    :image-index="0"
    :current-image="imageData"
    :is-editing="isEditing"
    @image-updated="handleImageUpdated"
/>
```

### Manejo de Eventos
```javascript
const handleImageUpdated = (data) => {
    // data contiene: id, path, url, name, type
    console.log('Archivo actualizado:', data);
};
```

## 🚀 Características

- ✅ **Múltiples archivos por proyecto**
- ✅ **Ordenamiento automático**
- ✅ **Soporte para imágenes y videos**
- ✅ **Fallback a imágenes de placeholder**
- ✅ **Guardado en base de datos**
- ✅ **Eliminación de archivos**
- ✅ **Validación de tipos de archivo**
- ✅ **Límites de tamaño configurados**

## 📝 Notas Importantes

1. **Enlace simbólico**: Asegúrate de que `php artisan storage:link` esté ejecutado
2. **Permisos**: Los directorios de storage deben tener permisos de escritura
3. **Tamaños máximos**: 
   - Imágenes: 10MB
   - Videos: 100MB
4. **Formatos soportados**:
   - Imágenes: jpeg, png, jpg, gif, webp, svg
   - Videos: mp4, webm, ogg, avi, mov, wmv 