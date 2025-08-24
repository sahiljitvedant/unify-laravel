var audit_table;
var selected_id = 0;
var table;
var bname;
var bstatus;
var site_blog_global;
var id = $("#site_blog_global").val();;
var page_no = '1';
var limit = '10';
var activeSearchBox = null;

$(document).ready(function() {

    $('#custom-searchPanes').insertBefore($('#custom-searchPanes').find('.dtsp-panesContainer'));

    table = $('#pages_list').DataTable({
        lengthChange: false,
        dom: 'Plfrtip',
        pageLength: 50,
        processing: true,
        serverSide: true,
        "ordering": true,
        responsive: true,
        "aaSorting": [],
        ajax: {
            url: pages_fetch_list,
            type: 'get',
            dataType: 'json',
            data: function(d) {
                d.bname = bname;
                d.bstatus = bstatus;
                d.id = id;
            },
            "beforeSend": function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + ACCESS_TOKEN);
            },
            error: function(xhr, error, code) {
                let resp = xhr.responseJSON;
                $('.dataTables_processing').hide();
            }
        },
        dataSrc: '',
        buttons: [],
        columns: [
            { data: 'site_name' },
            { data: 'title' },
            { data: 'url' },
            { data: 'added_on' },
            { data: 'status' },
            { data: 'id' },
        ],
        searchPanes: {
            initCollapsed: true,
            viewCount: false,
            orderable: false,
            cascadePanes: false,
            dtOpts: {
                text: {
                    targets: [1]
                },
                select: {
                    style: 'multiple'
                }
            }
        },

        "columnDefs": [{
                searchPanes: {
                    show: false,
                },
                targets: [0]
            },
            {
                searchPanes: {
                    show: false
                },
                targets: [1]
            },
            {
                searchPanes: {
                    show: false
                },
                targets: [2],
                orderable: false
            },
            {
                searchPanes: {
                    show: false
                },
                targets: [3]
            },
            {
                "targets": [2],
                "visible": true,
                // "aaSorting": [[ 1, "desc" ]],
                "render": function(data, type, row, meta) {
                    let url = row.url;
                    return '<a href="' + url + '" target="_blank">' + url + '</a>';
                }
            },
            {
                "targets": [4],
                "visible": true,
                // "aaSorting": [[ 1, "desc" ]],
                "render": function(data, type, row, meta) {
                    let status = row.status;
                    if (status == '0') {
                        return "Inactive";
                    } else if (status == '1') {
                        return "Active";
                    } else if (status == '2') {
                        return "Draft";
                    } else if (status == '9') {
                        return "Deleted";
                    }
                }
            },
            {
                "targets": [5],
                "visible": true,
                "orderable": false,
                // "aaSorting": [[ 1, "desc" ]],
                "render": function(data, type, row, meta) {

                    let encodeId = row.encrypted_id;
                    let viewhref = page_view;
                    viewhref = viewhref.replace('slug', encodeId);

                    let href = page_edit;
                    href = href.replace('slug', encodeId);

                    let deletehref = page_delete;
                    deletehref = deletehref.replace('slug', encodeId);

                    let clipBoardImg = assets_url + "/img/clipboard.svg";
                    let viewImg = assets_url + "/img/view-grey.svg";
                    let editImg = assets_url + "/img/edit.svg";
                    let deleteImg = assets_url + "/img/delete.svg";
                    let historyImg = assets_url + "/img/history.svg";
                    let html = `<div class="dropdown actionbtn">
                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 4.0625C10.5178 4.0625 10.9375 3.64277 10.9375 3.125C10.9375 2.60723 10.5178 2.1875 10 2.1875C9.48223 2.1875 9.0625 2.60723 9.0625 3.125C9.0625 3.64277 9.48223 4.0625 10 4.0625Z" stroke="#999999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 10.9375C10.5178 10.9375 10.9375 10.5178 10.9375 10C10.9375 9.48223 10.5178 9.0625 10 9.0625C9.48223 9.0625 9.0625 9.48223 9.0625 10C9.0625 10.5178 9.48223 10.9375 10 10.9375Z" stroke="#999999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 17.8125C10.5178 17.8125 10.9375 17.3928 10.9375 16.875C10.9375 16.3572 10.5178 15.9375 10 15.9375C9.48223 15.9375 9.0625 16.3572 9.0625 16.875C9.0625 17.3928 9.48223 17.8125 10 17.8125Z" stroke="#999999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <ul class="dropdown-menu custom-drp-menu" aria-labelledby="dropdownMenuLink">`;



                    if (action_view_access == 'true') {
                        html = html + '<li><a title="' + Lang.get("global.view") + '"  href="' + viewhref + '" class="dropdown-item">' +
                            '<img src="' + viewImg + '" class="me-2 action" alt="view"> view' +
                            '</a></li>';
                    }

                    if (action_copy_access == 'true') {
                        html = html + '<li><a data-id="' + encodeId + '" data="' + page_duplicate + '" title="' + Lang.get("page.duplicate") + '" href="javascript:void(0)" onclick="create_duplicate(this)" class="dropdown-item">' +
                            '<img src="' + clipBoardImg + '" class="me-2 action" alt="duplicate"> Duplicate' +
                            '</a></li>';
                    }

                    if (action_edit_access == 'true') {
                        html = html + '<li><a title="' + Lang.get("global.edit") + '"  href="' + href + '" class="dropdown-item">' +
                            '<img src="' + editImg + '" class="me-2 action" alt="edit"> Edit' +
                            '</a></li>';
                    }

                    if (action_delete_access == 'true') {
                        html = html + '<li><a data-id="' + encodeId + '" data="' + deletehref + '" title="' + Lang.get("global.delete") + '" href="javascript:void(0)" onclick="delete_blog(this)" class="dropdown-item">' +
                            '<img src="' + deleteImg + '" class="me-2 action" alt="delete"> Delete' +
                            '</a></li>';
                    }

                    html = html + '<li><a  data-id="' + encodeId + '" class="auditHistory dropdown-item" data-bs-toggle="offcanvas" role="button" onclick="show_audit_log(this)">' +
                        '<img src="' + historyImg + '" class="action" alt="history" title="History"  >History' +
                        '</a></li>' +
                        '</ul></div>';

                    return html;
                }
            },
            { bSortable: false, targets: [3] }
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex) {},
    });

    table.on('draw', function() {
        setTimeout(() => {
            $('#custom-searchPanes').insertAfter($('.table-responsive').find('.dtsp-searchPane:first'));
            $('#custom-searchPanes').show();
            if (activeSearchBox !== null) {
                activeSearchBox.focus();
            }
        }, 100);
    });

    var isSearchPaneOpen = true;

    $(document).on('click', function(event) {
        var searchPaneContainer = $('.dtsp-searchPane');
        var searchPaneContainer1 = $('.dtsp-collapseAll');

        if (isSearchPaneOpen && !searchPaneContainer.is(event.target) && searchPaneContainer.has(event.target).length === 0 && !searchPaneContainer1.is(event.target) && searchPaneContainer1.has(event.target).length === 0) {
            searchPaneContainer1.trigger('click');
        }
    });

    table.on('search.dtsp', function(e, dt, type, indexes) {

        var searchPanes = dt._searchPanes.s.panes;
        searchPanes.forEach(searchPane => {
            var toAdd = false;
            if (searchPane.s.serverSelect.length > 0) {
                let sel = searchPane.s.serverSelect[0].display
                toAdd = true;
                $(searchPane.dom.topRow[0]).next('p').remove();
                $(searchPane.dom.topRow[0]).after("<p class='textPrimary fs-12'><span class='fw-600'>Selected :</span> " + sel + "</p>");
            } else {
                $(searchPane.dom.topRow[0]).next('p').empty();
                toAdd = false;
            }
        });
    });

});

