$(document).ready(function() {
    let currentPage = 1;
    let sortColumn = 'id';
    let sortOrder = 'desc';
    let userId = null;

    function fetchData(page = 1) {
        if(!userId) return;

        $('#loader').show();
        $('#payment-container').hide();

        $.ajax({
            url: fetchMemberPaymentUrl.replace(':id', userId),
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
                first_name: $('#filterMemberName').val(),
                membership_id: $('#filterMembership').val(),
                email: $('#filterEmail').val(),
                mobile: $('#filterMobile').val()
            },
            success: function(res) {
                $('#loader').hide();
                $('#payment-container').show();
                renderTable(res.data);
                renderPagination(res.current_page, res.last_page);
                currentPage = res.current_page;
            },
            error: function() {
                $('#loader').hide();
                alert('Error fetching payments.');
            }
        });
    }

    function renderTable(data) {
        let html = '';
        if(data.length === 0) {
            html = `<tr><td colspan="8" class="text-center">No Payment found</td></tr>`;
        } else {
            data.forEach(m => {
                const viewUrl = `/view_admin_invoice/${encodeURIComponent(m.encrypted_id)}`;
                const pdfUrl = `/storage/invoices/invoice_${m.invoice_number}.pdf`; 
                html += `
                    <tr>
                        <td>${m.id}</td>
                        <td>${m.membership?.membership_name ?? '-'}</td>
                        <td>${m.amount}</td>
                        <td>${m.discount}</td>
                        <td>${m.total_amount_paid}</td>
                        <td>${m.total_amount_remaining}</td>
                        <td>${m.done_by_user?.name ?? ''}</td>
                        <td>
                            <a href="${viewUrl}"  target="_blank" class="view-btn d-inline-flex align-items-center justify-content-center mt-3"> <i class="bi bi-eye me-1"></i></a>
                            <a href="${pdfUrl}" 
                            target="_blank"
                            class="download-btn d-inline-flex align-items-center justify-content-center mt-3"
                            title="View Invoice PDF">
                             <i class="bi bi-download me-1"></i>
                         </a>
                        </td>
                    </tr>
                `;
            });
        }
        $('#membershipBody').html(html);
    }

    function renderPagination(currentPage, lastPage) {
        let html = '';
        html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a href="#" class="page-link" data-page="${currentPage-1}">Prev</a>
                 </li>`;
        html += `<li class="page-item active">
                    <a href="#" class="page-link" data-page="${currentPage}">${currentPage}</a>
                 </li>`;
        html += `<li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                    <a href="#" class="page-link" data-page="${currentPage+1}">Next</a>
                 </li>`;
        $('#pagination').html(html);
    }

    // Pagination click
    $(document).on('click', '#pagination .page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        if(page && page > 0) fetchData(page);
    });

    // Sorting
    $(document).on('click', '.sort-link', function(e) {
        e.preventDefault();
        let column = $(this).data('column');
        sortOrder = (sortColumn === column && sortOrder === 'asc') ? 'desc' : 'asc';
        sortColumn = column;

        $('.sort-icons i').removeClass('active');
        if(sortOrder === 'asc') $(this).find('.asc').addClass('active');
        else $(this).find('.desc').addClass('active');

        fetchData(1);
    });

    // Filter submit
    $('#submitBtn').on('click', function(e) {
        e.preventDefault();
        fetchData(1);
    });

    // Filter cancel
    $('#btnCancel').on('click', function(e) {
        e.preventDefault();
        $('#filterMemberName, #filterEmail, #filterMembership').val('');
        fetchData(1);
    });

    // User selection
    $('#user_id').on('change', function() {
        userId = $(this).val();
        if(userId) {
            $('#addPaymentBtn').attr('href', `/add_member_payment/${userId}`);
            fetchData(1);
        }
    });
});
