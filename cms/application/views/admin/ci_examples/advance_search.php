<!-- JQuery DataTable Css -->
<link href="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">  
<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<!-- Exportable Table -->

<!-- Bootstrap Material Datetime Picker Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

<!-- Wait Me Css -->
<link href="<?= base_url() ?>public/plugins/waitme/waitMe.css" rel="stylesheet" />

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2 style="display: inline-block;">&nbsp;&nbsp; USER LIST WITH ADVANCE SEARCH EXAMPLE</h2>
      </div>
    </div>

    <div class="card">
      <div class="body table-responsive"> 
        <?php echo form_open("/",'id="user_search"') ?>
        <div class="row">
          <div class="col-md-4">
            <label>User Type:</label>
            <br>
            <input checked="checked" onchange="user_filter()" name="user_search_type" value="" id="all_radio" class="with-gap" type="radio"  /> <label for="all_radio">ALL</label>

            <input onchange="user_filter()" name="user_search_type" value="1" type="radio" id="active_radio" class="with-gap">
            <label for="active_radio">ACTIVE</label>

            <input onchange="user_filter()" name="user_search_type" value="0" type="radio" id="inactive_radio" class="with-gap" /><label for="inactive_radio">INACTIVE</label>

          </div>

          <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
              <label for="country">Date From:</label>
              <div class="form-group">
                  <div class="form-line">
                    <input name="user_search_from" type="text" class="form-control form-control-inline input-medium datepicker" id="" />
                  </div>
              </div>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
              <label for="country">Date To:</label>
              <div class="form-group">
                  <div class="form-line">
                    <input name="user_search_to" type="text" class="form-control form-control-inline input-medium datepicker" id="" /> 
                  </div>
              </div>
          </div>

          <div class="col-md-2"> 
            <button type="button" style="margin-top:20px;" onclick="user_filter()" class="btn btn-info"><i class="material-icons">check</i> Submit</button>
            <a href="<?= base_url('admin/ci_examples/advance_search'); ?>" class="btn btn-danger" style="margin-top:20px;">
              <i class="material-icons">cached</i>
            </a>
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>  

    <div class="card">
      <div class="body table-responsive">
        <table id="na_datatable" class="table table-bordered table-striped" width="100%">
          <thead>
            <tr>
              <th>#ID</th>
              <th>User Name</th>
              <th>Email</th>
              <th>Mobile No.</th>
              <th>Created Date</th>
              <th>Status</th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </section>  
</div>


<!-- Autosize Plugin Js -->
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<!-- Moment Plugin Js -->
<script src="<?= base_url() ?>public/plugins/momentjs/moment.js"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<!-- Custom Js -->
<script src="<?= base_url() ?>public/js/pages/forms/basic-form-elements.js"></script>

 <!-- Jquery DataTable Plugin Js -->
<script src="<?= base_url()?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script>
  //---------------------------------------------------
  var table = $('#na_datatable').DataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": "<?=base_url('admin/ci_examples/advance_datatable_json')?>",
    "order": [[4,'desc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "username", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "email", 'searchable':true, 'orderable':true},
    { "targets": 3, "name": "mobile_no", 'searchable':true, 'orderable':true},
    { "targets": 4, "name": "created_at", 'searchable':false, 'orderable':false},
    { "targets": 5, "name": "is_active", 'searchable':true, 'orderable':true},
    ]
  });

  //---------------------------------------------------
  function user_filter()
  {
    var _form = $("#user_search").serialize();
    $.ajax({
      data: _form,
      type: 'post',
      url: '<?php echo base_url();?>admin/ci_examples/search',
      async: true,
      success: function(output){
        table.ajax.reload( null, false );
      }
    });
  }
</script>



