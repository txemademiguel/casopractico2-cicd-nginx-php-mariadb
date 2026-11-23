<?php
// ==============================================================================
// ARCHIVO: src/index.php
// Página principal con conexión PDO, inicialización de datos y consulta de productos
// ==============================================================================

$error = null;
$version = null;
$productos = [];

try {
    // Incluir la conexión PDO creada en db.php
    $pdo = require_once __DIR__ . '/db.php';
    
    // Obtener la versión de MariaDB
    $stmtVersion = $pdo->query("SELECT VERSION() as version");
    $rowVersion = $stmtVersion->fetch();
    $version = $rowVersion['version'];

    // Crear la tabla de productos si no existe (autocontenida para pruebas)
    $pdo->exec("CREATE TABLE IF NOT EXISTS productos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        precio DECIMAL(10, 2) NOT NULL,
        stock INT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Insertar datos de ejemplo si la tabla está vacía
    $checkCount = $pdo->query("SELECT COUNT(*) FROM productos")->fetchColumn();
    if ($checkCount == 0) {
        $pdo->exec("INSERT INTO productos (nombre, precio, stock) VALUES
            ('Servidor Web Nginx VPS', 15.50, 20),
            ('Licencia PHP Enterprise', 49.99, 10),
            ('Base de Datos MariaDB Cluster', 89.00, 5),
            ('Certificado SSL Wildcard', 12.00, 50);");
    }

    // Consultar todos los productos
    $stmtProductos = $pdo->query("SELECT id, nombre, precio, stock FROM productos ORDER BY id ASC");
    $productos = $stmtProductos->fetchAll();

} catch (PDOException $e) {
    // Captura de errores PDO
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DAW - Catálogo de Productos (Nginx + PHP + MariaDB)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            color: #0056b3;
            margin-top: 0;
        }
        .status-ok {
            background-color: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
            margin-bottom: 20px;
        }
        .status-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px 16px;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #0056b3;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .price {
            font-weight: bold;
            color: #28a745;
        }
        .badge {
            background-color: #17a2b8;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.85em;
        }
        code {
            background-color: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            display: block;
            margin-top: 10px;
            white-space: pre-wrap;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛒 Catálogo de Productos Marketplace DAW</h1>
        
        <?php if ($error): ?>
            <div class="status-error">
                <strong>Error de conexión a MariaDB:</strong>
                <code><?php echo htmlspecialchars($error); ?></code>
            </div>
        <?php else: ?>
            <div class="status-ok">
                ✔ <strong>Conexión exitosa a la Base de Datos MariaDB.</strong><br>
                <small>Versión del SGBD: <?php echo htmlspecialchars($version); ?></small>
            </div>
            <h1>Modidicado por Txema</h1>
            <h2>Listado de Productos Registrados</h2>
            
            <?php if (count($productos) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto / Servicio</th>
                            <th>Precio</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['id']); ?></td>
                                <td><strong><?php echo htmlspecialchars($producto['nombre']); ?></strong></td>
                                <td class="price"><?php echo number_format($producto['precio'], 2, ',', '.'); ?> €</td>
                                <td><span class="badge"><?php echo htmlspecialchars($producto['stock']); ?> ud.</span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay productos registrados en la base de datos.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
