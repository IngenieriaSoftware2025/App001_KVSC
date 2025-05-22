<?php
namespace Model;

class Productos extends ActiveRecord {
    public static $tabla = 'producto';
    public static $columnasDB = [
        'producto_nombre',
        'producto_cantidad',
        'producto_comprado',
        'producto_categoria',
        'producto_prioridad'
    ];
    public static $idTabla = 'producto_id';

    public $producto_id;
    public $producto_nombre;
    public $producto_cantidad;
    public $producto_comprado;
    public $producto_categoria;
    public $producto_prioridad;

    public function __construct($args = []){
        $this->producto_id = $args['producto_id'] ?? null;
        $this->producto_nombre = $args['producto_nombre'] ?? '';
        $this->producto_cantidad = $args['producto_cantidad'] ?? 0;
        $this->producto_comprado = $args['producto_comprado'] ?? 0;
        $this->producto_categoria = $args['producto_categoria'] ?? 0;
        $this->producto_prioridad = $args['producto_prioridad'] ?? 0;
    }

    public static function obtenerConCategoriaYPrioridad() {
        $query = "SELECT p.*, c.categoria_nombre, pr.prioridad_nombre 
                  FROM " . static::$tabla . " p
                  JOIN categoria c ON p.producto_categoria = c.categoria_id
                  JOIN prioridad pr ON p.producto_prioridad = pr.prioridad_id
                  ORDER BY p.producto_comprado ASC, c.categoria_nombre ASC, p.producto_prioridad ASC";
        
        return static::fetchArray($query);
    }

    public static function obtenerAgrupadosPorCategoria() {
        $query = "SELECT p.*, c.categoria_nombre, pr.prioridad_nombre 
                  FROM " . static::$tabla . " p
                  JOIN categoria c ON p.producto_categoria = c.categoria_id
                  JOIN prioridad pr ON p.producto_prioridad = pr.prioridad_id
                  WHERE p.producto_comprado = 0
                  ORDER BY c.categoria_nombre ASC, p.producto_prioridad ASC";
        
        $productos = static::fetchArray($query);
        
        $agrupados = [];
        foreach ($productos as $producto) {
            $categoria = $producto['categoria_nombre'];
            if (!isset($agrupados[$categoria])) {
                $agrupados[$categoria] = [];
            }
            $agrupados[$categoria][] = $producto;
        }
        
        return $agrupados;
    }

    public static function obtenerComprados() {
        $query = "SELECT p.*, c.categoria_nombre, pr.prioridad_nombre 
                  FROM " . static::$tabla . " p
                  JOIN categoria c ON p.producto_categoria = c.categoria_id
                  JOIN prioridad pr ON p.producto_prioridad = pr.prioridad_id
                  WHERE p.producto_comprado = 1
                  ORDER BY c.categoria_nombre ASC";
        
        return static::fetchArray($query);
    }

    public function marcarComoComprado() {
        $this->producto_comprado = 1;
        return $this->actualizar();
    }
}