

  <br>
<div id="container" class="container">
  <div class="row-fluid">
    <div class="row">
      <div class="col-9">
        <h2>List of models from <span style="color: green; font-size: 30px;">(<?php echo $title;?>)</span> </h2>
      </div>
      <div class="col-3">
       <!-- create new material -->
       <?php $validateUser = $this->session->fullname;
       if ($validateUser == 'Admin') {
        ?>
        <div class="container">
          <div class="row-fluid">
            <div class="col-12">
             <button type="button" class="btn btn-primary" id="create_model">
          <i class="mdi mdi-plus-circle"></i>&nbsp;Create new model
        </button>
           </div>
         </div>
       </div>
       <?php } ?>
     </div>
   </div><br>
  <div class="col-12">
    <div class="alert alert-success" style="display: none;"> </div>
    <table id="models" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" width="100%">
     <thead>
      <tr>
       <th>ID</th>
       <th>Models</th>
     </tr>
   </thead>
   <tbody id="model_row">

   </tbody>
 </table>
</div>
</div>
<div class="row-fluid">
 <div class="col-12">&nbsp;</div>
</div>
<!-- button create new department -->

<div class="container">
  <div class="row-fluid">
    <div class="col-12">
      <a href="<?php echo base_url() ?>brand" class="btn btn-info float-left">
        <i class="mdi mdi-arrow-left" ></i>&nbsp;Back to brand
      </a>
    </div>
  </div>
</div>

<!-- create -->
<div id="frmConfirmCreate" class="modal hide fade" tabindex="-1" role="dialog">
 <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title">Create Model</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form action="" id="frm-create">
     <div class="form-inline">
      <label for="">Model: </label> &nbsp;<input type="text" name="model" class="form-control">
      <input type="hidden" value="<?php  echo $idbrand; ?>" name="brandid">
    </div>
  </form>
</div>
<div class="modal-footer">
  <a href="#" class="btn btn-primary" id="saveModel">OK</a>
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
    <p>Are you sure that you want to delete this model?</p>
  </div>
  <div class="modal-footer">
    <a class="btn btn-primary" data-dismiss="modal" id="delete-comfirm" >Yes</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
  </div>
</div>
</div>
</div>
<!-- edit -->
<div id="frmConfirmEdit" class="modal hide fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit model</h5>
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
<script>
 $(document).ready(function() {
  var t = $('#models').DataTable();
  showAllModels();
   // showAllBrand function get brand data to table 
   function showAllModels()
   {
     $.ajax({
       type: 'ajax',
       url: '<?php echo base_url();?>models/showAllModelsByBrandId/<?php echo  $idbrand ?>',
       async: true,
       dataType: 'json',
       success: function(data){
        t.clear().draw();
        var i;
        var n = 1;
        for(i=0; i<data.length; i++){
         t.row.add( [
          n+
          <?php $validateUser = $this->session->fullname;
          if ($validateUser == 'Admin') {
            ?>
            '&nbsp;<a href="#" class="item-edit" dataid="'+data[i].idmodel+'"><i class="mdi mdi-pencil"></i></a>'+
            '<a href="#" class="item-delete text-danger" dataid="'+data[i].idmodel+'"><i class="mdi mdi-delete"></i></a>'
          <?php } ?>,
          data[i].model
          ] ).draw( false );
         n++;
       }
     },
     error: function(){
       alert('Could not get Data from Database');
     }
   });
   }

       // create
       $("#create_model").click( function(){
         // $('#frmConfirmCreate').modal('show');
         $('#frmConfirmCreate').modal('show').on('shown.bs.modal', function(){
            $('input[name=model]').focus();
          });
       });
         // create model by using ajax
         $('#saveModel').on('click', function(){
          var model = $('input[name=model]');
          var result = '';
          if(model.val()==''){
            model.parent().parent().addClass('has-error');
          }else{
            model.parent().parent().removeClass('has-error');
            result +='1';
          }
          if(result=='1'){
           $.ajax({
             url: "<?php echo base_url() ?>models/create_model",
             type: "POST",
             data: $('#frm-create').serialize(),
             dataType: 'json',
             success: function(data){
               if(data.status){
                $('#frm-create')[0].reset();
                $('#frmConfirmCreate').modal('hide');
                $('.alert-success').html('Model was created successfully').fadeIn().delay(6000).fadeOut('slow');
                showAllModels();
              }
            },
            error: function(){
             alert('Error can not create...');
           }
         });
         }
       });

        // delete model by ajax
        $('#model_row').on('click', '.item-delete', function(){
         var id = $(this).attr('dataid');
         $('#frmConfirmDelete').data('id', id).modal('show');
       });
         // comfirm delete button
         $("#delete-comfirm").on('click',function(){
           var id = $('#frmConfirmDelete').data('id');     
           $.ajax({
             url: "<?php echo base_url() ?>models/deleteModel",
             type: "POST",
             data: {idmodel: id},
             dataType: "json",
             success: function(data){
                 // alert('Owner deleted successfully....');
                 $('#frmConfirmDelete').modal('hide');
                 $('.alert-success').html('Model was deleted successfully').fadeIn().delay(6000).fadeOut('slow');
                 showAllModels();
               },
               error: function(){
                 alert("Error delete!! this model have relationship with another field...");
               }
             });
         });

       //   // update model modal pop up by ajax
       $('#model_row').on('click', '.item-edit', function(){
         var id = $(this).attr('dataid');
         $.ajax({
           type: 'POST',
           data: {idmodel: id},
           url: '<?php echo base_url();?>/models/showEditModel/<?php echo $idbrand; ?>',
           async: true,
           dataType: 'json',
           success: function(data){
             $('#frm_edit').html(data);
             // $('#frmConfirmEdit').modal('show');
              $('#frmConfirmEdit').modal('show').on('shown.bs.modal', function(){
            $('input[name=update_model]').focus();
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
          var model = $('input[name=update_model]');

          var result = '';
          if(model.val()==''){
            model.parent().parent().addClass('has-error');
          }else{
            model.parent().parent().removeClass('has-error');
            result +='1';
          }
          if(result=='1'){
            // alert('the bes');
            $.ajax({
             url: "<?php echo base_url();?>models/update",
             type: "POST",
             data: $('#frm_edit').serialize(),
             dataType: 'json',
             success: function(data){
               if(data.status){
                 $('#frm_edit')[0].reset();
                 $('#frmConfirmEdit').modal('hide');
                 $('.alert-success').html('Model was updated successfully').fadeIn().delay(6000).fadeOut('slow');
                 showAllModels();
               }
             },
             error: function(){
               alert("Error edit this model have relationship with another field...");
               $('#frmConfirmEdit').modal('hide');
             }
           });
          }
        });

       });

     </script>