<?php
namespace Model;

class Prioridad extends ActiveRecord {
    public static $tabla = 'prioridad';
    public static $columnasDB = [
        'prioridad_nombre'
    ];
    public static $idTabla = 'prioridad_id';

    public $prioridad_id;
    public $prioridad_nombre;

    public function __construct($args = []){
        $this->prioridad_id = $args['prioridad_id'] ?? null;
        $this->prioridad_nombre = $args['prioridad_nombre'] ?? '';
    }
}