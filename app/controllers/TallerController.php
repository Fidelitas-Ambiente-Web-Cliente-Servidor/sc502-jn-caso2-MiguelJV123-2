<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Taller.php';
require_once __DIR__ . '/../models/Solicitud.php';

class TallerController
{
    private $tallerModel;
    private $solicitudModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        if (!$db) {
            die("Error: No se pudo conectar a la base de datos");
        }

        $this->tallerModel = new Taller($db);
        $this->solicitudModel = new Solicitud($db);
    }

    public function index()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?page=login');
            return;
        }

        require __DIR__ . '/../views/taller/listado.php';
    }

    public function getTalleresJson()
    {
        // LIMPIAR cualquier salida previa (LA CLAVE)
        if (ob_get_length()) ob_clean();

        header('Content-Type: application/json');

        if (!isset($_SESSION['id'])) {
            echo json_encode([]);
            exit;
        }

        $talleres = $this->tallerModel->getAllDisponibles();

        echo json_encode($talleres);
        exit;
    }

    public function solicitar()
{
    if (ob_get_length()) ob_clean();
    header('Content-Type: application/json');

    if (!isset($_SESSION['id'])) {
        echo json_encode([
            'success' => false,
            'error' => 'Debes iniciar sesión'
        ]);
        exit;
    }

    $tallerId = $_POST['taller_id'] ?? 0;
    $usuarioId = $_SESSION['id'];

    if ($tallerId <= 0) {
        echo json_encode([
            'success' => false,
            'error' => 'Taller inválido'
        ]);
        exit;
    }

    try {
        $resultado = $this->solicitudModel->crear($tallerId, $usuarioId);

        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'No se pudo crear la solicitud'
            ]);
        }

    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }

    exit;
}
}