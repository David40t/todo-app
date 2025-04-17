# Todo App - PHP POO

Una aplicación segura para gestionar tareas, desarrollada con PHP utilizando Programación Orientada a Objetos, tipado fuerte y medidas de seguridad avanzadas.

## Características

- Sistema de autenticación seguro (registro e inicio de sesión)
- Gestión completa de tareas (crear, leer, actualizar, eliminar)
- Diseño responsivo con Tailwind CSS
- Código con tipado fuerte para mayor robustez y claridad
- Variables de entorno para configuración segura
- Protección contra vulnerabilidades web comunes:
  - Inyección SQL (mediante PDO y consultas preparadas)
  - Cross-Site Scripting (XSS)
  - Cross-Site Request Forgery (CSRF)
  - Session Hijacking
  - Ataques de fuerza bruta
- Estructura de código modular y mantenible

## Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache, Nginx, etc.)
- Composer (para autoloading)

## Instalación

1. **Clonar el repositorio:**

```bash
git clone https://github.com/tu-usuario/todo-app.git
cd todo-app
```

2. **Instalar dependencias:**

```bash
composer install
```

3. **Configurar las variables de entorno:**

```bash
# Copiar el archivo de ejemplo
cp .env.example .env

# Generar claves seguras
php generate-keys.php

# Editar el archivo .env con las claves generadas y configurar la base de datos
```

4. **Configurar la base de datos:**

- Crear una base de datos MySQL
- Importar el archivo `database/schema.sql` para crear las tablas necesarias
- Verificar que las credenciales en el archivo `.env` son correctas:

```
DB_HOST=127.0.0.1
DB_NAME=todo_app
DB_USER=root
DB_PASS=tu_contraseña
```

5. **Configurar el servidor web:**

- Apuntar el directorio raíz del servidor web a la carpeta `public` de la aplicación
- Asegurarse de que el módulo `mod_rewrite` esté habilitado en Apache
- Configurar los permisos adecuados en los directorios

## Estructura del Proyecto

```
todo-app/
├── database/
│   └── schema.sql            # Esquema de la base de datos
├── public/
│   ├── css/                  # Archivos CSS
│   ├── js/                   # Archivos JavaScript
│   ├── img/                  # Imágenes
│   ├── .htaccess             # Configuración de Apache
│   └── index.php             # Punto de entrada
├── src/
│   ├── config/
│   │   └── Database.php      # Configuración de la base de datos
│   ├── controllers/
│   │   ├── AuthController.php   # Controlador de autenticación
│   │   └── TaskController.php   # Controlador de tareas
│   ├── models/
│   │   ├── User.php          # Modelo de usuario
│   │   └── Task.php          # Modelo de tarea
│   ├── routes/
│   │   ├── Router.php        # Clase de enrutamiento
│   │   └── routes.php        # Definición de rutas
│   ├── utils/
│   │   └── Security.php      # Utilidades de seguridad
│   └── views/                # Vistas
│       ├── auth/
│       ├── errors/
│       ├── layout/
│       └── tasks/
├── vendor/                   # Dependencias (generado por Composer)
├── .env                      # Variables de entorno (no incluido en repositorio)
├── .env.example              # Ejemplo de variables de entorno
├── composer.json             # Configuración de Composer
├── generate-keys.php         # Script para generar claves seguras
└── README.md                 # Documentación
```

## Uso

1. Navega a la URL de la aplicación en tu navegador
2. Regístrate como nuevo usuario
3. Inicia sesión con tus credenciales
4. Comienza a crear y gestionar tus tareas

## Variables de Entorno

La aplicación utiliza un archivo `.env` para la configuración sensible:

```
# Configuración de la Base de Datos
DB_HOST=127.0.0.1        # Host de la base de datos
DB_NAME=todo_app         # Nombre de la base de datos
DB_USER=root             # Usuario de la base de datos
DB_PASS=                 # Contraseña de la base de datos

# Configuración de la Aplicación
APP_ENV=development      # Entorno (development o production)
APP_DEBUG=true           # Mostrar errores detallados
APP_URL=http://localhost:8000  # URL base de la aplicación

# Configuración de Seguridad
APP_KEY=...              # Clave para encriptación (generada con generate-keys.php)
JWT_SECRET=...           # Clave para tokens JWT (generada con generate-keys.php)
SESSION_SECURE=false     # Usar cookies seguras (recomendado true en producción)
SESSION_HTTP_ONLY=true   # Usar cookies HTTP-only
```

Para generar claves seguras:
```bash
php generate-keys.php
```

## Seguridad

Esta aplicación implementa varias medidas de seguridad:

- **Protección contra XSS**: Todos los datos de entrada y salida son sanitizados
- **Protección contra CSRF**: Tokens de seguridad en todos los formularios
- **Seguridad de contraseñas**: Uso de algoritmos de hashing seguros (Argon2id)
- **Consultas preparadas**: Prevención de inyección SQL
- **Cabeceras de seguridad HTTP**: Protección adicional del navegador
- **Gestión segura de sesiones**: Prevención de session fixation y hijacking
- **Variables de entorno**: Configuración sensible separada del código

## Contribuciones

Las contribuciones son bienvenidas. Por favor, sigue estos pasos:

1. Haz un fork del repositorio
2. Crea una nueva rama (`git checkout -b feature/nombre-caracteristica`)
3. Realiza tus cambios y haz commit (`git commit -am 'Añade nueva característica'`)
4. Sube los cambios (`git push origin feature/nombre-caracteristica`)
5. Abre un Pull Request 