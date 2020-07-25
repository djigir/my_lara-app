// Подтверждение на удаление заказа
$('.delete').click(function () {
    var res = confirm('Подтвердите удаление?');
    if (!res) return false;
});

// Редактирование заказа
$('.redact').click(function () {
   var res = confirm('Вы можете изменить только комментарий');
    return false;
});

// // Подтверждение на удаление заказа из БД
$('.deletebd').click(function () {
    var res = confirm('Удалить из базы данных?');
        if (res) {
            var ress = confirm('Вы удалите заказ безвозратно!');
            if (!ress) return false
        }
    if (!res) return false;
});
