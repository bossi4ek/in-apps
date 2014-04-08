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

initGallery = function() {
    $().piroBox({
        my_speed: 400, //animation speed
        bg_alpha: 0.1, //background opacity
        slideShow : true, // true == slideshow on, false == slideshow off
        slideSpeed : 4, //slideshow duration in seconds(3 to 6 Recommended)
        close_all : '.piro_close,.piro_overlay'// add class .piro_overlay(with comma)if you want overlay click close piroBox
    });
};

$(document).ready(function() {
    initGallery();
});
