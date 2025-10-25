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
    let html = '';

    if (data.length === 0) {
        html = `
        <div class="no-members-wrapper">
            <div class="no-members-box">
            <img src="/assets/img/download.png" alt="No Members" class="no-members-img">
                <p class="no-members-text">No Payments Found</p>
            </div>
        </div>
    `;
    } 
    else 
    {
        html += `<div class="row g-3">`; // start row

        data.forEach(p => {
            let viewUrl = `/view_invoice/${p.encoded_id}`;
            let pdfUrl = `${window.assetBase}storage/invoices/invoice_${p.invoice_number}.pdf`;

            html += `
            <div class="col-12 col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div>
                            <h6 class="card-title mb-1">Invoice: ${p.invoice_number}</h6>
                            <p class="mb-1"><strong>Plan:</strong> ${p.plan_name}</p>
                            <p class="mb-1"><strong>Amount:</strong> ₹${parseFloat(p.amount).toFixed(2)}</p>
                            <p class="mb-0"><strong>Status:</strong> ${p.status}</p>
                            <a href="${viewUrl}" class="view-btn d-inline-flex align-items-center justify-content-center mt-3">
                            <i class="bi bi-eye me-1"></i>
                            </a>
                            <a href="${pdfUrl}" 
                            target="_blank"
                            class="download-btn d-inline-flex align-items-center justify-content-center mt-3"
                            title="View Invoice PDF">
                             <i class="bi bi-download me-1"></i>
                         </a>
                        </div>
                        
                    </div>
                </div>
            </div>`;
        });

        html += `</div>`; // end row
    }

    $("#paymentsCards").html(html);
}


function renderPagination(data) {
    let paginationHTML = '';
    const current = data.current_page;
    const last = data.last_page;

    if (last > 1) 
    {
            // First button
        

            // Previous button
            // paginationHTML += `
            //     <li class="page-item ${!data.prev_page_url ? 'disabled' : ''}">
            //         <a href="#" class="page-link" data-page="${current - 1}">
            //             <i class="bi bi-chevron-left"></i>
            //         </a>
            //     </li>`;

                paginationHTML += `
                <li class="page-item ${current === 1 ? 'disabled' : ''}">
                    <a href="#" class="page-link" data-page="1"><<</a>
                </li>`;
            // Sliding window of 3 pages
            let start = current - 1;
            let end = current + 1;

            if (start < 1) {
                start = 1;
                end = Math.min(3, last);
            }
            if (end > last) {
                end = last;
                start = Math.max(1, last - 2);
            }

            for (let i = start; i <= end; i++) {
                paginationHTML += `
                    <li class="page-item ${i === current ? 'active' : ''}">
                        <a href="#" class="page-link" data-page="${i}">${i}</a>
                    </li>`;
            }

            // Last button
            paginationHTML += `
            <li class="page-item ${current === last ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${last}">>></a>
            </li>`;
            // Next button
            // paginationHTML += `
            //     <li class="page-item ${!data.next_page_url ? 'disabled' : ''}">
            //         <a href="#" class="page-link" data-page="${current + 1}">
            //             <i class="bi bi-chevron-right"></i>
            //         </a>
            //     </li>`;
        }

        $("#paginationLinks").html(paginationHTML);
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

