var $rows = $('.sr');

$('.search').keyup(function() {
    var val = $.trim($(this).val()).toLowerCase();
    $rows.show().filter(function(index) {
        var text= $(this).text().toLowerCase();
        return (text.indexOf(val) === -1);
    }).hide();
});