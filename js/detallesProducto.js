// Código JavaScript para manipular la página
document.addEventListener('DOMContentLoaded', function () {
    // Obtiene los detalles del producto desde sessionStorage
    const id = sessionStorage.getItem('id');
    const name = sessionStorage.getItem('name');
    const details = sessionStorage.getItem('details');
    const image_01 = sessionStorage.getItem('image_01');
    const price = parseFloat(sessionStorage.getItem('price'));

    // Actualiza la información de la página con los detalles del producto
    document.getElementById('product-image').src = `uploads/${image_01}`;
    document.getElementById('product-name').innerText = name;
    document.getElementById('product-description').innerText = details;

    // Obtén referencias a los elementos del formulario
    const milkTypeSelect = document.getElementById('milkType');
    const sizeSelect = document.getElementById('size');
    const quantityInput = document.getElementById('quantity');
    const priceSpan = document.getElementById('product-price');

    // Inicializa las variables de precio base ajustado según el tamaño
    let sizePriceSmall = price - 5;
    let sizePriceBig = price + 5;

    // Inicializa el precio con el valor base del producto
    let totalPrice = price;

    // Calcula y actualiza el precio cuando cambian las opciones
    let sizePrice;
    function updatePrice() {
        const milkTypePrice = (milkTypeSelect.value === 'ent') ? 0 : 0; // Puedes ajustar los precios según tus necesidades
    
        if (sizeSelect.value === 'Chico') {
            sizePrice = sizePriceSmall;
        } else if (sizeSelect.value === 'Grande') {
            sizePrice = sizePriceBig;
        } else {
            sizePrice = price;
        }
    
        const quantityPrice = (quantityInput.value) * sizePrice;
    
        // Actualiza el precio total
        totalPrice = quantityPrice;
    
        // Muestra el precio con dos decimales
        priceSpan.innerText = totalPrice.toFixed(2);
    }

    // Agrega manejadores de eventos a los elementos del formulario
    milkTypeSelect.addEventListener('change', updatePrice);
    sizeSelect.addEventListener('change', updatePrice);
    quantityInput.addEventListener('input', updatePrice);

    // Maneja el evento de clic en el botón "Agregar al Carrito"
    document.getElementById('addToCartBtn').addEventListener('click', function (event) {
        event.preventDefault();
        // Obtén los valores de los selectores y de la cantidad
        const milkType = milkTypeSelect.value;
        const size = sizeSelect.value;
        const quantity = quantityInput.value;
        const sizePriceForProduct = sizePrice;
        

        // Crea un objeto con la información del producto
        product = {
            id: id,
            cname: name,
            cdetails: details,
            cimage_01: image_01,
            cprice: sizePriceForProduct,
            cbaseprice: price,
            cmilkType: milkType,
            csize: size,
            cquantity: quantity,
        };

        // Envía la información al servidor mediante una solicitud AJAX
        $.ajax({
            url: 'php/cart.php', // Ajusta la ruta según tu configuración
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            data: { product: JSON.stringify(product) },
            success: function (response) {
                console.log('Producto agregado al carrito. Precio total: $' + totalPrice.toFixed(2));
                console.log(response);
                console.log(product);
            },
            error: function (error) {
                console.error('Error al agregar al carrito:', error);
            }
        });
    });

    // Llama a la función updatePrice para inicializar el precio
    updatePrice();
});