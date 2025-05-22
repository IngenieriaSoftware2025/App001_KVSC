<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid rgb(4, 22, 89);">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Hola María! Bienvenida de nuevo, nos encanta poder ayudarte con tus compras</h5>
                    <h4 class="text-center mb-2" style="color:rgb(133, 24, 78);">Gestiona tus productos de manera sencilla</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormProductos">
                        <input type="hidden" id="producto_id" name="producto_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="producto_nombre" class="form-label">NOMBRE DEL PRODUCTO</label>
                                <input type="text" class="form-control" id="producto_nombre" name="producto_nombre" placeholder="Ingresa aqui el nombre de tu producto Eje. 'Leche'">
                            </div>
                            <div class="col-lg-6">
                                <label for="producto_cantidad" class="form-label">CANTIDAD</label>
                                <input type="number" class="form-control" id="producto_cantidad" name="producto_cantidad" placeholder="Ingrese aqui la cantidad Eje. '5' " min="1">
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="categoria_id" class="form-label">CATEGORÍA</label>
                              <select name="categoria_id" class="form-select" id="categoria_id">
                                    <option value="" class="text-center"> -- SELECCIONE CATEGORÍA -- </option>
                                    <?php foreach($categorias as $c): ?>
                                        <option value="<?= $c->id ?>"><?= $c->nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                         </div>
                            <div class="col-lg-6">
                                <label for="producto_prioridad" class="form-label">PRIORIDAD</label>
                                <select name="producto_prioridad" class="form-select" id="producto_prioridad">
                                    <option value="" class="text-center">-- SELECCIONE LA PRIORIDAD --</option>
                                    <option value="1">ALTA</option>
                                    <option value="2">MEDIA</option>
                                    <option value="3">BAJA</option>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    Guardar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                    Modificar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    Limpiar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid rgb(4, 22, 89);">
            <div class="card-body p-3">
                <h3 class="text-center">LISTADO DE TUS PRODUCTOS</h3>
                
                <!-- Sección para productos no comprados -->
                <div id="productosNoComprados">

                </div>
                
                <!-- Sección para productos comprados -->
                <div class="mt-4" id="productosComprados">
                    <h4 class="text-center" style="color:rgb(133, 24, 78);">PRODUCTOS QUE YA HAN SIDO COMPRADOS</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= asset('build/js/productos/index.js') ?>"></script>