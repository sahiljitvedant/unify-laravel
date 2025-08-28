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

function activateMembershipID(id) 
{
    $.ajax({
        url: activateMembershipUrl.replace(':id', id), 
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            Swal.fire({
                title: 'Activating...',
                text: 'Please wait while we activate the membership.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Activated!',
                text: response.message,
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "/list_membership"; // refresh table
            });
        },
        error: function (xhr) {
            console.log(xhr.status);
            console.log(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please try again.',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                $('#members-table').DataTable().ajax.reload(); // refresh table
            });
               
          
        }
    });
}
