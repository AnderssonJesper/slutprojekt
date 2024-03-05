jQuery(document).ready(function ($) {
    $('#load-more-related-products').click(function () {
     
        $(this).hide();

        $.ajax({
            url: ajax_variables.ajaxUrl,
            type: 'POST',
            data: {
                action: 'mytheme_getbyajax'
            },
            success: function (response) {
               
                $('#related-products-container').empty();

                
                $.each(response, function (index, product) {
                    var html = '<div class="product">';
                    if (product.product_url) {
                        html += '<a href="' + product.product_url + '">';
                    }
                    html += '<img src="' + product.image + '" alt="' + product.name + '">';
                    html += '<h2>' + product.name + '</h2>';
                    html += generateStars(product.rating);
                    html += '<p>' + parseFloat(product.price).toFixed(2) + ' kr</p>';
                    if (product.product_url) {
                        html += '</a>';
                    }
                    html += '</div>';
                    $('#related-products-container').append(html);
                });

            }
        });
    });

    
    function generateStars(rating) {
        var stars = '';
        for (var i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<img src="http://slutprojekt.test/wp-content/uploads/2024/03/star-filled-1.png" alt="star">';
            } else {
                stars += '<img src="http://slutprojekt.test/wp-content/uploads/2024/03/star-unfilled-1.png" alt="star">';
            }
        }
        return stars;
    }
});







