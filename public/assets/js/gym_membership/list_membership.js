$(document).ready(function () 
{
    $('#members-table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: fetchMembership ,

        columns: [
            { data: 'id', name: 'id' },
            { data: 'membership_name', name: 'membership_name' },
            { data: 'duration_in_days', name: 'duration_in_days' },
            { data: 'price', name: 'price' },
            { data: 'trainer_included', name: 'trainer_included' },
            { 
                data: 'is_active', 
                render: function(data) {
                    return data == 1 ? 'Yes' : 'No';
                }
            },
            { data: 'action', orderable: false, searchable: false },
        ],

        order: [[0, 'desc']],
        pageLength: 10,
        responsive: true,
        autoWidth: false
        
    });
});

function deleteMembershipById(id) 
{
    $.ajax({
        url: deleteMembershipUrl.replace(':id', id), 
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Deleting...',
                text: 'Please wait while we delete the membership.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: response.message,
                confirmButtonText: 'OK'
            }).then(() => {
                $('#members-table').DataTable().ajax.reload(); // refresh table
            });
        },
        error: function (xhr) {
            console.log(xhr.status);
            console.log(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please try again.'
            });
        }
    });
}
