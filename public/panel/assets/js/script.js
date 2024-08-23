'use strict';


app.config({

    /*
    |--------------------------------------------------------------------------
    | Autoload
    |--------------------------------------------------------------------------
    |
    | By default, the app will load all the required plugins from /assets/vendor/
    | directory. If you need to disable this functionality, simply change the
    | following variable to false. In that case, you need to take care of loading
    | the required CSS and JS files into your page.
    |
    */

    autoload: true,

    /*
    |--------------------------------------------------------------------------
    | Provide
    |--------------------------------------------------------------------------
    |
    | Specify an array of the name of vendors that should be load in all pages.
    | Visit following URL to see a list of available vendors.
    |
    | https://thetheme.io/theadmin/help/article-dependency-injection.html#provider-list
    |
    */

    provide: [],

    /*
    |--------------------------------------------------------------------------
    | Google API Key
    |--------------------------------------------------------------------------
    |
    | Here you may specify your Google API key if you need to use Google Maps
    | in your application
    |
    | Warning: You should replace the following value with your own Api Key.
    | Since this is our own API Key, we can't guarantee that this value always
    | works for you.
    |
    | https://developers.google.com/maps/documentation/javascript/get-api-key
    |
    */

    googleApiKey: '',

    /*
    |--------------------------------------------------------------------------
    | Google Analytics Tracking
    |--------------------------------------------------------------------------
    |
    | If you want to use Google Analytics, you can specify your Tracking ID in
    | this option. Your key would be a value like: UA-XXXXXXXX-Y
    |
    */

    googleAnalyticsId: '',

    /*
    |--------------------------------------------------------------------------
    | Smooth Scroll
    |--------------------------------------------------------------------------
    |
    | By changing the value of this option to true, the browser's scrollbar
    | moves smoothly on scroll.
    |
    */

    smoothScroll: true,

    /*
    |--------------------------------------------------------------------------
    | Save States
    |--------------------------------------------------------------------------
    |
    | If you turn on this option, we save the state of your application to load
    | them on the next visit (e.g. make topbar fixed).
    |
    | Supported states: Topbar fix, Sidebar fold
    |
    */

    saveState: false,

    /*
    |--------------------------------------------------------------------------
    | Cache Bust String
    |--------------------------------------------------------------------------
    |
    | Adds a cache-busting string to the end of a script URL. We automatically
    | add a question mark (?) before the string. Possible values are: '1.2.3',
    | 'v1.2.3', or '123456789'
    |
    */

    cacheBust: '',


});


