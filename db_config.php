<?php
// db_config.php
// Ajuste estos valores a su entorno local o servidor
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'micrositio_db');
define('DB_USER', 'axel');
define('DB_PASS', 'Axel1234');
define('DB_CHARSET', 'utf8mb4');

function get_pdo() {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    return new PDO($dsn, DB_USER, DB_PASS, $options);
}
