let currentPage = 1;
let sortColumn = 'id';
let sortOrder = 'asc';

$(document).ready(function () {

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: userLoginHistory,  // your route
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
    
        if (!data || data.length === 0) {
            rows = `<tr><td colspan="3" class="text-center">No records found</td></tr>`;
        } else {
            data.forEach(m => {
                rows += `
                    <tr>
                        <td>${m.day}</td>
                        <td>${m.date}</td>
                        <td>${m.cumulative_time ? m.cumulative_time + ' min' : '-'}</td>
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
                <a href="#" class="page-link" data-page="${currentPage}">${currentPage}</a>
            </li>
        `;

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
        if (page && page > 0) fetchData(page);
    });

    // Sorting
    $(document).on("click", ".sort-link", function (e) {
        e.preventDefault();
        let column = $(this).data("column");

        // Toggle order
        sortOrder = (sortColumn === column && sortOrder === 'asc') ? 'desc' : 'asc';
        sortColumn = column;

        $(".sort-icons i").removeClass("active");
        if (sortOrder === "asc") $(this).find(".asc").addClass("active");
        else $(this).find(".desc").addClass("active");

        fetchData(1);
    });

    // Filter/Search click
    $("#submitBtn").on("click", function (e) {
        e.preventDefault();
        fetchData(1);
    });

    // Initial load
    fetchData();
});