function create_duplicate(ele) {

    Swal.fire({
        title: Lang.get('page.promt_are_you_sure'),
        text: Lang.get('page.promt_are_you_sure_duplicate_title'),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: Lang.get("blogs.confirm_button"),
    }).then((isConfirm) => {

        if (isConfirm.isConfirmed) {

            let url = $(ele).attr('data');
            let csrf = $('input [name="_token"]').val();
            let id = $(ele).attr('data-id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url,
                data: { id: id },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + ACCESS_TOKEN);
                    loader_show();
                },
                success: function(response) {
                    loader_hide();
                    if (response.status == 'success') {

                        Swal.fire({
                            title: Lang.get("global.success_page_title"),
                            text: response.message,
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: Lang.get("global.ok"),
                        }).then((isConfirm) => {
                            window.location.href = response.redirecturl;
                        });
                    }
                },
                error: function(error) {
                    loader_hide();
                    let response = error.responseJSON;
                    let errors_msgs = response.message;
                    Swal.fire({
                        title: Lang.get('register.labelerror'),
                        text: Lang.get('register.somethingwentwrong'),
                        icon: 'error',
                        showCloseButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Ok'
                    })
                }
            })
        }
    });

}

function delete_blog(ele) {
    Swal.fire({
        title: Lang.get('page.promt_are_you_sure'),
        text: Lang.get('page.promt_are_you_sure_title'),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: Lang.get("blogs.confirm_button"),
    }).then((isConfirm) => {

        if (isConfirm.isConfirmed) {

            let url = $(ele).attr('data');
            let csrf = $('input [name="_token"]').val();
            let id = $(ele).attr('data-id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: url,
                // dataType: "JSON",
                data: { id: id },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + ACCESS_TOKEN);
                    loader_show();
                },
                complete: function() {

                },
                success: function(response) {
                    loader_hide();
                    if (response.status == 'success') {

                        Swal.fire({
                            title: Lang.get("global.success_page_title"),
                            text: response.message,
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: Lang.get("global.ok"),
                        }).then((isConfirm) => {
                            window.location.reload();
                        });
                    } else {

                    }
                    console.log(response);

                },
                error: function(error) {
                    loader_hide();
                    let response = error.responseJSON;
                    let errors_msgs = response.message;
                    Swal.fire({
                        title: Lang.get('register.labelerror'),
                        text: Lang.get('register.somethingwentwrong'),
                        icon: 'error',
                        showCloseButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Ok'
                    })
                }
            })
        }
    });

}

