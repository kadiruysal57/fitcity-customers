$(document).ready(function(){
    $('#sing-in-form').on('submit',function(e){
        e.preventDefault();
        $('.loader').show();
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
                if(data.type == "error"){
                    $.each(data.error, function( index, value ) {
                        Toastify({
                            title:"Error",
                            text: value,
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();

                        $('.loader').hide();
                    });

                }
                if(data.type == "success"){
                    window.location.href = data.route_url;
                }




                $('.loader').hide();
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

                $('.loader').hide();
            }

        });
    });
    $('#register-form-pay').on('submit',function(e){
        e.preventDefault();
        $('.loader').show();
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
                if(data.type == "error"){
                    $.each(data.errors, function( index, value ) {
                        Toastify({
                            title:"Error",
                            text: value,
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();

                        $('.loader').hide();
                    });

                }
                if(data.type == "success"){
                    $('.loader').hide();

                    $('#sanal_dcard_modal').modal('show');

                    var iframe = $('#sanaldmodalbodyIframe')[0];
                    var doc = iframe.contentDocument || iframe.contentWindow.document;
                    doc.open();
                    doc.write(data.message);
                    doc.close();
                    iframe.onload = function() {
                        try {
                            var currentUrl = iframe.contentWindow.location.href;
                            if (currentUrl.includes('payment_success')) {
                                $('#sanal_dcard_modal').modal('hide');
                                $('.loader').show();
                                intervalId = setInterval(() => {
                                    $('.loader').hide();
                                    $.ajaxSetup({

                                        headers: {

                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                                        }

                                    });
                                    $.ajax({

                                        type: 'POST',

                                        url: '/register_after_login',

                                        data : {order_number:data.order_number},
                                        success: function (data) {
                                            if(data.type == "error"){
                                                $.each(data.errors, function( index, value ) {
                                                    Toastify({
                                                        title:"Error",
                                                        text: value,
                                                        style: {
                                                            background: "red",
                                                        },
                                                        offset: {
                                                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                                        },
                                                    }).showToast();
                                                });
                                                $('.loader').hide();
                                            }
                                            if(data.type == "success"){
                                                window.location.href = '/membership_information'
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

                                            $('.loader').hide();
                                        }

                                    });
                                    clearInterval(intervalId)
                                }, 3000);
                            } else if (currentUrl.includes('payment_error')) {
                                intervalId = setInterval(() => {
                                    doc.open();
                                    doc.write('');
                                    doc.close();
                                    $('#sanal_dcard_modal').modal('hide');
                                    clearInterval(intervalId)
                                }, 3000);
                            }
                        } catch (e) {
                            console.log('Hata:', e);
                        }
                    };


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

                $('.loader').hide();
            }

        });
    });
});
