# Sistema POS - Pizza Zuñiga

Sistema de punto de venta para gestión de pedidos, mesas y cocina, desarrollado en Laravel + Livewire.

## Tecnologías utilizadas

- Laravel 12
- PHP 8.2+
- Livewire
- Tailwind CSS
- MySQL
- Vite

---

## Requisitos previos (instalar antes de clonar el proyecto)

### 1. XAMPP (incluye PHP y MySQL)

Descarga e instala XAMPP desde: https://www.apachefriends.org/

Durante la instalación, asegúrate de marcar los componentes **Apache** y **MySQL**.

Verifica que PHP esté en tu PATH abriendo una terminal (PowerShell) y ejecutando:
```bash
php -v
```
Debe mostrarte la versión de PHP (necesitas 8.2 o superior). Si no reconoce el comando, agrega la carpeta `C:\xampp\php` a las variables de entorno de Windows (Panel de Control → Sistema → Configuración avanzada → Variables de entorno → Path → Agregar `C:\xampp\php`).

### 2. Composer (gestor de dependencias de PHP)

Descarga el instalador desde: https://getcomposer.org/download/

Ejecuta el instalador `Composer-Setup.exe` y sigue los pasos (va a detectar automáticamente tu instalación de PHP en XAMPP).

Verifica la instalación:
```bash
composer -v
```

### 3. Node.js y NPM

Descarga la versión LTS desde: https://nodejs.org/

Verifica la instalación:
```bash
node -v
npm -v
```

### 4. Git

Descarga desde: https://git-scm.com/download/win

Verifica:
```bash
git -v
```

---

## Instalación del proyecto

### 1. Clonar el repositorio

Abre PowerShell y ve a la carpeta de XAMPP donde guardas tus proyectos:

```bash
cd C:\xampp\htdocs
git clone https://github.com/eduardoapsti20-collab/sistema-pizzeria-laravel.git
cd sistema-pizzeria-laravel
```

### 2. Instalar las dependencias de PHP (Laravel y librerías)

```bash
composer install
```

Esto puede tardar unos minutos la primera vez.

### 3. Instalar las dependencias de JavaScript

```bash
npm install
```

### 4. Configurar el archivo de entorno

Copia el archivo de ejemplo:

```bash
copy .env.example .env
```

Abre el archivo `.env` con un editor de texto (VS Code, Notepad++, etc.) y configura los datos de tu base de datos:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restaurante
DB_USERNAME=root
DB_PASSWORD=

```

(Ajusta `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` según tu configuración local de MySQL/XAMPP)

### 5. Crear la base de datos

Abre **phpMyAdmin** (`http://localhost/phpmyadmin`) y crea una base de datos nueva llamada `restaurante` (o el nombre que pusiste en `DB_DATABASE`).

Puedes importar los datos de ejemplo desde la carpeta `sql restaurante/restaurante.sql` usando la pestaña "Importar" de phpMyAdmin.

### 6. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 7. Ejecutar las migraciones

Si ya importaste el `.sql`, puedes saltarte este paso. Si prefieres partir desde cero:

```bash
php artisan migrate --seed
```

### 8. Compilar los assets (CSS y JS)

Para desarrollo (con recarga automática):
```bash
npm run dev
```

Déjalo corriendo en una terminal aparte, y abre una segunda terminal para el siguiente paso.

### 9. Iniciar el servidor de Laravel

```bash
php artisan serve
```

### 10. Abrir el proyecto

Ve a tu navegador y entra a:
```

http://localhost:8000

```

---

## Notas

- El archivo `.env` **no se sube a GitHub** por seguridad (contiene credenciales). Cada persona que clone el proyecto debe crear el suyo siguiendo el paso 4.
- Si tienes errores de permisos en las carpetas `storage` o `bootstrap/cache`, ejecuta:
```bash
php artisan storage:link
```
```
