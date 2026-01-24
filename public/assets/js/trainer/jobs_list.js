let currentPage = 1;

$(document).ready(function () {
    let sortOrder = 'desc';

    function fetchData(page = 1) {
        $("#loader").show();

        $.ajax({
            url: fetchJobList,
            type: "GET",
            data: {
                page: page,
                order: sortOrder,
                job_title: $("#jobTitle").val(),
                city: $("#city").val()
            },
            success: function (res) {
                $("#loader").hide();
                renderCards(res.data);
                renderPagination(res.current_page, res.last_page);
                currentPage = res.current_page;
            }
        });
    }

    function renderCards(data) {
        let cards = '';

        if (data.length === 0) {
            cards = `<div class="col-12 text-center text-muted">No job applications found.</div>`;
        } else {
            data.forEach(job => 
                {
                cards += `
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                            <div class="card-body">
                                <h5 class="card-title">${job.job_title}</h5>
                                <p class="card-text mb-1"><strong>Experience:</strong> ${job.experience_needed}</p>
                                <p class="card-text mb-2"><strong>City:</strong> ${job.city}</p>
                                <div class="d-flex justify-content-between mt-3">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        $("#jobCards").html(cards);
    }

    function renderPagination(currentPage, lastPage) {
        let paginationHtml = `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage - 1}">Prev</a>
            </li>
            <li class="page-item active"><a href="#" class="page-link">${currentPage}</a></li>
            <li class="page-item ${currentPage === lastPage ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${currentPage + 1}">Next</a>
            </li>
        `;
        $("#pagination").html(paginationHtml);
    }

    $(document).on("click", "#pagination .page-link", function (e) {
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
        $("#jobTitle").val('');
        $("#city").val('');
        fetchData(1);
    });

    fetchData();
});

function deleteJobById(id) {
    $.ajax({
        url: deleteJob.replace(':id', id),
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the job.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: response.message,
            }).then(() => {
                location.reload();
            });
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong!',
            });
        }
    });
}
