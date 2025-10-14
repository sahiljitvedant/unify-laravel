let currentPage = 1;
$(document).ready(function () 
{
   
    let sortColumn = 'id';
    let sortOrder = 'asc';

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchBlogs,
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
                active: $("#filterActive").val(),
                blogname: $("#blogName").val(),
                trainerName: $("#trainerName").val(),
                joiningDate: $("#joiningDate").val(),
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
            // Show "No memberships found" message spanning all columns
            rows = `
                <tr>
                    <td colspan="7" class="text-center">No records found</td>
                </tr>
            `;
        } else {
            data.forEach(m => {
                rows += `
                    <tr>
                        <td>${m.id}</td>
                        <td>${m.blog_title}</td>
                        <td>${m.is_active ? 'Active' : 'Inactive'}</td>
                        <td>${m.action}</td>
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

        // Current Page (only one active page shown)
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
    
        // Toggle order
        sortOrder = (sortColumn === column && sortOrder === 'asc') ? 'desc' : 'asc';
        sortColumn = column;
    
        // Reset all icons
        $(".sort-icons i").removeClass("active");
    
        // Highlight correct icon
        if (sortOrder === "asc") {
            $(this).find(".asc").addClass("active");
        } else {
            $(this).find(".desc").addClass("active");
        }
    
        fetchData(1); // fetchData should send sortColumn & sortOrder to backend
    });

    // Filters change
   // Search button click
   $("#submitBtn").on("click", function (e) {
    e.preventDefault();
    fetchData(1);
});

// Cancel button click - reset filters
$("#btnCancel").on("click", function (e) {
    e.preventDefault();
    $("#filterActive").val('');
    $("#blogName").val('');
    $("#trainerName").val('');
    $("#joiningDate").val('');
    fetchData(1); // reload data with no filters
});

    // Initial load
    fetchData();
});
function deleteMembershipById(id)
{
    $.ajax({
        url: deleteBlogs.replace(':id', id), 
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the blog.',
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
                // alert('hii');
                location.reload();
            });
        },
        error: function (xhr) {
            console.log(xhr.status);
            console.log(xhr.responseText);

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
