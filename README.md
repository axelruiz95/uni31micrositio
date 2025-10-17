# Micro sitio PHP + MySQL (Formulario de Contáctame)

**Objetivo:** Desarrollar un micro sitio con un formulario que guarda registros en la tabla `Clientes` de MySQL usando PHP (PDO).

## Estructura
```
micrositio_php_mysql/
├─ database.sql
├─ db_config.php
└─ public/
   ├─ index.php
   ├─ guardar_cliente.php
   ├─ gracias.php
   ├─ lista_clientes.php
   └─ assets/
      └─ style.css
```

## Requisitos
- PHP 8.x (o 7.4+)
- Servidor web (Apache recomendado con `mod_php`) o PHP embebido: `php -S localhost:8000 -t public`
- MySQL 5.7+/MariaDB 10.4+

## Pasos de instalación
1. Cree la BD y la tabla ejecutando `database.sql` en su servidor MySQL:
   ```sql
-- database.sql
-- Cree primero la base de datos (ajuste el nombre si lo desea)
CREATE DATABASE IF NOT EXISTS micrositio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE micrositio_db;

-- Tabla 'Clientes'
CREATE TABLE IF NOT EXISTS Clientes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  domicilio VARCHAR(255) NOT NULL,
  telefono VARCHAR(30) NOT NULL,
  email VARCHAR(180) NOT NULL,
  comentarios TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

   ```
2. Edite `db_config.php` con sus credenciales (`DB_USER`, `DB_PASS`, etc.).
3. Inicie el servidor:
   - Con PHP embebido (rápido para pruebas):
     ```bash
     php -S localhost:8000 -t public
     ```
   - O configure Apache/Nginx apuntando el DocumentRoot a la carpeta `public/`.
4. Abra `http://localhost:8000` en su navegador.
5. Envíe el formulario y verifique:
   - Mensaje de éxito.
   - Registro visible en `public/lista_clientes.php`.

## Seguridad y buenas prácticas
- Se utilizan **consultas preparadas (PDO)** y un **token CSRF** básico.
- Valide también en el servidor (ya incluido) y no dependa del JS.
- Para producción, mueva `db_config.php` fuera del webroot y restrinja permisos.
- **Nunca** suba `db_config.php` a repositorios públicos con credenciales reales.

## Créditos
Hecho con fines académicos — 2025-10-17
