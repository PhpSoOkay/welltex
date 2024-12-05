function addToCart(id, selectedCount) {
    $.post('/index.php?r=food%2Fadd', {
        food_id: id, food_count: selectedCount
    }, function (data) {
        if (!data.success) {
            alert('ошибка:'.data.message);
            return;
        }
        alert('Добавлено');
    });
}