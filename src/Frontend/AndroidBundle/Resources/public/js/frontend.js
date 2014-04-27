//======================================================================================================================
//Запись куки
function setCookie (name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

//======================================================================================================================
//Получние куки
function getCookie(name) {
    var cookie = " " + document.cookie;
    var search = " " + name + "=";
    var setStr = null;
    var offset = 0;
    var end = 0;
    if (cookie.length > 0) {
        offset = cookie.indexOf(search);
        if (offset != -1) {
            offset += search.length;
            end = cookie.indexOf(";", offset);
            if (end == -1) {
                end = cookie.length;
            }
            setStr = unescape(cookie.substring(offset, end));
        }
    }
    return (setStr);
}

//======================================================================================================================
//My content
//======================================================================================================================
addMycontent = function(obj) {
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

//======================================================================================================================
delMycontent = function(obj) {
    $.ajax({
        type: "POST",
        url: "/mycontent/del",
        data: {
            id : $(obj).data('id')
        },
        success: function(response){
            if (response == 1) {
//                $(".post_element[id_content='" + $(obj).data('id') + "']").remove();
                $(obj).parent().hide();
                $(obj).parent().prev().show();
            }
            else {
                alert("Ошибка удаления");
            }
        }
    });
};

//======================================================================================================================
initChangeViewType = function() {
    $(".view_type").click(function(){
        var view_type = $(this).attr("data-view-type");
        setCookie('view_type', view_type, 0, "/");
        $(".post_element").removeClass("line").removeClass("block").addClass(view_type);
        $(".view_type").removeClass("active");
        $(this).addClass("active");
    });
};

//======================================================================================================================
showHideDescription = function() {
    $(".short_description").click(function(){
        if (getSelectionText() === true) return true;
        $(this).hide().next().show();
    });
    $(".full_description").click(function(){
        if (getSelectionText() === true) return true;
        $(this).hide().prev().show();
    });
};

//======================================================================================================================
initGallery = function() {
    $().piroBox({
        my_speed: 400, //animation speed
        bg_alpha: 0.1, //background opacity
        slideShow : true, // true == slideshow on, false == slideshow off
        slideSpeed : 4, //slideshow duration in seconds(3 to 6 Recommended)
        close_all : '.piro_close,.piro_overlay'// add class .piro_overlay(with comma)if you want overlay click close piroBox
    });
};

//======================================================================================================================
//При выделении текста ничего не делать
getSelectionText = function() {
//----------------------------------------------------------------------------------------------------------------------
//Выделение текста (если что то выделяем мышкой - не открывать или не закрывать)
    var txt = '';
    if (window.getSelection)
    {
        txt = window.getSelection();
    }
    else if (document.getSelection)
    {
        txt = document.getSelection();
    }
    else if (document.selection)
    {
        txt = document.selection.createRange().text;
    }

    if (txt != "") return true;

    return false;
//----------------------------------------------------------------------------------------------------------------------
}

//======================================================================================================================
//======================================================================================================================
$(document).ready(function() {
    initGallery();
    initChangeViewType();
    showHideDescription();

    $(".add-mycontent-js").click(function(){
        addMycontent(this);
    });
    $(".del-mycontent-js").click(function(){
        delMycontent(this);
    });
});