function change_site(ele) {

    let url = $(ele).attr('data');
    id = $(ele).val();

    if (id != '') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: url,
            data: { id: id },
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + ACCESS_TOKEN);
                loader_show();
            },
            success: function(response) {
                loader_hide();
                if (response.status == 'success') {
                    window.location.reload();
                } else {
                    Swal.fire({
                        title: Lang.get('register.labelerror'),
                        text: Lang.get('register.somethingwentwrong'),
                        icon: 'error',
                        showCloseButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function(error) {
                loader_hide();
                let response = error.responseJSON;
                let errors_msgs = response.message;
                Swal.fire({
                    title: Lang.get('register.labelerror'),
                    text: Lang.get('register.somethingwentwrong'),
                    icon: 'error',
                    showCloseButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Ok'
                })
            }
        })
    }


}

audit_table = $('#audit-log-table').DataTable({
    dom: 'Plfrtip',
    pageLength: 10,
    processing: true,
    serverSide: true,
    rowReorder: {
        selector: 'td:nth-child(2)'
    },
    responsive: true,

    ajax: {
        url: auditlog,
        dataType: 'json',
        "beforeSend": function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + ACCESS_TOKEN);
        },
        data: function(d) {
            d.id = selected_id;
        },
        error: function(xhr, error, code) {
            let resp = xhr.responseJSON;
            $('.dataTables_processing').hide();
            //Wtoastr.warning(resp.message);
        }
    },
    columns: [{
            className: 'dt-control',
            orderable: false,
            data: null,
            defaultContent: '',
        },
        {
            data: 'name',
            name: 'user.name',
            orderable: true
        },
        {
            data: 'event',
            name: 'event',
            orderable: true,
            searchable: true
        },
        {
            data: 'module',
            name: 'module',
            orderable: true
        },

        {
            data: 'date',
            name: 'date',
            orderable: false,
            searchable: false
        },
    ]
});

