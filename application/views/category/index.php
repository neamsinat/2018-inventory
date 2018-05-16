

<div id="container" class="container">
  <div class="row-fluid">
    <div class="row">
      <div class="col-9">
        <h2><?php echo $title;?></h2>
      </div>
      <div class="col-3">
       <!-- create new location -->
       <?php $validateUser = $this->session->fullname;
       if ($validateUser == 'Admin') {
        ?>
        <div class="container">
          <div class="row-fluid">
            <div class="col-12">
             <button type="button" class="btn btn-primary create-category" id="add_category">
              <i class="mdi mdi-plus-circle"></i>&nbsp;Create new category
            </button> 
           </div>
         </div>
       </div>
       <?php } ?>
     </div>
   </div><br>
  <div class="col-12">
    <div class="alert alert-success" style="display: none;">

    </div>
    <table id="category" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Category</th>
        </tr>
      </thead>
      <tbody id="displayCat">

      </tbody>
    </table>
  </div>
</div>


<div id="frmConfirmAdd" class="modal hide fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="frm_create">
        <div class="modal-body">
          <div class="form-inline">
            <label for="">Category</label> &nbsp;

            <input type="text" name="createCategory" class="form-control">

          </div>
        </div>
      </form>
      <div class="modal-footer">
        <a href="#" class="btn btn-primary" id="btn-create">OK</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- delete  -->
<div id="frmConfirmDelete" class="modal hide fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure that you want to delete this category?</p>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-primary" id="delete-comfirm">Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
 <!-- Edite -->
    <div id="frmConfirmEdit" class="modal hide fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="frm_edit">
              <div class="form-inline">
                
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-primary create" id="update">OK</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
<!-- link bootstrap4 and javaScipt -->
<link href="<?php echo base_url();?>assets/DataTable/DataTables-1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(function() {

      // $('[data-toggle="tooltip"]').tooltip();
      var c = $('#category').DataTable();
      showAllCat();
      function showAllCat()
      {
        $.ajax({
          type: 'ajax',
          url: '<?php echo base_url() ?>/category/showAllCategory',
          async: true,

          dataType: 'json',
          success: function(data){
            c.clear().draw();
            var i;
            var n = 1;

            for(i=0; i<data.length; i++){
              c.row.add ( [
                n+
                <?php $validateUser = $this->session->fullname;
                if ($validateUser == 'Admin') {
                  ?>
                  '&nbsp;<a href="#" class="item-edit" dataid="'+data[i].idcategory+'"><i class="mdi mdi-pencil"></i></a>'+
                  '&nbsp;<a href="#" class="item-delete text-danger" dataid="'+data[i].idcategory+'"><i class="mdi mdi-delete"></i></a>'
                  <?php } ?>,

                  data[i].category
                  ] ).draw( false );
              n++;    
            }

          },
          error: function(){
            alert('Could not get Data from Database');
          }
        });
      }
        // create_owner with ajax
        $("#add_category").click(function(){
          $('#frmConfirmAdd').modal('show').on('shown.bs.modal', function(){
            $('input[name=createCategory]').focus();
          });
        });
        // save new category button even
        $("#btn-create").click(function(){
          // validate form
          var category = $('input[name=createCategory]');
          // var address = $('textarea[name=txtAddress]');
          var result = '';
          if(category.val()==''){
            category.parent().parent().addClass('has-error');
          }else{
            category.parent().parent().removeClass('has-error');
            result +='1';
          }
          if (result=='1') {
            $.ajax({
              url: "<?php echo base_url()?>category/create",
              type: "POST",
              data: $('#frm_create').serialize(),
              dataType: 'json',
              success: function(data){
                if(data.status){
                  $('#frm_create')[0].reset();
                  $('#frmConfirmAdd').modal('hide');
                  
                  $('.alert-success').html('Category was added successfully').fadeIn().delay(6000).fadeOut('slow');
                  showAllCat();
                }
              },
              error: function(){
                alert("Error ...");
              }
            });
          }
        });

       // update category modal pop up by ajax
       $('#displayCat').on('click', '.item-edit', function(){
         var id = $(this).attr('dataid');
         $.ajax({
           type: 'POST',
           data: {idcategory: id},
           url: '<?php echo base_url();?>/category/showEditCategory',
           async: true,
           dataType: 'json',
           success: function(data){
             $('#frm_edit').html(data);
             $('#frmConfirmEdit').modal('show').on('shown.bs.modal', function(){
            $('input[name=update_category]').focus();
          });
           },
           error: function(){
             alert('Could not get any data from Database');
           }
         });
       });


  // save update button 
  $("#update").click(function(){
   var id = $('#frmConfirmEdit').data('id');
   var categoryName = $('input[name=update_category]');
   var result = '';
   if(categoryName.val()==''){
     categoryName.parent().parent().addClass('has-error');
   }else{
     categoryName.parent().parent().removeClass('has-error');
     result +='1';
   }
   if (result=='1') {
     $.ajax({
       url: "<?php echo base_url()?>/category/update",
       type: "POST",
       data: $('#frm_edit').serialize(),
       dataType: 'json',
       success: function(data){
         if(data.status){
           $('#frm_edit')[0].reset();
           $('#frmConfirmEdit').modal('hide');
           $('.alert-success').html('Category was updated successfully').fadeIn().delay(6000).fadeOut('slow');
           showAllCat();
         }
       },
       error: function(){
         $('#frmConfirmEdit').modal('hide');
         alert("Error Update! This field has relationship with another field...");
       }
     });
   }
 });

    // delete category by ajax
    $('#displayCat').on('click', '.item-delete', function(){
      var id = $(this).attr('dataid');
      $('#frmConfirmDelete').data('id', id).modal('show');
    });
      // comfirm delete button
      $("#delete-comfirm").on('click',function(){
        var id = $('#frmConfirmDelete').data('id');
        $.ajax({
          url: "<?php echo base_url() ?>category/deleteCategory",
          type: "POST",
          data: {idcategory: id},
          dataType: "json",
          success: function(data){
            $('#frmConfirmDelete').modal('hide');
            $('.alert-success').html('Category was deleted successfully').fadeIn().delay(6000).fadeOut('slow');
            showAllCat();
          },
          error: function(){
            $('#frmConfirmDelete').modal('hide');
            alert("Error delete! this category has relationship with another field...");
          }
        });
      });

    });
  </script>

