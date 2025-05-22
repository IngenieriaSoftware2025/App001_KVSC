<?php
namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Productos;
use MVC\Router;

class ProductosController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        // Obtener categorías para el select
        $categorias = self::fetchArray("SELECT * FROM categoria ORDER BY categoria_nombre");
        
        $router->render('productos/index', [
            'categorias' => $categorias
        ]);
    }

   public static function guardarAPI()
{
    getHeadersApi();

    try {
        // Validaciones básicas
        if (empty($_POST['producto_nombre'])) {
            throw new Exception("¡No olvides!, El nombre del producto es requerido");
        }
        
        if (empty($_POST['producto_cantidad']) || $_POST['producto_cantidad'] <= 0) {
            throw new Exception("¡Oh no!, La cantidad debe ser mayor a cero");
        }
        
        if (empty($_POST['producto_categoria'])) {
            throw new Exception("María, debes seleccionar una categoría");
        }
        
        if (empty($_POST['producto_prioridad'])) {
            throw new Exception("María, debes seleccionar una prioridad");
        }

          $producto = new Productos([
            'producto_nombre' => $_POST['producto_nombre'],
            'producto_cantidad' => (int)$_POST['producto_cantidad'],
            'producto_comprado' => 0,  // SIEMPRE 0 al crear
            'producto_categoria' => (int)$_POST['producto_categoria'],
            'producto_prioridad' => (int)$_POST['producto_prioridad']
        ]);

            $resultado = $producto->crear();
        
        http_response_code(200);
        echo json_encode([
            'codigo' => 1,
            'mensaje' => '¡Muy bien María, has guardado un producto correctamente!'
        ]);
        
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => $e->getMessage()
        ]);
    }
}

    public static function buscarAPI()
    {
        try {
            $productos = self::fetchArray("
                SELECT p.*, c.categoria_nombre, pr.prioridad_nombre 
                FROM producto p
                JOIN categoria c ON p.producto_categoria = c.categoria_id
                JOIN prioridad pr ON p.producto_prioridad = pr.prioridad_id
                ORDER BY p.producto_comprado ASC, c.categoria_nombre ASC, p.producto_prioridad ASC
            ");

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos obtenidos',
                'data' => $productos
            ]);
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener productos',
                'detalle' => $e->getMessage()
            ]);
        }
    }

     public static function modificarAPI()
    {
        getHeadersApi();

        try {
            if (empty($_POST['producto_id'])) {
                throw new Exception("ID del producto no proporcionado");
            }

            if (empty($_POST['producto_nombre'])) {
                throw new Exception("El nombre del producto es requerido");
            }
            
            if (empty($_POST['producto_cantidad']) || $_POST['producto_cantidad'] <= 0) {
                throw new Exception("La cantidad debe ser mayor a cero");
            }
            
            if (empty($_POST['producto_categoria'])) {
                throw new Exception("Debes seleccionar una categoría");
            }
            
            if (empty($_POST['producto_prioridad'])) {
                throw new Exception("Debes seleccionar una prioridad");
            }

            $producto = Productos::find($_POST['producto_id']);
            
            if (!$producto) {
                throw new Exception("Producto no encontrado");
            }

            $producto->sincronizar([
                'producto_nombre' => $_POST['producto_nombre'],
                'producto_cantidad' => (int)$_POST['producto_cantidad'],
                'producto_categoria' => (int)$_POST['producto_categoria'],
                'producto_prioridad' => (int)$_POST['producto_prioridad']
            ]);

            $resultado = $producto->actualizar();
            
            if (!$resultado) {
                throw new Exception("Error al actualizar el producto");
            }
            
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => '¡Producto actualizado correctamente!'
            ]);
            
        } catch (Exception $e) {
            error_log("Error en modificarAPI: " . $e->getMessage());
            
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public static function comprarAPI()
{
    getHeadersApi();
    $id = $_POST['producto_id'];

    try {
        $producto = new Productos(['producto_id' => $id]);
        $producto = Productos::find($id);
        $producto->sincronizar(['producto_comprado' => 1]);
        $producto->actualizar();
        
        http_response_code(200);
        echo json_encode([
            'codigo' => 1,
            'mensaje' => 'El producto ha sido marcado como comprado'
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Error al marcar como comprado',
            'detalle' => $e->getMessage()
        ]);
    }
}

public static function eliminarAPI()
{
    getHeadersApi();
    $id = $_POST['producto_id'];

    try {
        $producto = Productos::find($id);
        if (!$producto) {
            throw new Exception("Producto no encontrado");
        }
        
        $producto->eliminar();

        http_response_code(200);
        echo json_encode([
            'codigo' => 1,
            'mensaje' => 'El producto ha sido eliminado correctamente'
        ]);
    } catch (Exception $e) {
        error_log("Error al eliminar: " . $e->getMessage());
        
        http_response_code(400);
        echo json_encode([
            'codigo' => 0,
            'mensaje' => 'Error al eliminar el producto',
            'detalle' => $e->getMessage()
        ]);
    }
}
}