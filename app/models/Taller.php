<?php
class Taller
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM talleres ORDER BY nombre");

        $talleres = [];

        while ($row = $result->fetch_assoc()) {
            $talleres[] = $row;
        }

        return $talleres;
    }

    public function getAllDisponibles()
    {
        // 🔥 CAMBIO CLAVE: quitar filtro de cupo
        $sql = "SELECT * FROM talleres ORDER BY nombre";

        $result = $this->conn->query($sql);

        $talleres = [];

        while ($row = $result->fetch_assoc()) {
            $talleres[] = $row;
        }

        return $talleres;
    }

    public function getById($id)
    {
        // no necesario por ahora
    }

    public function descontarCupo($tallerId)
    {
        // no necesario porque ya lo haces en Solicitud.php
    }

    public function sumarCupo($tallerId)
    {
        // no necesario por ahora
    }
}