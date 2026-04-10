<?php
class Solicitud
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function crear($tallerId, $usuarioId)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO solicitudes (taller_id, usuario_id, estado)
             VALUES (?, ?, 'pendiente')"
        );

        $stmt->bind_param("ii", $tallerId, $usuarioId);

        return $stmt->execute();
    }

    public function aprobar($solicitudId)
    {

        $stmt = $this->conn->prepare(
            "SELECT taller_id FROM solicitudes WHERE id = ?"
        );
        $stmt->bind_param("i", $solicitudId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if (!$data) {
            return false;
        }

        $tallerId = $data['taller_id'];

        
        $stmt = $this->conn->prepare(
            "UPDATE solicitudes SET estado = 'aprobada' WHERE id = ?"
        );
        $stmt->bind_param("i", $solicitudId);
        $ok1 = $stmt->execute();

       
        $stmt = $this->conn->prepare(
            "UPDATE talleres SET cupo_disponible = cupo_disponible - 1 WHERE id = ? AND cupo_disponible > 0"
        );
        $stmt->bind_param("i", $tallerId);
        $ok2 = $stmt->execute();

        return $ok1 && $ok2;
    }

    public function rechazar($solicitudId)
    {
        $stmt = $this->conn->prepare(
            "UPDATE solicitudes SET estado = 'rechazada' WHERE id = ?"
        );
        $stmt->bind_param("i", $solicitudId);

        return $stmt->execute();
    }


   public function getAll()
{
    $sql = "
        SELECT 
            s.id,
            t.nombre AS taller,
            u.username AS usuario,
            s.fecha_solicitud,
            s.estado
        FROM solicitudes s
        INNER JOIN talleres t ON s.taller_id = t.id
        INNER JOIN usuarios u ON s.usuario_id = u.id
        WHERE s.estado = 'pendiente'  -- 🔥 CLAVE
        ORDER BY s.fecha_solicitud DESC
    ";

    $result = $this->conn->query($sql);

    $solicitudes = [];

    while ($row = $result->fetch_assoc()) {
        $solicitudes[] = $row;
    }

    return $solicitudes;
}

}