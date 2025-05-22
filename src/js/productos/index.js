import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';

const FormProductos = document.getElementById('FormProductos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const InputProductoNombre = document.getElementById('producto_nombre');
const InputProductoCantidad = document.getElementById('producto_cantidad');
const SelectProductoCategoria = document.getElementById('producto_categoria');
const SelectProductoPrioridad = document.getElementById('producto_prioridad');

const ValidarNombreProducto = () => {
    const nombre = InputProductoNombre.value.trim();
    
    if(nombre.length < 1) {
        InputProductoNombre.classList.remove('is-valid', 'is-invalid');
        return;
    }
    
    if(nombre.length < 2) {
        Swal.fire({
            position: "top-center",
            icon: "error",
            title: "Nombre muy corto",
            text: "El nombre del producto debe tener al menos 2 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        
        InputProductoNombre.classList.remove('is-valid');
        InputProductoNombre.classList.add('is-invalid');
    } else {
        InputProductoNombre.classList.remove('is-invalid');
        InputProductoNombre.classList.add('is-valid');
    }
}

const ValidarCantidad = () => {
    const cantidad = parseInt(InputProductoCantidad.value);
    
    if(isNaN(cantidad) || cantidad <= 0) {
        Swal.fire({
            position: "top-center",
            icon: "error",
            title: "Cantidad inválida",
            text: "La cantidad debe ser mayor a cero",
            showConfirmButton: false,
            timer: 1500
        });
        
        InputProductoCantidad.classList.remove('is-valid');
        InputProductoCantidad.classList.add('is-invalid');
    } else {
        InputProductoCantidad.classList.remove('is-invalid');
        InputProductoCantidad.classList.add('is-valid');
    }
}

const ValidarCategoria = () => {
    const categoria = SelectProductoCategoria.value;
    
    if(categoria === "" || categoria === "0") {
        Swal.fire({
            position: "top-center",
            icon: "warning",
            title: "Seleccione una categoría",
            text: "Debe seleccionar una categoría para el producto",
            showConfirmButton: false,
            timer: 1500
        });
        
        SelectProductoCategoria.classList.remove('is-valid');
        SelectProductoCategoria.classList.add('is-invalid');
    } else {
        SelectProductoCategoria.classList.remove('is-invalid');
        SelectProductoCategoria.classList.add('is-valid');
    }
}

const ValidarPrioridad = () => {
    const prioridad = SelectProductoPrioridad.value;
    
    if(prioridad === "" || prioridad === "0") {
        Swal.fire({
            position: "top-center",
            icon: "warning",
            title: "Seleccione una prioridad",
            text: "Debe seleccionar una prioridad para el producto",
            showConfirmButton: false,
            timer: 1500
        });
        
        SelectProductoPrioridad.classList.remove('is-valid');
        SelectProductoPrioridad.classList.add('is-invalid');
    } else {
        SelectProductoPrioridad.classList.remove('is-invalid');
        SelectProductoPrioridad.classList.add('is-valid');
    }
}

const GuardarProducto = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;
    
    if(!validarFormulario(FormProductos, ['producto_id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "Formulario incompleto",
            text: "Debe completar todos los campos correctamente",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }
    
    const body = new FormData(FormProductos);
    const url = '/App001_KVSC/productos/guardarAPI';
    const config = {
        method: 'POST',
        body
    }
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        
        if(datos.codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Producto guardado",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            FormProductos.reset();
            CargarProductos();
        } else {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: datos.mensaje,
                showConfirmButton: true,
            });
        }
        
        BtnGuardar.disabled = false;
    } catch (error) {
        console.log(error);
        BtnGuardar.disabled = false;
    }
}

const ModificarProducto = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;
    
    if(!validarFormulario(FormProductos, [])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "Formulario incompleto",
            text: "Debe completar todos los campos correctamente",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }
    
    const body = new FormData(FormProductos);
    const url = '/App001_KVSC/productos/modificarAPI';
    const config = {
        method: 'POST',
        body
    }
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        
        if(datos.codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Producto modificado",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            FormProductos.reset();
            BtnGuardar.classList.remove('d-none');
            BtnModificar.classList.add('d-none');
            CargarProductos();
        } else {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: datos.mensaje,
                showConfirmButton: true,
            });
        }
        
        BtnModificar.disabled = false;
    } catch (error) {
        console.log(error);
        BtnModificar.disabled = false;
    }
}

const EliminarProducto = async (id) => {
    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea eliminar el producto?",
        text: "Esta completamente seguro de eliminar el producto",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminar",
        confirmButtonColor: "#dc3545",
        cancelButtonText: "No, Cancelar",
        cancelButtonColor: "#6c757d"
    });
    
    if (AlertaConfirmarEliminar.isConfirmed) {
        const body = new FormData();
        body.append('producto_id', id);
        
        const url = '/App001_KVSC/productos/eliminarAPI';
        const config = {
            method: 'POST',
            body
        }
        
        try {
            const respuesta = await fetch(url, config);
            const datos = await respuesta.json();
            
            if(datos.codigo === 1) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Producto eliminado",
                    text: datos.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                });
                CargarProductos();
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Error",
                    text: datos.mensaje,
                    showConfirmButton: true,
                });
            }
        } catch (error) {
            console.log(error);
        }
    }
}

const MarcarComoComprado = async (id) => {
    const body = new FormData();
    body.append('producto_id', id);
    
    const url = '/App001_KVSC/productos/comprarAPI';
    const config = {
        method: 'POST',
        body
    }
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        
        if(datos.codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Producto comprado",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            CargarProductos();
        } else {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: datos.mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const CargarProductos = async () => {
    const url = '/App001_KVSC/productos/buscarAPI';
    const config = {
        method: 'GET'
    }
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        
        if(datos.codigo === 1) {
            // Aquí implementarías la lógica para mostrar los productos agrupados
            console.log(datos);
        }
    } catch (error) {
        console.log(error);
    }
}

const CargarCategorias = async () => {
    const url = '/App001_KVSC/categoria/buscarAPI';
    const config = {
        method: 'GET'
    }
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        
        if(datos.codigo === 1) {
            SelectProductoCategoria.innerHTML = '<option value="">-- SELECCIONE LA CATEGORÍA --</option>';
            datos.data.forEach(categoria => {
                SelectProductoCategoria.innerHTML += `<option value="${categoria.categoria_id}">${categoria.categoria_nombre}</option>`;
            });
        }
    } catch (error) {
        console.log(error);
    }
}

// Event listeners
FormProductos.addEventListener('submit', GuardarProducto);
BtnModificar.addEventListener('click', ModificarProducto);
InputProductoNombre.addEventListener('change', ValidarNombreProducto);
InputProductoCantidad.addEventListener('change', ValidarCantidad);
SelectProductoCategoria.addEventListener('change', ValidarCategoria);
SelectProductoPrioridad.addEventListener('change', ValidarPrioridad);

// Cargar datos iniciales
document.addEventListener('DOMContentLoaded', () => {
    CargarCategorias();
    CargarProductos();
});