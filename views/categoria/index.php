<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid rgb(4, 22, 89);">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación de Lista de Compras!</h5>
                    <h4 class="text-center mb-2" style="color:rgb(133, 24, 78);">GESTIÓN DE CATEGORÍAS</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormCategoria">
                        <input type="hidden" id="categoria_id" name="categoria_id">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="categoria_nombre" class="form-label">CATEGORÍA NUEVA</label>
                                <input type="text" class="form-control" id="categoria_nombre" name="categoria_nombre" placeholder="Ingrese el nombre de una nueva categoría">
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-thistle" type="submit" id="BtnGuardar">
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
                <h3 class="text-center">CATEGORÍAS REGISTRADAS</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableCategorias">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= asset('build/js/categoria/index.js') ?>"></script>
