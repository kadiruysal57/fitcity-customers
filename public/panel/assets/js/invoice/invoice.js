$('.add_hizmet').click(function(){
    var count = parseInt($('.hizmet_count').val());
    var count_plus = count + 1;
    $('.hizmet_count').val(count_plus)
    var html_data = "<tr class='hizmet_tr_"+count_plus+"'>";
    html_data += '<td><input type="text" class="form-control" name="description"></td>';
    html_data += '<td><input type="number" class="form-control" name="adet"></td>';
    html_data += '<td><input type="number" class="form-control" name="fiyat"></td>';
    html_data += '<td><select name="kdv" id="kdv" class="form-control"><option value="0">0%</option><option value="1">1%</option><option value="1">10%</option><option value="1">20%</option></select></td>';

    html_data += '<td><input type="text" class="form-control"></td>';
    html_data += '<td><input type="text" class="form-control"></td>';
    html_data += '<td><button type="button" data-id="'+count_plus+'" class="btn mt-1 btn-danger deleteHizmet"><i class="fa fa-trash"></i></button></td>'
    html_data += "</tr>";
    $('.invoice_hizmet_table').append(html_data)

    $('.deleteHizmet').click(function(){
        var count = $(this).attr('data-id');
        $('.hizmet_tr_'+count).remove();
    });
});
