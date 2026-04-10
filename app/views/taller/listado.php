<!DOCTYPE html>
<html>

<head>
    <title>Listado Talleres</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JS CORRECTO (ruta desde navegador) -->
    <script src="public/js/taller.js"></script>
</head>

<body class="container mt-5">

<nav class="d-flex justify-content-between mb-4">
    <div>
        <a href="index.php?page=talleres" class="me-3">Talleres</a>
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
            <a href="index.php?page=admin">Gestionar Solicitudes</a>
        <?php endif; ?>
    </div>

    <div>
        <span class="me-3"><?= htmlspecialchars($_SESSION['username'] ?? 'Usuario') ?></span>
        <button id="btnLogout" class="btn btn-danger btn-sm">Cerrar sesión</button>
    </div>
</nav>

<main>
    <h3>Talleres</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cupo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="talleres-body">
        </tbody>
    </table>
</main>

<script>
$(document).on("click", "#btnLogout", function () {
    $.post("index.php", { option: "logout" }, function () {
        window.location.href = "index.php?page=login";
    });
});
</script>

</body>
</html>