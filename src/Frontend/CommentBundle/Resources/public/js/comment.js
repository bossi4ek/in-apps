delComment = function(obj) {
    $.ajax({
        type: "POST",
        url: "/comment/del",
        data: {
            id : $(obj).attr('data-id')
        },
        success: function(response){
            if (response == 1) {
                $(obj).parent().parent().parent().remove();
            }
            else {
                alert("Ошибка удаления");
            }
        }
    });
}

$(document).ready(function() {
    $(".del-comment-js").click(function(){
        delComment(this);
    });
});
