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
            html = `
                <div class="no-members-wrapper">
                    <div class="no-members-box">
                    <img src="/assets/img/download.png" alt="No Members" class="no-members-img">
                        <p class="no-members-text">No Snapshot Found</p>
                    </div>
                </div>

            `;
        } else {
            galleries.forEach(gallery => {
                const thumb = gallery.main_thumbnail 
                    ? assetBase + gallery.main_thumbnail 
                    : assetBase + 'assets/img/default-gallery.png';

                html += `
                <div class="col-md-4 mb-4">
                    <a href="/member_gallary/${gallery.id}" class="gallery-card d-block position-relative overflow-hidden rounded">
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
    $(document).on("click", ".page-link", function (e) {
        e.preventDefault();
        const page = $(this).data("page");
        fetchGalleries(page);
    });
});
