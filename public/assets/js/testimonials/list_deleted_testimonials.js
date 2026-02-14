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
                status: $("#filterStatus").val(),
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
            rows = `<tr><td colspan="6" class="text-center">No records found</td></tr>`;
        } else {
            data.forEach(t => {
                rows += `
                    <tr>
                        <td>${t.id}</td>
                        <td><img src="/${t.profile_pic}" width="50" height="50" style="border-radius:50%; object-fit:cover;"></td>
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

    $(document).on("click", ".sort-link", function (e) {
        e.preventDefault();
        let column = $(this).data("column");
        sortOrder = (sortColumn === column && sortOrder === 'asc') ? 'desc' : 'asc';
        sortColumn = column;

        $(".sort-icons i").removeClass("active");
        $(this).find(sortOrder === "asc" ? ".asc" : ".desc").addClass("active");

        fetchData(1);
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

function activateTestimonialById(id) {
    $.ajax({
        url: activateTestimonial.replace(':id', id),
        type: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function () {
            Swal.fire({ title: 'Restoring...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        },
        success: function (response) {
            Swal.fire({ icon: 'success', title: 'Restored!', text: response.message })
                .then(() => window.location.href = "/list_testimonials");
        },
        error: function () {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong' });
        }
    });
}
