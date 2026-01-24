let currentPage = 1;

$(document).ready(function () {

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchDeletedSubHeaders,
            type: "GET",
            data: {
                page: page,
                status: $("#filterActive").val(),
                name: $("#subheaderName").val(),
            },
            success: function (res) {
                $("#loader").hide();
                renderTable(res.data);
                renderPagination(res.current_page, res.last_page);
                currentPage = res.current_page;
            }
        });
    }

    function renderTable(data) {
        let rows = '';

        if (data.length === 0) {
            rows = `
                <tr>
                    <td colspan="5" class="text-center">
                        No records found
                    </td>
                </tr>`;
        } else {
            data.forEach(sh => {
                rows += `
                    <tr>
                        <td>${sh.id}</td>
                        <td>${sh.header_name}</td>
                        <td>${sh.name}</td>
                        <td>${sh.status ? 'Active' : 'Inactive'}</td>
                        <td>${sh.action}</td>
                    </tr>`;
            });
        }

        $("#subheaderBody").html(rows);
    }

    function renderPagination(current, last) {
        let html = `
            <li class="page-item ${current === 1 ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${current - 1}">
                    Prev
                </a>
            </li>

            <li class="page-item active">
                <a href="#" class="page-link">
                    ${current}
                </a>
            </li>

            <li class="page-item ${current === last ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${current + 1}">
                    Next
                </a>
            </li>
        `;

        $("#pagination").html(html);
    }

    // Pagination
    $(document).on("click", "#pagination .page-link", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        if (page > 0) fetchData(page);
    });

    // Search
    $("#submitBtn").on("click", function (e) {
        e.preventDefault();
        fetchData(1);
    });

    // Reset
    $("#btnCancel").on("click", function (e) {
        e.preventDefault();
        $("#filterActive").val('');
        $("#subheaderName").val('');
        fetchData(1);
    });

    fetchData();
});

function activateSubHeaderById(id) {
    $.ajax({
        url: activateSubHeader.replace(':id', id),
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Activating...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (res) {
            Swal.fire({
                icon: 'success',
                title: 'Activated!',
                text: res.message
            }).then(() => {
                window.location.href = "/list_subheaders";
            });
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Something went wrong'
            });
        }
    });
}
