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

// Подстетака активноой вкладки в админке
$('.sidebar-menu a').each(function () {
   var location = window.location.protocol + '//' + window.location.host + window.location.pathname;
   var link = this.href;
   if (link === location){
       $(this).parent().addClass('active');
       $(this).closest('.treeview').addClass('active');
   }
});


// KCEditor
$('#editor1').ckeditor();


// Сброс фильтров в админке
$('#reset-filter').click(function () {
    $('#filter input[type=radio]').prop('checked', false);
    return false;
});

//