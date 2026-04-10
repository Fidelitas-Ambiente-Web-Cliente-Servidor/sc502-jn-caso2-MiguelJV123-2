<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Solicitudes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="public/js/solicitud.js"></script>
</head>

<body class="container mt-5">

<nav class="d-flex justify-content-between mb-4">
    <div>
        <a href="index.php?page=talleres" class="me-3">Talleres</a>
        <a href="index.php?page=admin">Gestionar Solicitudes</a>
    </div>

    <div>
        <span class="me-3">Admin: <?= htmlspecialchars($_SESSION['username'] ?? 'admin') ?></span>
        <button id="btnLogout" class="btn btn-danger btn-sm">Cerrar sesión</button>
    </div>
</nav>

<main>
    <h2>Solicitudes pendientes</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Taller</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="solicitudes-body">
            <tr>
                <td colspan="5">Cargando solicitudes...</td>
            </tr>
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