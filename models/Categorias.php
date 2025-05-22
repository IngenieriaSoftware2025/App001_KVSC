<?php

namespace Model;

class Categoria extends ActiveRecord {

    public static $tabla = 'categoria';
    public static $columnasDB = [
        'categoria_nombre'
    ];

    public static $idTabla = 'categoria_id';
    public $categoria_id;
    public $categoria_nombre;

    public function __construct($args = []){
        $this->categoria_id = $args['categoria_id'] ?? null;
        $this->categoria_nombre = $args['categoria_nombre'] ?? '';
    }
}