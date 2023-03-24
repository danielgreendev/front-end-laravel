// Delete item

function deleteitem(id,title,yes,no,deleteurl,wrong,recordsafe,returnurl) {
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

            url:deleteurl,

            data: {id: id},

            method: 'POST',

            success: function(response) {

               if (response == 1) {

                  swal.close();

                  window.location.href = returnurl;

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



// Delete Extra

function deleteextra(id,title,yes,no,deleteurl,wrong,recordsafe) {

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

            url:deleteurl,

            data: {id: id},

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



// Delete Extra

function deletevariants(id,title,yes,no,deleteurl,wrong,recordsafe) {

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

            url:deleteurl,

            data: {id: id},

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



$(document).ready(function(){

   $(".add-item").click(function(){ // Click to only happen on announce links



     $("#category_name").val($(this).attr('data-category-name'));

     $("#cat_id").val($(this).attr('data-cat-id'));

     $('#addItem').modal('show');

   });

   $("#btn_closeItem").click(function() {
      $('#addItem').modal('hide');
   })

   $("#btn_closeItem_").click(function() {
      $('#addItem').modal('hide');
   })

});



$(document).ready(function(){

   $(".edit-extra").click(function(){ // Click to only happen on announce links



     $("#extra_id").val($(this).attr('data-extra-id'));

     $("#extra_name").val($(this).attr('data-extra-name'));

     $("#extra_price").val($(this).attr('data-extra-price'));

     $('#editExtra').modal('show');

   });

});



$(document).ready(function(){

   $(".edit-variants").click(function(){ // Click to only happen on announce links

     $("#variants_id").val($(this).attr('data-variants-id'));

     $("#edit_variants_name").val($(this).attr('data-variants-name'));

     $("#edit_variants_price").val($(this).attr('data-variants-price'));

     $('#editVariants').modal('show');

   });

});

// Delete Category
function deletecategory(id,title,yes,no,deleteurl,wrong,recordsafe) {
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
            url:deleteurl,
            data: {id: id},
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