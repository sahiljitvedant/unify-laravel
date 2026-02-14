let currentPage = 1;

$(document).ready(function () {
    let sortColumn = 'id';
    let sortOrder = 'desc';

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchTestimonials,
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
                is_active: $("#filterStatus").val(),
                name: $("#clientName").val()
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
            rows = `<tr><td colspan="5" class="text-center">No records found</td></tr>`;
        } else {
            data.forEach(t => {
                rows += `
                    <tr>
                        <td>${t.id}</td>
                        <td>${t.name}</td>
                        <td>${t.position ?? '-'}</td>
                        <td>${t.is_active == 1 ? 'Active' : 'Inactive'}</td>
                        <td>${t.action}</td>
                    </tr>
                `;
            });
        }

        $("#testimonialBody").html(rows);
    }

    function renderPagination(currentPage, lastPage) {
        let paginationHtml = `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage - 1}">Prev</a>
            </li>
            <li class="page-item active">
                <a href="#" class="page-link">${currentPage}</a>
            </li>
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage + 1}">Next</a>
            </li>
        `;
        $("#pagination").html(paginationHtml);
    }

    $(document).on("click", "#pagination .page-link", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        if (page) fetchData(page);
    });

    $("#submitBtn").on("click", function (e) {
        e.preventDefault();
        fetchData(1);
    });

    $("#btnCancel").on("click", function (e) {
        e.preventDefault();
        $("#filterStatus").val('');
        $("#clientName").val('');
        fetchData(1);
    });

    fetchData();
});

/* 🔥 RENAMED FUNCTION */
function deleteTestimonialRecord(id) {
    $.ajax({
        url: deleteTestimonial.replace(':id', id),
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function () {
            Swal.fire({ title: 'Deleting...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        },
        success: function (response) {
            Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message })
                .then(() => location.reload());
        },
        error: function () {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong' })
                .then(() => location.reload());
        }
    });
}
