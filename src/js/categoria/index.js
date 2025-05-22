import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';

const FormCategoria = document.getElementById('FormCategoria');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const InputCategoriaNombre = document.getElementById('categoria_nombre');

const ValidarNombreCategoria = () => {
    const nombre = InputCategoriaNombre.value.trim();
    
    if(nombre.length < 1) {
        InputCategoriaNombre.classList.remove('is-valid', 'is-invalid');
        return;
    }
    
    if(nombre.length < 2) {
        Swal.fire({
            position: "top-center",
            icon: "error",
            title: "Nombre muy corto",
            text: "El nombre de la categoría debe tener al menos 2 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        
        InputCategoriaNombre.classList.remove('is-valid');
        InputCategoriaNombre.classList.add('is-invalid');
    } else {
        InputCategoriaNombre.classList.remove('is-invalid');
        InputCategoriaNombre.classList.add('is-valid');
    }
}

const GuardarCategoria = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;
    
    if(!validarFormulario(FormCategoria, ['categoria_id'])) {
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
    
    const body = new FormData(FormCategoria);
    const url = '/App001_KVSC/categoria/guardarAPI';
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
                title: "Categoría guardada",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            FormCategoria.reset();
            CargarCategorias();
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

const ModificarCategoria = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;
    
    if(!validarFormulario(FormCategoria, [])) {
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
    
    const body = new FormData(FormCategoria);
    const url = '/App001_KVSC/categoria/modificarAPI';
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
                title: "Categoría modificada",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            FormCategoria.reset();
            BtnGuardar.classList.remove('d-none');
            BtnModificar.classList.add('d-none');
            CargarCategorias();
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

const EliminarCategoria = async (id) => {
    const AlertaConfirmarEliminar = await Swal.fire({
        position: "center",
        icon: "warning",
        title: "¿Desea eliminar la categoría?",
        text: "Esta completamente seguro de eliminar la categoría",
        showCancelButton: true,
        confirmButtonText: "Si, Eliminar",
        confirmButtonColor: "#dc3545",
        cancelButtonText: "No, Cancelar",
        cancelButtonColor: "#6c757d"
    });
    
    if (AlertaConfirmarEliminar.isConfirmed) {
        const body = new FormData();
        body.append('categoria_id', id);
        
        const url = '/App001_KVSC/categoria/eliminarAPI';
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
                    title: "Categoría eliminada",
                    text: datos.mensaje,
                    showConfirmButton: false,
                    timer: 1500
                });
                CargarCategorias();
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

const CargarCategorias = async () => {
    const url = '/App001_KVSC/categoria/buscarAPI';
    const config = {
        method: 'GET'
    }
    
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        
        if(datos.codigo === 1) {
            // Aquí implementarías la lógica para mostrar las categorías en la tabla
            console.log(datos);
        }
    } catch (error) {
        console.log(error);
    }
}

// Event listeners
FormCategoria.addEventListener('submit', GuardarCategoria);
BtnModificar.addEventListener('click', ModificarCategoria);
InputCategoriaNombre.addEventListener('change', ValidarNombreCategoria);

// Cargar datos iniciales
document.addEventListener('DOMContentLoaded', () => {
    CargarCategorias();
});