<?php
// public/lista_clientes.php
require_once __DIR__ . '/../db_config.php';

$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$pdo = get_pdo();
$total = (int)$pdo->query('SELECT COUNT(*) FROM Clientes')->fetchColumn();

$stmt = $pdo->prepare('SELECT * FROM Clientes ORDER BY created_at DESC, id DESC LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

$pages = max(1, (int)ceil($total / $perPage));
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Clientes</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <main class="container">
    <section class="card">
      <h2>Registros en tabla <code>Clientes</code></h2>
      <p>Total: <?php echo $total; ?></p>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>ID</th><th>Nombre</th><th>Domicilio</th><th>Teléfono</th><th>Email</th><th>Comentarios</th><th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td><?php echo (int)$r['id']; ?></td>
                <td><?php echo htmlspecialchars($r['nombre']); ?></td>
                <td><?php echo htmlspecialchars($r['domicilio']); ?></td>
                <td><?php echo htmlspecialchars($r['telefono']); ?></td>
                <td><?php echo htmlspecialchars($r['email']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($r['comentarios'])); ?></td>
                <td><?php echo htmlspecialchars($r['created_at']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="pagination">
        <?php for ($i=1; $i <= $pages; $i++): ?>
          <a class="page <?php echo $i === $page ? 'active' : '' ?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
      </div>

      <p><a class="btn" href="index.php">Volver</a></p>
    </section>
  </main>
</body>
</html>
