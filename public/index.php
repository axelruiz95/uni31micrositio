<?php
// public/index.php
session_start();
// Generar token CSRF simple
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['csrf_token'];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Unidad 3</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="header">
    <div class="container">
      <h1>Mi sitio Inicial</h1>
      <p>Diseño, desarrollo e integración de aplicaciones web</p>
    </div>
  </header>

  <main class="container">
    <section class="card">
      <h2>Formulario de contacto</h2>
      <p>Completa los campos y presiona <strong>Enviar</strong>. Tus datos se guardarán en la tabla <code>Clientes</code>.</p>

      <?php if (!empty($_GET['err'])): ?>
        <div class="alert error"><?php echo htmlspecialchars($_GET['err']); ?></div>
      <?php elseif (!empty($_GET['ok'])): ?>
        <div class="alert success">¡Gracias! Guardamos tu información correctamente.</div>
      <?php endif; ?>

      <form action="guardar_cliente.php" method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

        <div class="grid">
          <div class="form-control">
            <label for="nombre">Nombre del cliente</label>
            <input id="nombre" name="nombre" type="text" maxlength="120" required placeholder="Ej. Juan Pérez">
          </div>

          <div class="form-control">
            <label for="domicilio">Domicilio</label>
            <input id="domicilio" name="domicilio" type="text" maxlength="255" required placeholder="Calle, número, colonia, ciudad">
          </div>

          <div class="form-control">
            <label for="telefono">Teléfono</label>
            <input id="telefono" name="telefono" type="tel" maxlength="30" required placeholder="+52 55 1234 5678">
          </div>

          <div class="form-control">
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" maxlength="180" required placeholder="correo@dominio.com">
          </div>

          <div class="form-control full">
            <label for="comentarios">Comentarios</label>
            <textarea id="comentarios" name="comentarios" rows="5" placeholder="Escribe tu mensaje..."></textarea>
          </div>
        </div>

        <button class="btn" type="submit">Enviar</button>
      </form>
    </section>

    <section class="card muted">
      <h3>Acerca del micro sitio</h3>
      <p>Este micro sitio fue creado como práctica para conectar PHP con MySQL usando <em>PDO</em> y consultas preparadas.</p>
      <div class="embed">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Video de ejemplo" frameborder="0" allowfullscreen></iframe>
      </div>
    </section>

    <section class="card">
      <h3>Vista administrativa</h3>
      <p>Para revisar los registros almacenados, ingresa a <a href="lista_clientes.php">lista_clientes.php</a>.</p>
    </section>
  </main>

  <footer class="footer">
    <div class="container">
      <small>&copy; <?php echo date('Y'); ?> Micro sitio PHP + MySQL — Hecho para fines académicos.</small>
    </div>
  </footer>

  <script>
  // Validación básica en cliente (adicional a validación del servidor)
  document.querySelector('form').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const tel = document.getElementById('telefono').value.trim();
    const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    const telOk = /^[+\d][\d\s\-()]{6,}$/.test(tel);
    if (!emailOk) { e.preventDefault(); alert('Por favor escribe un email válido.'); }
    if (!telOk)   { e.preventDefault(); alert('Por favor escribe un teléfono válido.'); }
  });
  </script>
</body>
</html>
