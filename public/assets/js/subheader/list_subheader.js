let currentPage = 1;

$(document).ready(function () {

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchSubHeadersUrl,
            type: "GET",
            data: {
                page: page,
                status: $("#filterActive").val(),
                header_id: $("#headerFilter").val(),
                name: $("#subheader_name").val(),
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
                    <td colspan="5" class="text-center">No SubHeaders found</td>
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
                <a href="#" class="page-link" data-page="${current - 1}">Prev</a>
            </li>

            <li class="page-item active">
                <a href="#" class="page-link">${current}</a>
            </li>

            <li class="page-item ${current === last ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${current + 1}">Next</a>
            </li>
        `;

        $("#pagination").html(html);
    }

    $(document).on("click", "#pagination .page-link", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        if (page > 0) fetchData(page);
    });

    $("#submitBtn").on("click", function (e) {
        e.preventDefault();
        fetchData(1);
    });

    $("#btnCancel").on("click", function (e) {
        e.preventDefault();
        $("#filterActive").val('');
        $("#headerFilter").val('');
        $("#subheader_name").val('');
        fetchData(1);
    });

    fetchData();
});

function deleteSubHeader(id) {
    $.ajax({
        url: deleteSubHeaderUrl.replace(':id', id),
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Deleting...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (res) {
            Swal.fire('Deleted!', res.message, 'success')
                .then(() => location.reload());
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong', 'error');
        }
    });
}
