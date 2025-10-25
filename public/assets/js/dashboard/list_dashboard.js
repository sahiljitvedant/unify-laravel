let currentPage = 1;
$(document).ready(function ()
{
   
    let sortColumn = 'id';
    let sortOrder = 'asc';
    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchMembership,
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
                first_name: $("#filterMemberName").val(),
                email: $("#filterEmail").val(),
                mobile: $("#filterMobile").val(),
                max_price: $("#filterMaxPrice").val(),
            },
            success: function (res) {
                $("#loader").hide();
                renderTable(res.data);
                renderPagination(res.current_page, res.last_page);
                currentPage = res.current_page;
            }
        });
    }

    function renderTable(data)
    {
        let rows = '';
    
        if (data.length === 0) 
        {
            // Show "No memberships found" message spanning all columns
            rows = `
                <tr>
                    <td colspan="7" class="text-center">No members found</td>
                </tr>
            `;
        } else {
            data.forEach(m => {
                rows += `
                    <tr>
                        <td>${m.id}</td>
                        <td>${m.name}</td>
                        <td>${m.email}</td>
                        <td>${m.membership_name}</td>
                        <td>${m.price}</td>
                        <td>${m.amount_paid}</td>
                        <td>${m.remaining_amount}</td>
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
        if (sortColumn === column) {
            sortOrder = sortOrder === "asc" ? "desc" : "asc";
        } else {
            sortColumn = column;
            sortOrder = "asc"; // default to ascending when changing column
        }
    
        // Reset all icons
        $(".sort-icons i").removeClass("active");
    
        // Highlight correct icon for current column
        const currentSortIcons = $(this).find(".sort-icons i");
        if (sortOrder === "asc") {
            currentSortIcons.filter(".asc").addClass("active");
        } else {
            currentSortIcons.filter(".desc").addClass("active");
        }
    
        // Fetch sorted data
        fetchData(1);
    });
    

    // Filters change
    $("#submitBtn").on("click", function (e) {
        e.preventDefault();
        fetchData(1);
    });

    // Cancel button click - reset filters
    $("#btnCancel").on("click", function (e)
    {
        e.preventDefault();
        $("#filterMemberName").val('');
        $("#filterEmail").val('');
        $("#filterMobile").val('');
        $("#filterMaxPrice").val('');
        fetchData(1); // reload data with no filters
    });

    // Initial load
    fetchData();
});

