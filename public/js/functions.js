function GetProduct(thisEAN){
          
    var obj = {};
    obj["setEan"] = thisEAN;

    var jsonString = JSON.stringify(obj)

    $.ajax({
        cache: false,
        url: '/fetchproduct/'+jsonString,
        type: "POST",
        datatype: "json",
        contentType: "application/json; charset=UTF-8",
        error: function (e) {
            if (e.message != "undefined" && e.message != null) {
                alert(e.message);
            }
        },
        data: jsonString,
        success: function (data) {
            var dataObj = JSON.parse(data)
            if(dataObj["result"] == "new"){
                newProductSetup(data);
            }else{
                changeProduct(data);
            }
        }
    });      
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function newProductSetup(dataJSON){
    dataOBJ = JSON.parse(dataJSON);  
    $("#content_product_wrapper input").each(function(){
        $(this).val('');
    });

    $("#product_ean").val(dataOBJ["ean"]);
    $("#product_stock").val("1");
    $("#content_product_wrapper").css("display","block");
}

function newProduct(){
    $("#product_stock").val("1");
    $("#content_product_wrapper").css("display", "block");
}


function refreshTable(){
    location.reload();
}

function submitProduct(){

    var dataOBJ = {};

    let error = false;
    $("#content_product_wrapper input").each(function(){
        if($(this).val() != ""){
            if($(this).attr("data-db") == "picture"){

                var picNameArray = $(this).val().split("\\");
                var pic = picNameArray.pop();
                dataOBJ[$(this).attr("data-db")] = pic;
            }else if($(this).attr("data-db") == "price"){
                var str = $(this).val();
                var regex = /[.,\s]/g;
                var price = str.replace(regex, '');
                dataOBJ[$(this).attr("data-db")] = price;
            }else if($(this).attr("data-db") == "buyprice"){
                var str = $(this).val();
                var regex = /[.,\s]/g;
                var price = str.replace(regex, '');
                dataOBJ[$(this).attr("data-db")] = price;
            }else{
                dataOBJ[$(this).attr("data-db")] = $(this).val();
            }
        }else{
            if($(this).attr("data-db") != "name" && $(this).attr("data-db") != "description"){
                if($(this).attr("data-db") != "picture"){
                    error = true;
                    return false;
                }else{
                    dataOBJ[$(this).attr("data-db")] = "";    
                }
            }else{
                dataOBJ[$(this).attr("data-db")] = $(this).val();
            }
        }

    });

    jsonString = JSON.stringify(dataOBJ);
    if(!error){
        if($("#product_picture_input").val() != ""){
            UploadFile('product_picture_input');
        }
        $("#test").val('updatecreateproduct/'+ JSON.stringify(dataOBJ));
        $.ajax({
            cache: false,
            url: 'updatecreateproduct/'+jsonString,
            type: "POST",
            datatype: "json",
            contentType: "application/json; charset=UTF-8",
            error: function (e) {
                if (e.message != "undefined" && e.message != null) {
                    alert(e.message);
                }
            },
            data: jsonString,
            success: function (data) {
                alert(data);
                $("#content_product_wrapper input").each(function(){
                    $(this).val('');
                });
                $("#product_stock").val("1");
                $("#content_product_wrapper").css("display","none");
                refreshTable();
            }
        });
    }else{
        alert("Vul alle velden in")
    }

}

function changeProduct(dataJSON){
    dataOBJ = JSON.parse(dataJSON);

    let key;
    for (key of Object.keys(dataOBJ)) {
        if(key != 'result'){
            if(key == 'picture'){
                $("#picture_output").attr("src","https://markt.grabyourbag.nl/general/"+dataOBJ[key]);
            }else{
                $("#product_" + key).val(dataOBJ[key]);
            }
        }
    }
    $("#content_product_wrapper").css("display","block");
}


function removeOne(id = 'product_stock'){
    let val = $("#"+id).val();
    let initval = parseInt(val);
    if((initval - 1) > 0){
        initval = initval - 1;
    }else{
        initval = 0;
    }
    $("#"+id).val(initval)
}
function addOne(id = 'product_stock'){
    let val = $("#"+id).val();
    let initval = parseInt(val);
    initval = initval + 1;
    $("#"+id).val(initval);
}



function encodeImagetoBase64() {
    var file = $("#product_picture_input").files[0];
    var reader = new FileReader();
    reader.onloadend = function() {
        $("#picture_output").attr("src",reader.result);
        $("#picture_output_val").val(reader.result);
    }
    reader.readAsDataURL(file);
}



function UploadFile(elementID) {
    if($("#product_ean").val() != ""){
        var file_data = $('#'+elementID).prop('files')[0];
        var errorInfo = "";
        var form_data = new FormData();
        var path = window.location.pathname;
        var page = path.split("/").pop();
        form_data.append('file', file_data);
        $.ajax({
            cache: false,
            type: "POST",
            url: 'uploadfile/' + $("#product_ean").val(),
            dataType: 'text',
            contentType: false,
            processData: false,
            data: form_data,
            success: function(errors){
                errorInfo = errors;
            },
            complete: function(){
                // alert(errorInfo);
            }
        });
    }else{
        alert("Barcode is leeg");
    }

}


function cancelEdit(){
    $("#content_product_wrapper input").each(function(){
        $(this).val('');
    });
    $("#product_stock").val("1");
    $("#content_product_wrapper").css("display","none");
    refreshTable();
}


$(function(){
    var keyTimer;
    var interval = 150;

    $('#product_search').keyup(function () {
        clearTimeout(keyTimer);
        keyTimer = setTimeout(finishedTyping, interval);
    });

    $('#product_search').keydown(function () {
        clearTimeout(keyTimer);
    });


    function finishedTyping () {
        if($('#product_search').val() != ""){
            searchThisValueProduct()
        }else{
            refreshTable();
        }
    }
});

function searchThisValueProduct(){
    if($('#product_search').val() != ""){
        obj = {}
        obj["search"] = $('#product_search').val();
        $.ajax({
            cache: false,
            url: '/searchproducts/' + JSON.stringify(obj),
            type: "POST",
            datatype: "json",
            contentType: "application/json; charset=UTF-8",
            error: function (e) {
                if (e.message != "undefined" && e.message != null) {
                    alert(e.message);
                }
            },
            data: '',
            success: function (data) {
                $("#productsTableWrap").html(data);
            }
        });
    }else{
        refreshTable();
    }

}