# Adocreto

Sistema de gestión para Adocreto construido con Laravel y Filament.

## Requisitos del Sistema

- PHP >= 8.2
- Composer
- Node.js >= 18
- NPM
- Base de datos SQLite (o MySQL/PostgreSQL)
- Extensión PHP para SQLite (si se usa SQLite)

## Dependencias Principales

- Laravel Framework ^12.0
- Filament ^3.3
- Laravel DomPDF ^3.1
- Spatie Media Library
- Filament Price Filter
- Filament Simple Alert
- Filament Date Range Picker Filter

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/jimmiroblescasanova/adocreto.git
cd adocreto
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Instalar dependencias de Node.js:
```bash
npm install
```

4. Configurar el entorno:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configurar la base de datos en el archivo `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

6. Crear la base de datos SQLite:
```bash
touch database/database.sqlite
```

7. Ejecutar migraciones:
```bash
php artisan migrate
```

8. Compilar assets:
```bash
npm run build
```

9. Iniciar el servidor de desarrollo:
```bash
php artisan serve
```

## Comandos Útiles

Para desarrollo:
```bash
composer dev
```
Este comando inicia:
- Servidor de desarrollo
- Cola de trabajos
- Registro de logs
- Servidor Vite

## Estructura del Proyecto

- `app/` - Código fuente de la aplicación
- `config/` - Archivos de configuración
- `database/` - Migraciones y seeders
- `resources/` - Vistas, assets y archivos de idioma
- `routes/` - Definición de rutas
- `tests/` - Pruebas automatizadas

## Características Principales

- Panel de administración con Filament
- Generación de PDFs
- Gestión de medios
- Filtros avanzados
- Alertas personalizadas
- Selector de rangos de fechas

## Licencia

Este proyecto está bajo la licencia [MIT](LICENSE.md).
