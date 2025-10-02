let currentPage = 1;
let perPage = 10;
let loading = false;
let noMoreData = false;
let searchName = '';
let canFetchNext = true; // Flag to prevent multiple triggers

function fetchMembers(page = 1) {
    if (loading || noMoreData) return;
    loading = true;

    if(page > 1) $("#loader").show(); // Loader only for next pages

    $.ajax({
        url: userMyTeamRoute,
        type: "GET",
        data: {
            page: page,
            per_page: perPage,
            search: searchName
        },
        success: function(res) {
            loading = false;
            $("#loader").hide();

            let members = res.data || [];

            if (members.length === 0) {
                noMoreData = true;
                if(page === 1) $("#membersContainer").html('<p class="text-center">No members found</p>');
                return;
            }

            let html = '';
            members.forEach(member => {
                let profileImage = member.profile_image 
                ? window.assetBase + member.profile_image
                : window.assetBase + 'assets/img/default.png';
               
            

                html += `
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="card text-center p-3 shadow-sm">
                        <img src="${profileImage}" 
                             class="rounded-circle mb-2" 
                             alt="${member.first_name}" 
                             style="width:80px; height:80px; object-fit:cover;">
                        <h6 class="mb-0">${member.first_name} ${member.last_name}</h6>
                    </div>
                </div>`;
            });

            if(page === 1) $("#membersContainer").html(html);
            else $("#membersContainer").append(html);
        },
        error: function() {
            loading = false;
            $("#loader").hide();
        }
    });
}

// Search
$(document).on("click", "#btnSearch", function(){
    searchName = $("#searchName").val();
    currentPage = 1;
    noMoreData = false;
    fetchMembers(currentPage);
});

// Cancel
$(document).on("click", "#btnCancel", function(){
    $("#searchName").val('');
    searchName = '';
    currentPage = 1;
    noMoreData = false;
    fetchMembers(currentPage);
});

// // Infinite scroll: only trigger when user reaches bottom
// $(window).on("scroll", function() {
//     if (!canFetchNext) return; // Prevent rapid triggers

//     let scrollTop = $(window).scrollTop();
//     let windowHeight = $(window).height();
//     let docHeight = $(document).height();

//     if(scrollTop + windowHeight >= docHeight - 5) {
//         if(!loading && !noMoreData){
//             canFetchNext = false;  // Lock
//             currentPage++;
//             fetchMembers(currentPage);

//             // Unlock after 500ms to allow next scroll fetch
//             setTimeout(() => { canFetchNext = true; }, 500);
//         }
//     }
// });

// Initial load
$(document).ready(function(){
    fetchMembers();
});
