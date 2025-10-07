let currentPage = 1;
let sortColumn = 'id';
let sortOrder = 'asc';

function fetchPayments(page = 1) {
    $("#loader").show();

    $.ajax({
        url: fetchmypayments,
        type: "GET",
        data: {
            page: page,
            sort: sortColumn,
            order: sortOrder,
            plan_name: $("#plan_name").val(),
            invoice_number: $("#invoice_number").val(),
            amount: $("#amount").val(),
            status: $("#status").val(),
        },
        success: function(res) {
            $("#loader").hide();
            renderTable(res.data);
            renderPagination(res.current_page, res.last_page);
            currentPage = res.current_page;
        },
        error: function() {
            $("#loader").hide();
            $("#paymentsBody").html(`<tr><td colspan="7" class="text-center text-danger">Error fetching data</td></tr>`);
        }
    });
}

function renderTable(data) {
    let rows = '';
    if (data.length === 0) {
        rows = `<tr><td colspan="7" class="text-center">No payments found</td></tr>`;
    } else {
        data.forEach(p => {
            let viewUrl = `/view_invoice/${p.id}`;
            rows += `<tr>
                <td>${p.id}</td>
                <td>${p.invoice_number}</td>
                <td>${p.plan_name}</td>
                <td>₹${parseFloat(p.amount).toFixed(2)}</td>
                <td>${p.status}</td>
            
                <td class="text-center">
                    <a href="${viewUrl}" class="text-primary">
                        <i class="bi bi-eye" style="cursor:pointer;"></i>
                    </a>
                </td>
            </tr>`;
        });
    }
    $("#paymentsBody").html(rows);
}

function renderPagination(current, last) {
    let html = '';
    html += `<li class="page-item ${current === 1 ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${current-1}">Prev</a>
            </li>`;
    html += `<li class="page-item active">
                <a href="#" class="page-link" data-page="${current}">${current}</a>
            </li>`;
    html += `<li class="page-item ${current === last ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${current+1}">Next</a>
            </li>`;
    $("#pagination").html(html);
}

// Pagination click
$(document).on("click", "#pagination .page-link", function(e) {
    e.preventDefault();
    let page = $(this).data("page");
    if (page && page > 0) fetchPayments(page);
});

// Sorting
$(document).on("click", ".sort-link", function(e) {
    e.preventDefault();
    let column = $(this).data("column");
    sortOrder = (sortColumn === column && sortOrder === 'asc') ? 'desc' : 'asc';
    sortColumn = column;

    $(".sort-icons i").removeClass("active");
    if (sortOrder === "asc") $(this).find(".asc").addClass("active");
    else $(this).find(".desc").addClass("active");

    fetchPayments(1);
});

$(document).ready(function() {
    // alert(1);
    // Search button
    $("#btnSearch").on("click", function(e) {
        e.preventDefault();
        fetchPayments(1);
    });

    // Cancel filters
    $("#btnCancel").on("click", function(e) {
        e.preventDefault();
        $("#plan_name, #invoice_number, #amount, #status").val('');
        fetchPayments(1);
    });

    // Initial load
    fetchPayments();
});


// Initial load
$(document).ready(function() { fetchPayments(); });

