// Función para consultar los productos de una categoría y mostrarlos en una fila de tarjetas
function consultarProductos(categoria, containerId) {
    console.log('Consultando productos de la categoría:', categoria);

    // Fetch para obtener los productos de la categoría especificada en el archivo consultar_productos.php  
    fetch(`src/consultar_productos.php?categoria=${categoria}`)
        // Convertir la respuesta a JSON y mostrar los productos en tarjetas en el contenedor especificado
        .then(response => response.json())
        // El then recibe la respuesta del fetch y la convierte a JSON
        .then(data => {
            // Obtener el contenedor de la categoría
            const container = document.getElementById(containerId);
            // Limpiar el contenedor
            container.innerHTML = '';
            // Crear una fila para mostrar las tarjetas de los productos
            const row = document.createElement('div');
            // Agregar la clase 'row' de Bootstrap a la fila para que las tarjetas se muestren en una fila horizontal
            row.className = 'row';
            // Recorrer los productos y crear una tarjeta para cada uno 
            data.forEach(product => {
                // Crear un elemento de imagen para mostrar la imagen del producto
                var img = document.createElement('img');
                // Asignar la imagen del producto a la etiqueta de imagen
                img.src = 'data:image/jpeg;base64,' + product.Imagen;
                // Crear un div para la tarjeta del producto y agregar las clases de Bootstrap
                var card = document.createElement('div');
                // Agregar la clase 'col' de Bootstrap a la tarjeta para que se muestre en una columna
                card.className = 'col';
                // Agregar el contenido de la tarjeta con la información del producto
                card.innerHTML = `
                    <div class="card" style="width: 18rem;">
                        <img src="${img.src}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-title">ID del producto: ${product.Id}</p>
                            <h5 class="card-title">${product.Nombre}</h5>
                            <p class="card-text">${product.Descripcion}</p>
                            <p class="card-text">$${product.Precio}</p>
                        </div>
                    </div>
                `;
                // Agregar la tarjeta al contenedor de la fila
                row.appendChild(card);
            });
            // Agregar la fila al contenedor de la categoría 
            container.appendChild(row);
        })
        .catch(error => console.error('Error al obtener los datos:', error));
}

// Consultar los productos de las categorías especificadas y mostrarlos en los contenedores correspondientes
consultarProductos('Ofertas_Super', 'superContainer');
consultarProductos('Ofertas_Hogar', 'hogarContainer');
consultarProductos('Ofertas_Especiales', 'especialContainer');

