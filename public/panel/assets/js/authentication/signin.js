$(document).ready(function(){
    $('#sing-in-form').on('submit',function(e){
        e.preventDefault();
        $('.loader_body').show();
        $('body').addClass("overflow-hidden");
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

                        $('.loader_body').hide();
                        $('body').removeClass("overflow-hidden");
                    });

                }
                if(data.type == "success"){
                    window.location.href = data.route_url;
                }




                $('.loader-body').hide();
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

                $('.loader-body').hide();
            }

        });
    });
    $('#register-form').on('submit',function(e){
        e.preventDefault();
        $('.loader_body').show();
        $('body').addClass("overflow-hidden");
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
                        $('.loader_body').hide();
                        $('body').removeClass("overflow-hidden");
                    });
                }
                if(data.type == "success"){
                    window.location.href = data.route_url;
                }




                $('.loader-body').hide();
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

                $('.loader-body').hide();
            }

        });
    });
});
