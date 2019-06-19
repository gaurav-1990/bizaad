var base = window.location.origin;
if (base == 'http://localhost')
{
    base = 'http://localhost/bizaad/Panel/';
} else
{
    base = base + "/Panel/";
}


function setFirstTimeAccess(id)
{
   
    $.ajax({
        url: base + "Admin/SadminLogin/setFirstTime",
        data: {data: id},
        type: 'POST',
        beforeSend: function (xhr) {
            $('#setMe').css('position', 'absolute').css('z-index', '9999').css('top', '200px').css('left', '0').css('right', '0').css('text-align', 'center').css('color', 'red').css('font-size', '18px');
            $('#setMe').html('<h5>Loading.... </h5>');
        },
        success: function (data, textStatus, jqXHR) {
            $('#setMe').removeAttr('style');
            $('#setMe').css('position', 'absolute').css('z-index', '9999').css('top', '200px').css('left', '0').css('right', '0');
            $('#setMe').html('');
            $('#setMe').html(data);
        }
    });
}