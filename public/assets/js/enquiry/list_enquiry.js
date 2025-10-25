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
    
                rows += `
                    <tr>
                        <td>${e.id}</td>
                        <td>${e.name}</td>
                        <td>${e.email}</td>
                        <td>
                            <span 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="${e.message ? e.message.replace(/"/g, '&quot;') : ''}">
                                ${shortMsg}
                            </span>
                        </td>
                        <td>${e.request_id}</td>
                        <td>${formatDate(e.created_at)}</td>

                        <td>${e.action}</td>
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

let currentReplyId = null;

// Open modal on reply icon click
function replyEnquiryById(id) {
    currentReplyId = id;
    $("#replyMessage").val('');
    $("#replyModal").modal('show');
}

// Set up CSRF token
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Handle send reply
$("#sendReplyBtn").on("click", function () {
    const message = $("#replyMessage").val().trim();
    const $btn = $(this); // reference to the button

    if (!message) {
        alert("Please enter a reply message.");
        return;
    }

    // Disable button + show spinner
    $btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-2"></span> Sending...');

    // Replace :id with actual ID
    const url = replyEnquiryTemplate.replace(':id', currentReplyId);

    $.ajax({
        url: url,
        type: "POST",
        data: { message: message },
        success: function(res) {
            $("#replyModal").modal('hide');
            alert("Reply sent successfully!");
        },
        error: function(err) {
            console.error(err);
            alert("Failed to send reply. Try again.");
        },
        complete: function() {
            // Re-enable button and restore text
            $btn.prop("disabled", false).html("Send Reply");
        }
    });
});


