function addToCart(cart) {
    $.post('/index.php?r=order%2Fadd', {
        cart: cart
    }, function (data) {
        if (!data.success) {
            alert('ошибка:'.data.message);
            return;
        }
        alert('Добавлено');
    });
}
function updateCart(cart){
    $.post('/index.php?r=order%2Fupdate-cart', {
        cart: cart
    });
}