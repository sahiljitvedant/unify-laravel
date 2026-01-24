let currentPage = 1;

$(document).ready(function () 
{
    let sortColumn = 'id';
    let sortOrder = 'desc';

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchHeadersUrl,
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
                status: $("#filterActive").val(),
                title: $("#title_name").val(),
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
                    <td colspan="6" class="text-center">No Headers found</td>
                </tr>
            `;
        } else {
            data.forEach(h => {
                rows += `
                    <tr>
                        <td>${h.id}</td>
                        <td>${h.title}</td>
                        <td>${h.sequence_no}</td>
                        <td>${h.status ? 'Active' : 'Inactive'}</td>
                        <td>${h.action}</td>
                    </tr>
                `;
            });
        }
    
        $("#membershipBody").html(rows);
    }

    function renderPagination(currentPage, lastPage) 
    {
        let paginationHtml = "";

        // Prev Button
        paginationHtml += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage - 1}">Prev</a>
            </li>
        `;

        // Current Page
        paginationHtml += `
            <li class="page-item active">
                <a href="#" class="page-link" data-page="${currentPage}">
                    ${currentPage}
                </a>
            </li>
        `;

        // Next Button
        paginationHtml += `
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage + 1}">Next</a>
            </li>
        `;

        $("#pagination").html(paginationHtml);
    }

    // Pagination click
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

    // Search button
    $("#submitBtn").on("click", function (e) {
        e.preventDefault();
        fetchData(1);
    });

    // Cancel button
    $("#btnCancel").on("click", function (e) {
        e.preventDefault();
        $("#filterActive").val('');
        $("#title_name").val('');
        fetchData(1);
    });

    // Initial load
    fetchData();
});

function deleteHeader(id)
{
    $.ajax({
        url: deleteHeaderUrl.replace(':id', id), 
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the Header.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: response.message,
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                location.reload();
            });
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please try again.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                location.reload();
            });
        }
    });
}
