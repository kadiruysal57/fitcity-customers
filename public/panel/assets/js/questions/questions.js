$('.option_add').click(function(){
    var count = parseInt($('.options_count').val());
    var count_plus = count+1;
    var gender_option = $('.gender_option').val();
    gender_option = JSON.parse(gender_option);
    var gender_option_text = "";
    $.each(gender_option, function (i, value){
        gender_option+="<option value='"+value.id+"'>"+value.question_option+"</option>";
    })
    console.log(gender_option[0])
    $('.options_count').val(count_plus);
    var html_data = "<tr class='new_options_"+count_plus+"'>";
    html_data += "<td><input type='text' class='form-control' name='questions_options[]'></td>"
    html_data += "<td class='text-center'><span id='holder-"+count_plus+"' class='lfm"+count_plus+"' data-input='thumbnail-"+count_plus+"' data-preview='holder-"+count_plus+"'><img src='/panel/assets/img/no-pictures.png'  style='max-width: 32px' ></span><input id='thumbnail-"+count_plus+"' class='form-control' type='hidden' name='questions_options_file_path[]' value=''></td>"
    html_data += "<td><input type='number' class='form-control' name='questions_options_orders[]'></td>"
    html_data += "<td><input type='text' class='form-control' name='questions_options_description[]'></td>"
    html_data += "<td><select name='gender_id[]' class='form-control' id='gender_id'><option value='0'>Hepsinde Göster</option>"+gender_option+"</select></td>"
    html_data += "<td><button type='button' data-id='"+count_plus+"' class='btn btn-danger delete_options'><i class='fa fa-trash'></i></button></td>";
    html_data += "</tr>";
    $('.options_table').append(html_data);

    $('.lfm'+count_plus).filemanager('image',{prefix : '/laravel-filemanager'});
    $('.delete_options').click(function(){
        var count_data = $(this).attr('data-id');
        $('.new_options_'+count_data).remove();
    })
})

$('#questions_create').on('submit',function(e){
    e.preventDefault();

    $('.preloader').show();
    var form = new FormData(this);
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $.ajax({

        type: 'POST',

        url: $(this).attr('action'),

        data : form,
        contentType: false,
        processData: false,
        success: function (data) {
            if(data.type == "success"){
               // $('.preloader').hide();

                window.location.href = data.route_url;
            }else{
                $.each(data.error, function (i, data){
                    Toastify({
                        title:"error",
                        text: data,
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();

                    $('.preloader').hide();
                })
            }
        },
        error: function(data)
        {
            Toastify({
                title:"Error",
                text: "An Error Occurred, please try again later.",
                style: {
                    background: "red",
                },
                offset: {
                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },
            }).showToast();

            $('.preloader').hide();
        }

    });
});
$('#questions_update').on('submit',function(e){
    e.preventDefault();

    $('.preloader').show();
    var form = new FormData(this);
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $.ajax({

        type: 'POST',

        url: $(this).attr('action'),

        data : form,
        contentType: false,
        processData: false,
        success: function (data) {
            if(data.type == "success"){
               $('.preloader').hide();
                $.each(data.success_message_array, function (i, data){
                    Toastify({
                        title:"success",
                        text: data,
                        style: {
                            background: "green",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                })
            }else{
                $.each(data.error, function (i, data){
                    Toastify({
                        title:"error",
                        text: data,
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();

                    $('.preloader').hide();
                })
            }
        },
        error: function(data)
        {
            Toastify({
                title:"Error",
                text: "An Error Occurred, please try again later.",
                style: {
                    background: "red",
                },
                offset: {
                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },
            }).showToast();

            $('.preloader').hide();
        }

    });
});
$('.deleteOption').click(function(){
    var option_id = $(this).attr('data-id');
    Swal.fire({
        title: 'Veri Silinecek Emin Misiniz?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Evet, sil!',
        cancelButtonText: 'Hayır',

    }).then((result) => {
        if (result.isConfirmed) {
            $('.preloader').show();
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });


            $.ajax({

                type: 'POST',

                url: $(this).attr('data-action'),

                data: {value: $(this).attr('data-id'),id:"option_delete"},
                success: function (data) {
                    if (data.type == "success") {
                        $('.options-'+option_id).remove();
                        $.each(data.success_message_array, function (i, data) {
                            Toastify({
                                title: "success",
                                text: data,
                                style: {
                                    background: "green",
                                },
                                offset: {
                                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                    y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                },
                            }).showToast();
                        })
                    } else {
                        $.each(data.error_message_array, function (i, data) {
                            Toastify({
                                title: "Error",
                                text: data,
                                style: {
                                    background: "red",
                                },
                                offset: {
                                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                    y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                },
                            }).showToast();
                        })
                    }
                    $('.preloader').hide();
                },
                error: function (data) {
                    Toastify({
                        title: "Error",
                        text: "An Error Occurred, please try again later.",
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();

                    $('.preloader').hide();
                }

            });
        }
    });

})
$('#option_type').change(function(){
    var value = $(this).val();
    if(value == 2){
        $('.options_content').addClass('d-none');
    }else{
        $('.options_content').removeClass('d-none');
    }
});

