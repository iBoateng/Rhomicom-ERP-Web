
function changeImgSrc(input, imgId, imgSrcLocID) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            //$('#img1Test')
            $(imgId).attr('src', e.target.result);
            $(imgSrcLocID).attr('value',$(input).val());
        };

        reader.readAsDataURL(input.files[0]);
    }
    /*alert('here');
     alert(objct.value);
     var a = $('#img1Test').attr('src');
     alert(a);
     $('#img1Test').attr('src', objct.value);*/
    //document.getElementByID('img1Test').src= objct.value;
}