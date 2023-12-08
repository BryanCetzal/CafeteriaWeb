$(document).ready(function() {
    // Realizar solicitud AJAX para obtener datos del carrito
    $.ajax({
        url: 'php/getcart.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Manejar los datos recibidos y mostrar en el frontend
            displayCart(data);
        },
        error: function(error) {
            console.error('Error al obtener datos del carrito:', error);
        }
    });
});

function displayCart(cartData) {
    // Limpiar las tablas
    $('#additionalDessertBody').empty();
    $('#coffeeBody').empty();

    // Llenar la tabla Additional Dessert
    cartData.additional_dessert.forEach(item => {
        const row = $(`
            <tr>
                <td>${item.name}</td>
                <td>${item.price}</td>
                <td>${item.quantity}</td>
                <td>
                    <button class="editBtn" data-id="${item.id}" data-type="additional_dessert">Editar</button>
                    <button class="deleteBtn" data-id="${item.id}" data-type="additional_dessert">Eliminar</button>
                </td>
            </tr>
        `);
        $('#additionalDessertBody').append(row);
    });

    // Llenar la tabla Coffee
    cartData.coffee.forEach(item => {
        const row = $(`
            <tr>
                <td>${item.name}</td>
                <td>${item.price}</td>
                <td>${item.milktype}</td>
                <td>${item.size}</td>
                <td>${item.quantity}</td>
                <td>
                <button class="editBtn" data-id="${item.id}" data-type="coffee">Editar</button>
                <button class="deleteBtn" data-id="${item.id}" data-type="coffee">Eliminar</button>
                </td>
            </tr>
        `);
        $('#coffeeBody').append(row);
    });

    // Agregar evento de clic para los botones de eliminación
    $('.deleteBtn').on('click', function() {
        const itemId = $(this).data('id');
        const itemType = $(this).data('type');
        deleteCartItem(itemId, itemType);
    });
    // Después de agregar filas en la función displayCart()
    $('.editBtn').on('click', function() {
        const itemId = $(this).data('id');
        const itemType = $(this).data('type');
        editCartItem(itemId, itemType, cartData);  // Pasar cartData como parámetro
    });

}

function deleteCartItem(itemId, itemType) {
    // Realizar una solicitud AJAX para eliminar el elemento de la base de datos
    $.ajax({
        url: 'php/deleteCartItem.php',
        type: 'POST',
        data: { id: itemId, type: itemType },
        success: function(response) {
            console.log('Elemento eliminado del carrito y la base de datos');
            // Volver a cargar los datos del carrito después de eliminar
            reloadCartData();
        },
        error: function(error) {
            console.error('Error al eliminar elemento del carrito:', error);
        }
    });
}

function reloadCartData() {
    // Recargar los datos del carrito después de eliminar un elemento
    $.ajax({
        url: 'php/getcart.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            // Volver a mostrar los datos del carrito
            displayCart(data);
        },
        error: function(error) {
            console.error('Error al obtener datos del carrito:', error);
        }
    });
    
}
function editCartItem(itemId, itemType, cartData) {
    console.log('Datos del carrito:', cartData); // Agrega esta línea para depurar

    // Obtener los datos del item a editar
    const itemToEdit = cartData[itemType].find(item => parseInt(item.id) === parseInt(itemId));


    console.log('Item a editar:', itemToEdit); // Agrega esta línea para depurar

    // Verificar si itemToEdit tiene datos
    if (itemToEdit) {
        // Redirigir a otra página y pasar los datos como parámetros en la URL
        window.location.href = `php/editItemPage.php?id=${itemId}&type=${itemType}&data=${encodeURIComponent(JSON.stringify(itemToEdit))}`;
    } else {
        console.error('No se encontraron datos para el ítem con ID ' + itemId);
    }
}
