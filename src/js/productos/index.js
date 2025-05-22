// Función para buscar productos
const BuscarProductos = async () => {
    const url = '/App001_KVSC/productos/buscarAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1) {
            // Filtrar productos pendientes y comprados
            const productosPendientes = data.filter(producto => producto.producto_comprado == 0);
            const productosComprados = data.filter(producto => producto.producto_comprado == 1);

            // Actualizar tablas
            datatablePendientes.clear().draw();
            datatablePendientes.rows.add(productosPendientes).draw();

            datatableComprados.clear().draw();
            datatableComprados.rows.add(productosComprados).draw();
            
            Toast.fire({
                icon: 'success',
                title: mensaje
            });
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
}

// Tabla de productos pendientes
const datatablePendientes = new DataTable('#TableProductosPendientes', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {
            title: 'No.',
            data: 'producto_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Producto', data: 'producto_nombre', width: '25%' },
        { title: 'Cantidad', data: 'producto_cantidad', width: '10%' },
        { title: 'Categoría', data: 'categoria_nombre', width: '20%' },
        { 
            title: 'Prioridad', 
            data: 'prioridad_nombre', 
            width: '15%',
            render: (data, type, row) => {
                let badge = 'badge bg-secondary';
                if (data === 'ALTA') {
                    badge = 'badge bg-danger';
                } else if (data === 'MEDIA') {
                    badge = 'badge bg-warning text-dark';
                } else if (data === 'BAJA') {
                    badge = 'badge bg-success';
                }
                return `<span class="${badge}">${data}</span>`;
            }
        },
        {
            title: 'Acciones',
            data: 'producto_id',
            width: '25%',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                <div class='d-flex justify-content-center'>
                    <button class='btn btn-warning btn-sm modificar mx-1' 
                        data-id="${data}" 
                        data-nombre="${row.producto_nombre}"  
                        data-cantidad="${row.producto_cantidad}"  
                        data-categoria="${row.producto_categoria}"  
                        data-prioridad="${row.producto_prioridad}">
                        <i class='bi bi-pencil-square me-1'></i> Modificar
                    </button>
                    <button class='btn btn-secondary btn-sm eliminar mx-1' 
                        data-id="${data}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                    </button>
                    <button class='btn btn-success btn-sm marcarComprado mx-1' 
                        data-id="${data}">
                        <i class="bi bi-check2-square me-1"></i>Comprar
                    </button>
                </div>`;
            }
        }
    ]
});

// Tabla de productos comprados
const datatableComprados = new DataTable('#TableProductosComprados', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        {
            title: 'No.',
            data: 'producto_id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Producto', data: 'producto_nombre', width: '35%' },
        { title: 'Cantidad', data: 'producto_cantidad', width: '10%' },
        { title: 'Categoría', data: 'categoria_nombre', width: '25%' },
        {
            title: 'Estado',
            data: 'producto_id',
            width: '25%',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                <div class='d-flex justify-content-center'>
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle-fill"></i> Comprado
                    </span>
                </div>`;
            }
        }
    ]
});

// Función para llenar el formulario cuando se quiere modificar
const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset;

    document.getElementById('producto_id').value = datos.id;
    document.getElementById('producto_nombre').value = datos.nombre;
    document.getElementById('producto_cantidad').value = datos.cantidad;
    document.getElementById('producto_categoria').value = datos.categoria;
    document.getElementById('producto_prioridad').value = datos.prioridad;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
}

// Función para limpiar el formulario
const limpiarTodo = () => {
    FormProductos.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

// Función para modificar un producto
const ModificarProducto = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormProductos, [''])) {
        Swal.fire({
            position: "center",
            icon: "¡Oh no!",
            title: "El formulario esta incompleto",
            text: "Debes completar todos los campos",
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
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarTodo();
            BuscarProductos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
    BtnModificar.disabled = false;
}

// Función para marcar un producto como comprado
const marcarComprado = async (event) => {
    const id = event.currentTarget.dataset.id;
    
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
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            Toast.fire({
                icon: 'success',
                title: mensaje
            });
            BuscarProductos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
}

// Función para eliminar un producto
const eliminarProducto = async (event) => {
    const id = event.currentTarget.dataset.id;
    
    const resultado = await Swal.fire({
        title: '¿Estás segura?',
        text: '¿Deseas eliminar este producto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (resultado.isConfirmed) {
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
            const { codigo, mensaje } = datos;

            if (codigo == 1) {
                Toast.fire({
                    icon: 'success',
                    title: mensaje
                });
                BuscarProductos();
            } else {
                await Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "Error",
                    text: mensaje,
                    showConfirmButton: true,
                });
            }
        } catch (error) {
            console.log(error);
        }
    }
}

// Inicializar la aplicación
BuscarProductos();

// Event listeners AL FINAL
datatablePendientes.on('click', '.modificar', llenarFormulario);
datatablePendientes.on('click', '.marcarComprado', marcarComprado);
datatablePendientes.on('click', '.eliminar', eliminarProducto);
FormProductos.addEventListener('submit', GuardarProducto);
BtnLimpiar.addEventListener('click', limpiarTodo);
BtnModificar.addEventListener('click', ModificarProducto);