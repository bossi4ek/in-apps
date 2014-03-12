delElement = function(obj) {
    $.ajax({
        type: "POST",
        url: $(obj).data('url'),
        data: {
            id : $(obj).data('id')
        },
        success: function(response){
            if (response == 1) {
                $(obj).parent().parent().parent().remove();
            }
            else {
                alert("Ошибка добавления");
            }
        }
    });
};

initEvents = function() {
    $(".post_delete").click(function(){
        delElement(this);
    });
};

$(document).ready(function() {
    initEvents();
});
