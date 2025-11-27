<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# EDUKA

## Clonar el repositorio y configurar Git 

1. Clonar el repositorio (HTTPS):
```bash
git clone https://github.com/marck-h-cmd/Eduka.git
```


2. Entrar al directorio del proyecto:
```bash
cd Eduka
```

3. Configurar tu nombre y correo:
```bash

git config user.name "Tu Nombre"
git config user.email "tu@correo.com"
```

## Guía de Configuración de la Aplicación

## Instalación

### Instalar paquetes de Node

```bash
npm install
```

### Instalar dependencias de Composer

```bash
composer install
```

### Pasos Básicos

1. **Importar el archivo `.env`**:
   O sino copiar el archivo .env.example desde powersheel (solo realizar si es que quieres empezar tu propio .env con credenciales propias)
   ```bash
   cp .env.example .env
   ```

2. **Carga la base de datos mysql en Wamp/XAMP, etc**:


3. **Configurar base de datos**:
   - Editar el archivo `.env` y configurar las variables de conexión a la base de datos:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_base_datos
   DB_USERNAME=usuario
   DB_PASSWORD=contraseña
   ```

### Linkear el Storage

```bash
php artisan storage:link
```


### Ejecutar la Aplicación

```bash
php artisan serve
```

