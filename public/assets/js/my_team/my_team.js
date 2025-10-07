$(document).ready(function () {
    let currentPage = 1;

    function fetchMembers(page = 1) {
        $("#loader").show();

        $.ajax({
            url: userMyTeamRoute,
            type: "GET",
            data: { 
                page: page,
                per_page: 12,
                search: $("#searchName").val()
            },
            success: function(res) {
                $("#loader").hide();
                renderMembers(res.data);
                renderPagination(res);
            },
            error: function () {
                $("#loader").hide();
                $("#membersContainer").html('<p class="text-center text-danger">Failed to load members.</p>');
            }
        });
    }

    function renderMembers(members) {
        let html = '';
        if (members.length === 0) {
            html = '<p class="text-center text-muted">No team members found.</p>';
        } else {
            members.forEach(member => {
                let profileImage = member.profile_image 
                    ? assetBase + member.profile_image 
                    : assetBase + 'assets/img/download.png';

                let fullName = `${member.first_name} ${member.last_name}`;
                let displayName = fullName.length > 15 ? fullName.substring(0, 15) + '...' : fullName;

                html += `
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a class="my_team_card" href="/my_team/${member.id}">
                        <div class="card text-center p-3 shadow-sm">
                            <img src="${profileImage}" 
                                onerror="this.onerror=null; this.src='${assetBase}assets/img/carousel-3.jpg'"
                                class="rounded-circle mb-2"
                                alt="${member.first_name}"
                                style="width:80px; height:80px; object-fit:cover;">
                            <h6 class="mb-0">${displayName}</h6>
                        </div>
                    </a>
                </div>`;
            });
        }
        $("#membersContainer").html(html);
    }

    function renderPagination(data) {
        let paginationHTML = '';

        if (data.last_page > 1) {
            // Previous button
            paginationHTML += `<li class="page-item ${!data.prev_page_url ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${data.current_page - 1}"><i class="bi bi-chevron-left"></i></a>
            </li>`;

            // Page numbers
            for (let i = 1; i <= data.last_page; i++) {
                paginationHTML += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                </li>`;
            }

            // Next button
            paginationHTML += `<li class="page-item ${!data.next_page_url ? 'disabled' : ''}">
                <a href="#" class="page-link" data-page="${data.current_page + 1}"><i class="bi bi-chevron-right"></i></a>
            </li>`;
        }

        $("#paginationLinks").html(paginationHTML);
    }

    // Pagination click
    $(document).on("click", ".page-link", function(e) {
        e.preventDefault();
        const page = $(this).data("page");
        if (!page) return;
        fetchMembers(page);
    });

    // Search
    $(document).on("click", "#btnSearch", function() {
        fetchMembers(1);
    });

    // Cancel
    $(document).on("click", "#btnCancel", function() {
        $("#searchName").val('');
        fetchMembers(1);
    });

    // Initial load
    fetchMembers();
});
