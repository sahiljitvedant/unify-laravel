$(document).ready(function () {
    fetchBlogs(1); // load first page

    function fetchBlogs(page) {
        $("#loader").show();

        $.ajax({
            url: fetchBlogsUrl, // clean URL (no ?page=)
            type: "GET",
            data: { page: page }, // pass page via data object
            success: function (response) {
                $("#loader").hide();
                renderBlogs(response.data);
                renderPagination(response);
            },
            error: function () {
                $("#loader").hide();
                $("#blogsContainer").html('<p class="text-danger text-center">Failed to load blogs.</p>');
            }
        });
    }

    // Render blogs
    function renderBlogs(blogs) {
        let html = '';
        if (blogs.length === 0) {
            html = '<p class="text-center text-muted">No blogs available.</p>';
        } else {
            blogs.forEach(blog => {
                const image = blog.blog_image 
                    ? assetBase + blog.blog_image 
                    : assetBase + 'assets/img/default-blog.jpg';

                html += `
                <div class="col-md-4 mb-4">
    <a href="{{ url('blog_details') }}/${blog.id}" class="text-decoration-none text-dark">
        <div class="blog-card">
            <img src="${image}" alt="Blog Image" class="blog-img">
            <div class="blog-body">
                <h6 class="fw-bold text-theme mb-2">${blog.blog_title}</h6>
                <p class="text-muted small mb-2">${truncate(blog.description, 100)}</p>
                <p class="text-secondary small mb-0">
                    <i class="bi bi-calendar-event"></i> ${formatDate(blog.publish_date)}
                </p>
            </div>
        </div>
    </a>
</div>
`;
            });
        }
        $("#blogsContainer").html(html);
    }

   // Render pagination (Prev | Current | Next)
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
        fetchBlogs(page);
    });

    // Helper functions
    function truncate(text, length) {
        return text.length > length ? text.substring(0, length) + "..." : text;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
    }
});
