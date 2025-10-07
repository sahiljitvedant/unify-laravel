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
