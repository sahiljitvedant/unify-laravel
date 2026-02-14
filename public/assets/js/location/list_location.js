let currentPage = 1;

$(document).ready(function () 
{
    let sortColumn = 'id';
    let sortOrder = 'desc';

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchLocationsUrl,
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
                is_active: $("#filterActive").val(),
                location_name: $("#location_name").val(),
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
                    <td colspan="4" class="text-center">No Locations found</td>
                </tr>
            `;
        } else {
            data.forEach(l => {
                rows += `
                    <tr>
                        <td>${l.id}</td>
                        <td>${l.location_name}</td>
                        <td>${l.is_active ? 'Active' : 'Inactive'}</td>
                        <td>${l.action}</td>
                    </tr>
                `;
            });
        }
    
        $("#locationBody").html(rows);
    }

    function renderPagination(currentPage, lastPage) 
    {
        let paginationHtml = "";

        paginationHtml += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage - 1}">Prev</a>
            </li>
        `;

        paginationHtml += `
            <li class="page-item active">
                <a href="#" class="page-link" data-page="${currentPage}">
                    ${currentPage}
                </a>
            </li>
        `;

        paginationHtml += `
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage + 1}">Next</a>
            </li>
        `;

        $("#pagination").html(paginationHtml);
    }

    $(document).on("click", "#pagination .page-link", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        if (page && page > 0) fetchData(page);
    });

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

    $("#submitBtn").on("click", function (e) {
        e.preventDefault();
        fetchData(1);
    });

    $("#btnCancel").on("click", function (e) {
        e.preventDefault();
        $("#filterActive").val('');
        $("#location_name").val('');
        fetchData(1);
    });

    fetchData();
});

function deleteLocation(id)
{
    $.ajax({
        url: deleteLocationUrl.replace(':id', id), 
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the Location.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: response.message
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
