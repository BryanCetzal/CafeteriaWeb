$(document).ready(function () {
    function loadProducts(sectionId, containerId) {
        $.ajax({
            url: 'php/getproducts.php',
            type: 'POST',
            data: { section: sectionId },
            dataType: 'json',
            success: function (products) {
                var container = $('#' + containerId);
                container.empty();

                $.each(products, function (index, product) {
                    var productHTML = `
                        <div class="col-lg-4">
                            <div class="single-menu">
                                <div class="title-div justify-content-between d-flex">
                                    <h4>${product.name}</h4>
                                    <p class="price float-right">$${product.price}</p>
                                </div>
                                <p>${product.details}</p>
                                <img src="uploads/${product.image_01}" alt="${product.name}">
                                <button class="add-to-cart" data-product='${JSON.stringify(product)}'>${getButtonText(containerId)}</button>
                            </div>
                        </div>`;

                    container.append(productHTML);
                });

                // Asigna eventos onclick después de agregar los botones al DOM
                container.find('.add-to-cart').off('click').on('click', function () {
                    var product = $(this).data('product');
                    handleButtonClick(containerId, product);
                });
                
            },
            error: function (error) {
                console.error('Error al cargar productos:', error);
            }
        });
    }

    function getButtonText(section) {
        switch (section) {
            case 'coffee-container':
                return 'Ver detalles';
            case 'dessert-container':
            case 'additional-container':
                return 'Agregar al carrito';
            default:
                return 'Acción no definida';
        }
    }

    function handleButtonClick(containerId, product) {
        switch (containerId) {
            case 'coffee-container':
                viewDetails(product);
                break;
            case 'dessert-container':
            case 'additional-container':
                addToCart(product);
                break;
            default:
                console.error('Acción no definida');
        }
    }

    function viewDetails(product) {
        // Guarda los detalles del producto en sessionStorage
        sessionStorage.setItem('id', product.id);
        sessionStorage.setItem('name', product.name);
        sessionStorage.setItem('details', product.details);
        sessionStorage.setItem('image_01', product.image_01);
        sessionStorage.setItem('price', product.price);

        // Redirige a detallesProducto.html
        window.location.href = 'detallesProducto.html';
    }
    function addToCart(product) {
        $.ajax({
            url: 'php/cart.php',
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            data: { product: JSON.stringify(product) },  // No es necesario envolver el producto en JSON.stringify
            success: function (response) {
                console.log(response);
                console.log(product);
            },
            error: function (error) {
                console.error('Error al agregar al carrito:', error);
            }
        });
    }
    

    loadProducts('Products_Coffee', 'coffee-container');
    loadProducts('Products_Dessert', 'dessert-container');
    loadProducts('Products_Additional', 'additional-container');
});
