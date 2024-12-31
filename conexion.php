<?php

class Conexion {
    private $filePath = 'datos.json'; // Ruta al archivo JSON

    public function leerDatos() {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $jsonData = file_get_contents($this->filePath);
        return json_decode($jsonData, true) ?? [];
    }

    public function guardarDatos($data) {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($this->filePath, $jsonData);
    }

    public function islogged($idSession) {
        $data = $this->leerDatos(); // Cargar todos los registros
        foreach ($data as $registro) {
            if (isset($registro['id_session']) && $registro['id_session'] === $idSession) {
                return $registro; // Devolver el registro encontrado
            }
        }
        return null; // Si no se encuentra, devolver null
    }
    public function buscar($param, $valor) {
        $data = $this->leerDatos(); // Cargar todos los registros
        foreach ($data as $registro) {
            if (isset($registro[$param]) && $registro[$param] === $valor) {
                return $registro; // Devolver el registro encontrado
            }
        }
        return null; // Si no se encuentra, devolver null
    }
}
?>
