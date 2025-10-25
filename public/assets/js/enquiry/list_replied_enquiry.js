let currentPage = 1;
function formatDate(dateString) {
    const date = new Date(dateString);

    const day = date.getDate();
    const month = date.toLocaleString('en-US', { month: 'short' }); // e.g. "Oct"
    const year = date.getFullYear();
    const time = date.toLocaleString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    }).replace(' ', '').toUpperCase(); // e.g. "10:25PM"

    return `${day}${month}${year},${time}`;
}

$(document).ready(function () {
    let sortColumn = 'id';
    let sortOrder = 'desc';

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchEnquiry, 
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
                name: $("#name").val(),
                email: $("#email").val(),
                request_id: $("#request_id").val()
            },
            success: function (res) {
                $("#loader").hide();
                renderTable(res.data);
                renderPagination(res.current_page, res.last_page);
                currentPage = res.current_page;
            },
            error: function () {
                $("#loader").hide();
                alert("Error fetching enquiries.");
            }
        });
    }

    function renderTable(data) {
        let rows = '';
    
        if (data.length === 0) {
            rows = `<tr><td colspan="7" class="text-center">No enquiries found</td></tr>`;
        } else {
            data.forEach(e => {
                const shortMsg = e.message
                    ? e.message.substring(0, 10) + (e.message.length > 10 ? "..." : "")
                    : "-";

                    const shortMsg2 = e.reply
                    ? e.reply.substring(0, 10) + (e.reply.length > 10 ? "..." : "")
                    : "-";
    
                rows += `
                    <tr>
                        <td>${e.id}</td>
                        <td>${e.name}</td>
                        <td>${e.email}</td>
                        <td>${e.request_id}</td>
                        <td>
                            <span 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="${e.message ? e.message.replace(/"/g, '&quot;') : ''}">
                                ${shortMsg}
                            </span>
                        </td>
                        <td>
                            <span 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="${e.reply ? e.reply.replace(/"/g, '&quot;') : ''}">
                                ${shortMsg2}
                            </span>
                        </td>

                       
                    </tr>
                `;
            });
        }
    
        $("#membershipBody").html(rows);
    
        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    }
    

    function renderPagination(currentPage, lastPage) 
    {
        let paginationHtml = `
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
    $(document).on("click", ".sort-link", function (e) 
    {
        e.preventDefault();

        let column = $(this).data("column");
        sortOrder = sortColumn === column && sortOrder === "asc" ? "desc" : "asc";
        sortColumn = column;

        // Reset all icons
        $(".sort-icons i").removeClass("active");

        // Highlight selected
        if (sortOrder === "asc") {
            $(this).find(".asc").addClass("active");
        } else {
            $(this).find(".desc").addClass("active");
        }

        fetchData(1);
    });
    $(document).on("click", "#pagination .page-link", function (e) 
    {
        e.preventDefault();
        let page = $(this).data("page");
        if (page && page > 0) {
            fetchData(page);
        }
    });

    $("#submitBtn").on("click", function (e) {
        e.preventDefault();
        fetchData(1);
    });

    $("#btnCancel").on("click", function (e) {
        e.preventDefault();
        $("#name").val('');
        $("#email").val('');
        $("#request_id").val('');
        fetchData(1);
    });

    fetchData();
});
