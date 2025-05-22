<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Categorias;
use MVC\Router;

class CategoriaController extends ActiveRecord
{
    public function renderizarPagina(Router $router)
    {
        $router->render('categoria/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // Validar nombre de la categoría
        $_POST['categoria_nombre'] = htmlspecialchars($_POST['categoria_nombre']);
        $cantidad_nombre = strlen($_POST['categoria_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la categoría debe tener al menos 2 caracteres'
            ]);
            return;
        }

        try {
            $data = new Categorias([
                'categoria_nombre' => $_POST['categoria_nombre']
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La categoría ha sido registrada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar la categoría',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $sql = "SELECT * FROM categoria ORDER BY categoria_nombre";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Categorías obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las categorías',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['categoria_id'];

        // Validar nombre de la categoría
        $_POST['categoria_nombre'] = htmlspecialchars($_POST['categoria_nombre']);
        $cantidad_nombre = strlen($_POST['categoria_nombre']);

        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la categoría debe tener al menos 2 caracteres'
            ]);
            return;
        }

        try {
            $data = Categorias::find($id);
            $data->sincronizar([
                'categoria_nombre' => $_POST['categoria_nombre']
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La categoría ha sido modificada exitosamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la categoría',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        getHeadersApi();

        $id = $_POST['categoria_id'];

        // Verificar si hay productos que usan esta categoría
        $sql = "SELECT COUNT(*) as total FROM producto WHERE producto_categoria = {$id}";
        $resultado = self::fetchArray($sql);
        
        if ($resultado[0]['total'] > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'No se puede eliminar la categoría porque hay productos asociados'
            ]);
            return;
        }

        try {
            $categoria = Categorias::find($id);
            $categoria->eliminar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La categoría ha sido eliminada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar la categoría',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}