// Update Status
function status(id,status,title,yes,no,statusurl,wrong,recordsafe) {
   swal({
      title: title,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
   },
   function(isConfirm) {
      if (isConfirm) {
         $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:statusurl,
            data: {
               id: id,
               status: status
            },
            method: 'POST',
            success: function(response) {
               if (response == 1) {
                  swal.close();
                  window.location.reload();
               } else {
                  swal("Cancelled", wrong, "error");
               }
            },
            error: function(e) {
               swal("Cancelled", wrong, "error");
            }
         });
      } else {
         swal("Cancelled", recordsafe, "error");
      }
   });
}