$('#audit-log-table tbody').on('click', 'td.dt-control', function() {
    var tr = $(this).closest('tr');
    var row = audit_table.row(tr);

    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    } else {
        // Open this row
        row.child(format(row.data())).show();
        tr.addClass('shown');
    }
});

function show_audit_log(ele) {

    let id = $(ele).attr('data-id');
    selected_id = id;
    audit_table.draw();
    // $('.logsWrapper').css('right', '-2rem');
    var myOffcanvas = document.getElementById('auditlog');
    var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
    bsOffcanvas.show();
}

function show_activity_log(ele) {

    let id = $(ele).attr('data-id');
    selected_id = id;
    // audit_table.draw();
    getactivitylog(id)

}

function format(d) {

    return ('<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' + d.row + '</table>');

}

/*
 |Custome search filter adding 
 |
 |
*/

var selected_template_data = '';
$(document).on('click', '#searchData', delay(function(e) {

    var $this = $(this);
    if ($('#bname').val() != '') {

        bname = $('#bname').val();
    }
    if ($('#status').val() != '') {

        bstatus = $('#status').val();
    }
    // activeSearchBox = $this;
    table.draw();
}, 500));

$(document).on('click', '#cancelSearchData, .dtsp-clearAll', delay(function(e) {

    bname = '';
    bstatus = '';
    $('input').val('');
    $('#status').val('');
    // activeSearchBox = $this;
    table.draw();
}, 500));

$('#template').multiselect({
    includeSelectAllOption: true,
    nSelectedText: 'Tags selected',
    nonSelectedText: 'Template For SMS/Robocall',
    enableFiltering: true,
    templates: {
        button: '<button type="button" class="multiselect dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span></button>',
    },
});

$(document).on('change', '.search-custom', delay(function(e) {
    console.log('Time elapsed!', this.value);
    console.log('name', $(this).attr('name'));

    let name = $(this).attr('name');

    if (name == 'campaign_name') {
        campaignname = this.value;
    }

    if (name == 'campaign_date') {
        campaigndate = this.value;
    }

    if (name == 'location') {
        campaignlocation = this.value;
    }
    activeSearchBox = $(this);
    table.draw();

}, 500));

function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this,
            args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function() {
            callback.apply(context, args);
        }, ms || 0);
    };
}

function getactivitylog(id) {

    $.ajax({
        type: "get",
        url: activitylog,
        data: { user_id: id, limit: limit, page_no: page_no },
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + ACCESS_TOKEN);
            loader_show();
        },
        complete: function() {

        },
        success: function(response) {
            loader_hide();
            if (response.status == 'success') {

                $('#activity-list').empty()

                let logs = response.data;
                page_no = response.next_page_no;
                logs.forEach(function(item, value) {
                    $('#activity-list').append(item);
                });

                $('.activitylogsWrapper').css('right', '-2rem');
            } else {
                //Swal.fire({"Error", response.message, "error"});
            }
        },
        error: function(error) {
            loader_hide();
            let response = error.responseJSON;
            let errors_msgs = response.message;
            Swal.fire({
                title: Lang.get('register.labelerror'),
                text: Lang.get('register.somethingwentwrong'),
                icon: 'error',
                showCloseButton: true,
                showCancelButton: false,
                confirmButtonText: 'Ok'
            }).then((result) => {

            })
        }



    })

}