// Codes to be execute when all JS files are loaded and ready to use
//
app.ready(function () {


    // Page: index.html
    // Earnings chart
    //
    if (window['Chart'] != undefined) {
        new Chart($("#chartjs-earnings"), {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Jun", "Jul"],
                datasets: [
                    {
                        label: "Invoices",
                        backgroundColor: "rgba(51,202,185,0.5)",
                        borderColor: "rgba(51,202,185,0.5)",
                        pointRadius: 0,
                        data: [0, 6000, 8000, 5500, 2000, 5000, 4000]
                    },
                    {
                        label: "Payments",
                        backgroundColor: "rgba(243,245,246,0.8)",
                        borderColor: "rgba(243,245,246,0.8)",
                        pointRadius: 0,
                        data: [9000, 5000, 4000, 2000, 8000, 3000, 9000]
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
            }
        });
    }


    // Page: invoices.html
    // Add a new item row in "create new invoice"
    //
    $(document).on('click', '#btn-new-item', function () {
        var html = '' +
            '<div class="form-group input-group flex-items-middle">' +
            '<select title="Item" data-provide="selectpicker" data-width="100%">' +
            '<option>Website design</option>' +
            '<option>PSD to HTML</option>' +
            '<option>Website re-design</option>' +
            '<option>UI Kit</option>' +
            '<option>Full Package</option>' +
            '</select>' +
            '<div class="input-group-input">' +
            '<input type="text" class="form-control">' +
            '<label>Quantity</label>' +
            '</div>' +
            '<a class="text-danger pl-12" id="btn-remove-item" href="#" title="Remove" data-provide="tooltip"><i class="ti-close"></i></a>' +
            '</div>';

        $(this).before(html);
    });


    // Page: invoices.html
    // Remove an item row in "create new invoice"
    //
    $(document).on('click', '#btn-remove-item', function () {
        $(this).closest('.form-group').fadeOut(function () {
            $(this).remove();
        });
    });


});
$('.get_slug').change(function () {
    slug_get($(this).val(), $(this).attr('focus_input'));
});
var dataTableCount = $('.dataTables');
if(dataTableCount.length > 0){
var dataTable = $('.dataTables').DataTable({
    "language": {
        "url": "/panel/assets/vendor/datatables/language/tr-TR.json",
    },
    "order":[]
});
}
function deleteButton() {
    $('.deleteButton').click(function () {
        var button = $(this);
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

                var table = $(this).attr('data-table');
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });


                $.ajax({

                    type: 'DELETE',

                    url: $(this).attr('data-action'),

                    data: {value: $(this).attr('data-id')},
                    success: function (data) {
                        if (data.type == "success") {
                            if (data.tableRefresh == 1) {
                                dataTable
                                    .row(button.parents('tr'))
                                    .remove()
                                    .draw();
                                table_write_data(data.listData, table);
                                if (typeof button_main_language == "function") {
                                    button_main_language();
                                }
                                if (typeof socialmediaaddmodal == "function") {
                                    socialmediaaddmodal();
                                }
                                if (typeof addressaddmodal == "function") {
                                    addressaddmodal()
                                }
                                if (typeof openhourseaddbutton == "function") {
                                    openhourseaddbutton()
                                }
                            }
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

    });
}
function deleteButton2() {
    $('.deleteButton2').click(function () {
        var button = $(this);
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
                var id = $(this).attr('data-id');
                var table = $(this).attr('data-table');
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });


                $.ajax({

                    type: 'DELETE',

                    url: $(this).attr('data-action'),

                    data: {value: $(this).attr('data-id')},
                    success: function (data) {
                        if (data.type == "success") {
                            $('.tabletr'+id).remove();
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
                        } else{
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

    });
}

deleteButton();
deleteButton2();
var slug_get = function (value, focus_input) {

    $('.preloader').show();
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $.ajax({

        type: 'POST',

        url: '/Kpanel/name_convert_slug',

        data: {value: value},
        success: function (data) {
            if (data.type == "success") {
                $(focus_input).attr('placeholder', data.slug)
            } else {
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
var table_write_data = function (listData, table) {
    var html = "";

    $.each(listData, function (i, data) {
        html += "<tr>";
        $.each(data, function (itwo, appendData) {
            if (itwo == "actions") {
                html += "<td class='text-right table-actions'>" + appendData + "</td>";
            } else {
                html += "<td>" + appendData + "</td>";
            }
        });
        html += "</tr>";
    });
    console.log(html);
    $(table + " tbody").html(html);
    deleteButton();
}
var table_write_data_append = function (listData, table) {
    var html = "";

    $.each(listData, function (i, data) {
        html += "<tr>";
        $.each(data, function (itwo, appendData) {
            console.log(itwo);
            if (itwo == "actions") {
                html += "<td class='text-right table-actions'>" + appendData + "</td>";
            } else {
                html += "<td>" + appendData + "</td>";
            }
        });
        html += "</tr>";
    });
    $(table + " tbody").append(html);
}

function Loader_toggle(t) {
    if (t == "show") {
        $('.preloader').show();
    } else {

        $('.preloader').hide();
    }
}

$('.view_data').click(function(){
    Loader_toggle('show');
    var request_id = $(this).attr('data-requestid');
    var data_id = $(this).attr('data-id');
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $.ajax({

        type: 'POST',

        url: $(this).attr('data-action'),

        data : {data_id:data_id,id:request_id},
        success: function (data) {
            if(data.type == "success"){
                $('#view_data_modal .modal-body').html(data.viewData);
                $('#view_data_modal').modal('show');
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
                Loader_toggle('hide');
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
                    Loader_toggle('hide');
                })
            }

            Loader_toggle('hide');
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

            Loader_toggle('hide');
        }

    });
})
