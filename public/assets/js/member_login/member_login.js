$(document).ready(function () 
{
    $('.btn-success, .btn-danger').on('click', function() 
    {
        let actionType = $(this).hasClass('btn-success') ? 'login' : 'logout';

        $('.btn-success, .btn-danger').prop("disabled", true);

        let dataToSend = 
        {
            action: actionType,
            user_id: USER_ID, 
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax
        ({
            url: LogIN,
            type: "POST",
            data: dataToSend,
            beforeSend: function ()  
            {
                Swal.fire({
                    title: 'Submitting...',
                    text: 'Please wait while we process your request.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) 
            {

                if(response.status === 'success') 
                {
                    let title = actionType === 'login' ? 'Login Successful!' : 'Logout Successful!';
                    let htmlMessage = '';

                    if(actionType === 'login') {
                        htmlMessage = 'Your current login count: <b>' + response.login_count + '</b>';
                    } else {
                        htmlMessage = 'Session time: <b>' + response.total_time + ' min</b><br>' +
                                      'Total cumulative time: <b>' + response.cumulative_time + ' min</b>';
                    }

                    Swal.fire({
                        icon: 'success',
                        title: title,
                        html: htmlMessage,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then(() => {
                       
                        window.location.reload();
                    });
                } 
                else if(response.status === 'error') 
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then(() => {
                       
                        window.location.reload();
                    });
                } 
            },
            error: function(xhr) {
              
                $('.btn-success, .btn-danger').prop("disabled", false);
                console.log(xhr.status);
                console.log(xhr.responseText);
                Swal.fire
                ({
                    icon: 'error',
                    title: 'Server Error!',
                    text: 'An error occurred. Check console for details.',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                });
            }
        });
    });
});

let currentPage = 1;
let sortColumn = 'id';
let sortOrder = 'asc';

$(document).ready(function () 
{

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchLogin, 
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
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
            rows = `<tr><td colspan="4" class="text-center">No records found</td></tr>`;
        } 
        else 
        {
            data.forEach(m => {
                rows += `
                    <tr>
                     
                        <td>${m.log_in_time ?? '-'}</td>
                        <td>${m.log_out_time ?? '-'}</td>
                        <td>${m.total_time ? m.total_time + ' min' : '-'}</td>
                        <td>${m.total_time ? m.total_time + ' min' : '-'}</td>
                    </tr>
                `;
            });
        }
        $("#loginBody").html(rows);
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

        fetchData(1);
    });

    // Initial fetch
    fetchData();
});
$(document).ready(function () 
{

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchLogin2, 
            type: "GET",
            data: {
                page: page,
                sort: sortColumn,
                order: sortOrder,
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
                let dbDate = m.date ? new Date(m.date) : null;
    
                let day = m.day ?? '-';
                let date = dbDate ? dbDate.toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
    
                rows += `
                    <tr>
                        <td>${day}</td>
                        <td>${date}</td>
                        <td>${m.cumulative_time ? m.cumulative_time + ' min' : '-'}</td>
                       
                    </tr>
                `;
            });
        }
    
        $("#loginBodyDeatil").html(rows);
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

        fetchData(1);
    });

    // Initial fetch
    fetchData();
});