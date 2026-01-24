let currentPage = 1;

$(document).ready(function () {
    let sortColumn = 'id';
    let sortOrder = 'desc';

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchCareersUrl,
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
                status: $("#filterActive").val(),
                designation: $("#designation_name").val(),
                work_type: $("#filterWorkType").val(),
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
                    <td colspan="6" class="text-center">No Careers found</td>
                </tr>
            `;
        } else {
            data.forEach(c => {
                rows += `
                    <tr>
                        <td>${c.id}</td>
                        <td>${c.designation}</td>
                        <td>${c.years_of_experience}</td>
                        <td>${c.work_type.toUpperCase()}</td>
                        <td>${c.status ? 'Active' : 'Inactive'}</td>
                        <td>${c.action}</td>
                    </tr>
                `;
            });
        }

        $("#membershipBody").html(rows);
    }

    function renderPagination(currentPage, lastPage) {
        let paginationHtml = "";

        paginationHtml += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage - 1}">Prev</a>
            </li>
        `;

        paginationHtml += `
            <li class="page-item active">
                <a href="#" class="page-link">${currentPage}</a>
            </li>
        `;

        paginationHtml += `
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage + 1}">Next</a>
            </li>
        `;

        $("#pagination").html(paginationHtml);
    }

    // Pagination
    $(document).on("click", "#pagination .page-link", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        if (page && page > 0) {
            fetchData(page);
        }
    });

    // Sorting
    $(document).on("click", ".sort-link", function (e) {
        e.preventDefault();
        let column = $(this).data("column");

        sortOrder = (sortColumn === column && sortOrder === 'asc') ? 'desc' : 'asc';
        sortColumn = column;

        $(".sort-icons i").removeClass("active");

        if (sortOrder === "asc") {
            $(this).find(".asc").addClass("active");
        } else {
            $(this).find(".desc").addClass("active");
        }

        fetchData(1);
    });

    // Search
    $("#submitBtn").on("click", function (e) {
        e.preventDefault();
        fetchData(1);
    });

    // Reset filters
    $("#btnCancel").on("click", function (e) {
        e.preventDefault();
        $("#filterActive").val('');
        $("#designation_name").val('');
        $("#filterWorkType").val('');
        fetchData(1);
    });

    fetchData();
});

function deleteCareer(id) {
    $.ajax({
        url: deleteCareerUrl.replace(':id', id),
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the Career.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: response.message,
                confirmButtonText: 'OK'
            }).then(() => location.reload());
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!'
            }).then(() => location.reload());
        }
    });
}
