<?php

class Invitados {
    private $filePath = 'invitados.json'; // Ruta al archivo JSON

    // Leer el archivo JSON
    private function leerArchivo() {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $jsonData = file_get_contents($this->filePath);
        $data = json_decode($jsonData, true);
        return $data['personas'] ?? [];
    }

    // Buscar un nombre en la lista de invitados
    public function buscarNombre($nombre) {
        $personas = $this->leerArchivo();
        return in_array(urldecode($nombre), $personas);
    }
}

