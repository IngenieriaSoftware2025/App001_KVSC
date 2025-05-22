<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Productos;
use Model\Categorias;
use Model\Prioridad;
use MVC\Router;

class ProductosController extends ActiveRecord
{
    public function renderizarPagina(Router $router)
    {
        $router->render('productos/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // Validar nombre del producto
        $_POST['producto_nombre'] = htmlspecialchars($_POST['producto_nombre']);
        $cantidad_nombre = strlen($_POST['producto_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto debe tener al menos 2 caracteres'
            ]);
            return;
        }

        // Validar cantidad
        $_POST['producto_cantidad'] = filter_var($_POST['producto_cantidad'], FILTER_VALIDATE_INT);
        if ($_POST['producto_cantidad'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad debe ser mayor a cero'
            ]);
            return;
        }

        // Validar categoría
        $_POST['producto_categoria'] = filter_var($_POST['producto_categoria'], FILTER_VALIDATE_INT);
        if ($_POST['producto_categoria'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una categoría válida'
            ]);
            return;
        }

        // Validar prioridad
        $_POST['producto_prioridad'] = filter_var($_POST['producto_prioridad'], FILTER_VALIDATE_INT);
        if ($_POST['producto_prioridad'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una prioridad válida'
            ]);
            return;
        }

        try {
            $data = new Productos([
                'producto_nombre' => $_POST['producto_nombre'],
                'producto_cantidad' => $_POST['producto_cantidad'],
                'producto_comprado' => 0,
                'producto_categoria' => $_POST['producto_categoria'],
                'producto_prioridad' => $_POST['producto_prioridad']
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido registrado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            // Obtener productos agrupados por categoría y ordenados por prioridad
            $productosAgrupados = Productos::obtenerAgrupadosPorCategoria();
            $productosComprados = Productos::obtenerComprados();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos obtenidos correctamente',
                'productosAgrupados' => $productosAgrupados,
                'productosComprados' => $productosComprados
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los productos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['producto_id'];

        // Validar nombre del producto
        $_POST['producto_nombre'] = htmlspecialchars($_POST['producto_nombre']);
        $cantidad_nombre = strlen($_POST['producto_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto debe tener al menos 2 caracteres'
            ]);
            return;
        }

        // Validar cantidad
        $_POST['producto_cantidad'] = filter_var($_POST['producto_cantidad'], FILTER_VALIDATE_INT);
        if ($_POST['producto_cantidad'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad debe ser mayor a cero'
            ]);
            return;
        }

        // Validar categoría
        $_POST['producto_categoria'] = filter_var($_POST['producto_categoria'], FILTER_VALIDATE_INT);
        if ($_POST['producto_categoria'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una categoría válida'
            ]);
            return;
        }

        // Validar prioridad
        $_POST['producto_prioridad'] = filter_var($_POST['producto_prioridad'], FILTER_VALIDATE_INT);
        if ($_POST['producto_prioridad'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una prioridad válida'
            ]);
            return;
        }

        try {
            $data = Productos::find($id);
            $data->sincronizar([
                'producto_nombre' => $_POST['producto_nombre'],
                'producto_cantidad' => $_POST['producto_cantidad'],
                'producto_categoria' => $_POST['producto_categoria'],
                'producto_prioridad' => $_POST['producto_prioridad']
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido modificado exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        getHeadersApi();

        $id = $_POST['producto_id'];

        try {
            $producto = Productos::find($id);
            $producto->eliminar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function comprarAPI()
    {
        getHeadersApi();

        $id = $_POST['producto_id'];

            try {
            $producto = Productos::find($id);
            if (!$producto) {
                throw new Exception("Producto no encontrado");
            }
            
            $producto->productos_comprados = 1;
            $producto->actualizar();
            
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido marcado como comprado'
            ]);
        } catch (Exception $e) {
            // Resto del código de error
        }
    }
}
