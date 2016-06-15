$(document).ready(function() { 
    $(".left_child_menu").click(function() { 
        var link=$(this).attr("value");
        //console.log(link);
        $("#wrapper").load("__MODULE__/"+link);
    });  

    $("#loginout").click(function(){
        $.get(
                "__MODULE__/Login/loginout",
                function(data){
                    alert(data['message']);
                    window.location.href=data['jumpUrl'];
            });
    });
});