action = function(obj) {
    $.ajax({
        type: "POST",
        url: "/mycontent/add",
        data: {
            id : $(obj).data('id')
        },
        success: function(response){
            if (response == 1) {
//                $(obj).removeClass("btn-success").addClass("btn-danger").text("Удалить из моих");
//                $(obj).click(function(){
//                   delMycontent(obj);
//                });
                $(obj).parent().hide();
                $(obj).parent().next().show();
            }
            else {
                alert("Ошибка добавления");
            }
        }
    });
};

$(document).ready(function() {

});
