<style> 
.dt-buttons .buttons-colvis{
  background:#007bff;
  color: #fff;
  border: 1px solid #9990;
  border-radius: 2px;
}
.dt-buttons>.buttons-colvis:hover{
  background:#0872e4 !important;
  color: #fff;
  border: 1px solid #6660  !important;
  border-radius: 2px;
}
.dt-button-collection .dt-button{
  /*background: #0094e1 !important;*/
  /*color: #fff !important;*/
  border: 1px solid #6660  !important;
  border-radius: 3px !important;
}
.dt-button-collection .dt-button:hover{
  background: #007bff !important;
  color: #fff !important;
  border-radius: 2px !important;
}
</style>
<br>
<div id="container">
	<div class="row-fluid">
		<div class="col-12">
      <div class="row">
        <div class="col-10">
          <h2><?php echo $title;?></h2>
        </div>
        <div class="col-2">
          <a href="<?php echo base_url();?>items/create" class="btn btn-primary"><i class="mdi mdi-plus-circle"></i>&nbsp;Create a new item</a>
        </div>
      </div>
    </div><br>
    <div class="alert alert-success" style="display: none;"></div>
    <div class="table-responsive">
      <table id="items" cellpadding="0" cellspacing="0" class="table table-striped table-bordered display" width="100%">
       <colgroup>
        <col span="1" style="background-color:#eff3f7;">
      </colgroup>
      <thead>
        <tr>
          <th class="permanent">Identifier</th>
          <th>Name</th>
          <th>Category</th>
          <th>Material</th>
          <th>Condition</th>
          <th>Department</th>
          <th>Location</th>
          <th>User</th>
          <th>Owner</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="showdata">


      </tbody>
    </table>
  </div>
</div>
</div>
<div class="row-fluid"><div class="col-12">&nbsp;</div></div>


<!-- delete -->
<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure that you want to delete this item</p>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-primary" id="delete-comfirm">Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>


<!-- view detail -->
<div id="viewDetailModal" class="modal hide fade " tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content ">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Item detail:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light">
        <table width="100%" class="table">
          <colgroup>
            <col span="1" style="background-color:#eff3f7;">
          </colgroup>
          <tbody id="frm_view">

          </tbody>
        </table>
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
      </div>     
    </div>
  </div>
</div>

</div>

<link href="<?php echo base_url();?>assets/DataTable/DataTables-1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- columns visibility and reorder datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.4.1/css/colReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<!-- fixcolumns -->
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.dataTables.min.css">


<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/DataTable//DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<!-- columns visibility and reorder datatable -->
<script src="https://cdn.datatables.net/colreorder/1.4.1/js/dataTables.colReorder.min.js"></script>
<!-- fixed columns -->
<script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    var t = $('#items').DataTable({
      colReorder: true,
      responsive: true,
      'ajax':{
        'type': 'GET',
        'url':'<?php echo base_url();?>items/showAllitems',
        'dataType':'json'
      },
      "colReorder": {
        fixedColumnsLeft:1,
      },
      "dom":"Bfrtip",
      stateSave: true,
      "buttons":[
      {
        extend:'colvis',
        columns:':not(.permanent)'
      }]
    });
    showAllitems();
// showAllitems function get items data to table 
function showAllitems()
{
  $.ajax({
    type: 'ajax',
    url: '<?php echo base_url();?>items/showAllitems',
    async: true,
    dataType: 'json',
    success: function(data){
      t.clear().draw();
      var n = 1;
      var i;
      var status="";
      for(i=0; i<data.length; i++){
        if (data[i].status=='0') {
          status='Available';
        }else{
          status='Not available';
        }
        <?php $validateUser = $this->session->fullname;?>


        t.row.add( [
          data[i].itemcodeid+
          '&nbsp;<?php  
          if ($validateUser == 'Admin') {
           ?><a href="<?php echo base_url() ?>items/edit/'+data[i].iditem+'" class="item-edit" dataid="'+data[i].iditem+'"><i class="mdi mdi-pencil"></i></a>'+
           '<a href="#" class="item-delete text-danger" dataid="'+data[i].iditem+'"><i class="mdi mdi-delete"></i></a> <?php } ?>'+
           '<a href="#" class="item-view" dataid="'+data[i].iditem+'"><i class="mdi mdi-eye text-primary"></i></a>'
           ,
           data[i].item,data[i].cat,data[i].mat,data[i].condition,data[i].depat,data[i].locat,data[i].nameuser,data[i].owner,'<span class="text-primary">'+status+' </span>'
           ] ).draw( false );
        n++;
      }
    },
    error: function(){
      alert('Could not get Data from Database');
    }
  });
}
// delete item by ajax
$('#showdata').on('click', '.item-delete', function(){
  var id = $(this).attr('dataid');
  $('#deleteModal').data('id', id).modal('show');
});

// comfirm delete button
$("#delete-comfirm").on('click',function(){
  var id = $('#deleteModal').data('id');
  $.ajax({
    url: "<?php echo base_url() ?>items/deleteItems",
    type: "POST",
    data: {iditem: id},
    dataType: "json",
    success: function(data){
      $('#deleteModal').modal('hide');
      $('.alert-success').html('Item was deleted successfully').fadeIn().delay(4000).fadeOut('slow');
      showAllitems();
    },
    error: function(){
      $('#deleteModal').modal('hide');
      alert("Error delete! this item is has relationship with another...");
    }
  });
});


// delete material by ajax
$('#showdata').on('click', '.item-view', function(){
  var id = $(this).attr('dataid');
  $.ajax({
   type: 'POST',
   data: {iditem: id},
   url: '<?php echo base_url();?>/items/showDetailItem',
   async: true,
   dataType: 'json',
   success: function(data){
    // alert('success');
    $('#frm_view').html(data);
    $('#viewDetailModal').modal('show');
  },
  error: function(){
   alert('Could not get any data from Database');
 }
});
});

});
</script>
