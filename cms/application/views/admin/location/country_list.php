 <!-- Datatable style -->
<!-- JQuery DataTable Css -->
<link href="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">  
<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   <div class="card">
      <div class="header">
        <h2 style="display: inline-block;">&nbsp; COUNTRIES LIST</h2>
        <a href="<?= base_url('admin/location/country/add'); ?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">control_point</i> ADD NEW COUNTRY</a>
      </div>
      <div class="body table-responsive">
        <table id="na_datatable" class="table table-bordered table-striped table-hover dataTable">
          <thead>
          <tr>
            <th>No</th>
            <th>Country Name</th>
            <th>Status</th>
            <th style="width: 150px;" class="text-right">Action</th>
          </tr>
          </thead>
        </table>
      </div>
   </div>
  </section> 
</div> 


 <!-- Jquery DataTable Plugin Js -->
<script src="<?= base_url()?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
  <script>
  //---------------------------------------------------
  var table = $('#na_datatable').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "<?=base_url('admin/location/country_datatable_json')?>",
      "order": [[1,'asc']],
      "columnDefs": [
        { "targets": 0, "name": "", 'searchable':false, 'orderable':true},
        { "targets": 1, "name": "name", 'searchable':true, 'orderable':true},
        { "targets": 2, "name": "status", 'searchable':true, 'orderable':true},
        { "targets": 3, "name": "action", 'searchable':false, 'orderable':false,'width':'100px'}
      ]
    });
  </script>
  <!-- Scripts for this page -->
  <script>
     $(document).ready(function(){
      $(".btn-delete").click(function(){
        if (!confirm("Do you want to delete")){
          return false;
        }
      });
    });
  </script>