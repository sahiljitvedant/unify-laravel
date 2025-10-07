$(document).ready(function () {
    fetchGalleries(1); // load first page

    function fetchGalleries(page) {
        $("#loader").show();

        $.ajax({
            url: fetchBlogsUrl,
            type: "GET",
            data: { page: page },
            success: function (response) {
                $("#loader").hide();
                renderGalleries(response.data);
                renderPagination(response);
            },
            error: function () {
                $("#loader").hide();
                $("#blogsContainer").html('<p class="text-danger text-center">Failed to load galleries.</p>');
            }
        });
    }

    // Render galleries
    function renderGalleries(galleries) {
        let html = '';
        if (galleries.length === 0) {
            html = '<p class="text-center text-muted">No galleries available.</p>';
        } else {
            galleries.forEach(gallery => {
                const thumb = gallery.main_thumbnail 
                    ? assetBase + gallery.main_thumbnail 
                    : assetBase + 'assets/img/default-gallery.png';

                html += `
                <div class="col-md-4 mb-4">
                <a href="/gallery/${gallery.id}" class="gallery-card d-block position-relative overflow-hidden rounded">
                    <img src="${thumb}" alt="${gallery.gallery_name}" class="gallery-img w-100 rounded">
                    <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <span class="gallery-name text-white fw-bold">${gallery.gallery_name}</span>
                    </div>
                </a>
            </div>`;
            });
        }
        $("#blogsContainer").html(html);
    }

    // Render pagination
    function renderPagination(data) {
        let paginationHTML = '';
        if (data.last_page > 1) {
            paginationHTML += `<li class="page-item ${!data.prev_page_url ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${data.current_page - 1}"><i class="bi bi-chevron-left"></i></a>
            </li>`;

            for (let i = 1; i <= data.last_page; i++) {
                paginationHTML += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                </li>`;
            }

            paginationHTML += `<li class="page-item ${!data.next_page_url ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${data.current_page + 1}"><i class="bi bi-chevron-right"></i></a>
            </li>`;
        }
        $("#paginationLinks").html(paginationHTML);
    }

    // Pagination click
    $(document).on("click", ".page-link", function (e) {
        e.preventDefault();
        const page = $(this).data("page");
        fetchGalleries(page);
    });
});
