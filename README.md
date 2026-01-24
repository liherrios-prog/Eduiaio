# EDUIAIO - Plataforma Educativa

Sistema de gestión de cursos educativos desarrollado en PHP con MySQL.

## 📋 Descripción

EDUIAIO es una plataforma web para la gestión de cursos online. Incluye:

- ✅ Sistema de autenticación (login/logout)
- ✅ Panel de administración
- ✅ CRUD completo de cursos
- ✅ Categorías con relaciones (Foreign Keys)
- ✅ Trigger de auditoría para cambios de precio
- ✅ Diseño moderno y responsive

## 🛠️ Requisitos Previos

- **XAMPP** (o similar) con:
  - PHP 7.4 o superior
  - MySQL 5.7 o superior
  - Apache

## 📁 Estructura del Proyecto

```
eduiaio/
├── configuracion/          # Configuración de la aplicación
│   └── conexion.php        # Conexión a la base de datos
├── operaciones/            # Operaciones CRUD
│   ├── listar.php          # Listado de cursos
│   ├── crear.php           # Crear nuevo curso
│   ├── editar.php          # Editar curso existente
│   └── eliminar.php        # Eliminar curso
├── recursos/               # Recursos estáticos
│   └── estilos/
│       └── estilos.css     # Estilos CSS
├── base_de_datos/          # Scripts de base de datos
│   └── eduiaio.sql         # Script de creación de BD
├── docs/                   # Documentación del proyecto
├── index.php               # Punto de entrada
├── iniciar_sesion.php      # Página de login
├── cerrar_sesion.php       # Cierre de sesión
└── panel.php               # Dashboard principal
```

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/eduiaio.git
```

### 2. Mover a la carpeta de XAMPP

Copia la carpeta `eduiaio` a `C:\xampp\htdocs\` (Windows) o `/opt/lampp/htdocs/` (Linux).

### 3. Crear la base de datos

1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Importa el archivo `base_de_datos/eduiaio.sql`
3. O ejecuta el script manualmente en MySQL

### 4. Configurar la conexión (opcional)

Si tu configuración de MySQL es diferente, edita `configuracion/conexion.php`:

```php
$servidor = 'localhost';
$nombre_bd = 'eduiaio';
$usuario = 'root';
$contrasena = ''; // Tu contraseña aquí
```

### 5. Acceder a la aplicación

Abre en tu navegador: `http://localhost/eduiaio`

## 🔐 Credenciales de Prueba

| Campo | Valor |
|-------|-------|
| Email | admin@eduiaio.com |
| Contraseña | password |

## 🗄️ Base de Datos

### Tablas

- **users**: Usuarios del sistema
- **categories**: Categorías de cursos (FK)
- **courses**: Cursos (entidad principal)
- **audit_logs**: Registro de auditoría (llenada por trigger)

### Trigger

El trigger `after_course_update` registra automáticamente los cambios de precio en la tabla de auditoría.

## 🎨 Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3
- **Fuente**: Inter (Google Fonts)

## 📝 Licencia

Este proyecto es de uso educativo.

---

Desarrollado para el curso de Desarrollo de Aplicaciones Web 🎓
