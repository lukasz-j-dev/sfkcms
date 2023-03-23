<!-- JQuery DataTable Css -->

<link href="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">  

<!-- Bootstrap Select Css -->

<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<!-- Exportable Table -->

<div class="row clearfix">

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <div class="card">

      <div class="header">

        <h2 style="display: inline-block;">

          Cameras List

        </h2>

        <a href="<?= base_url('admin/cameras/add');?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">person_add</i> ADD Camera</a>

      </div>

      <div class="body">

        <div class="table-responsive">

          <table id="na_datatable" class="table table-bordered table-striped table-hover dataTable">

            <thead>

              <tr>

                <th>#ID</th>

                <th>Village Court</th>

                <th>Camera Location</th>

                <th>Camera zip code</th>

                <th>Camera model</th>

                <th>Date installed</th>

                <th width="200" class="text-right">Action</th>

              </tr>

            </thead>

            <tfoot>

              <tr>

                <th>#ID</th>
				
                <th>Village Court</th>

                <th>Camera Location</th>

                <th>Camera zip code</th>

                <th>Camera model</th>

                <th>Date installed</th>
				
                <th width="200" class="text-right">Action</th>

              </tr>

            </tfoot>

          </table>

        </div>

      </div>

    </div>

  </div>

</div>

<!-- #END# Exportable Table -->



<!-- Modal -->

<div id="confirm-delete" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Delete</h4>

      </div>

      <div class="modal-body">

        <p>As you sure you want to delete.</p>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        <a class="btn btn-danger btn-ok">Delete</a>

      </div>

    </div>

  </div>

</div>



 <!-- Jquery DataTable Plugin Js -->

<script src="<?= base_url()?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>

<script src="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>

 <script type="text/javascript">

  //---------------------------------------------------

  var table = $('#na_datatable').DataTable( {

      "processing": true,

      "serverSide": true,

      "ajax": "<?=base_url('admin/cameras/datatable_json')?>",

      "order": [[0,'desc']],
	  
	  "pageLength": 100,

      "aoColumnDefs": [

        { "aTargets": 0, "sName": "id", 'bSearchable':true, 'bSortable':true},

        { "aTargets": 1, "sName": "village_court", 'bSearchable':true, 'bSortable':true},

        { "aTargets": 2, "sName": "camera_location", 'bSearchable':true, 'bSortable':true},

        { "aTargets": 3, "sName": "camera_zip", 'bSearchable':false, 'bSortable':false},

        { "aTargets": 4, "sName": "camera_model", 'bSearchable':true, 'bSortable':true},

        { "aTargets": 5, "sName": "date_installed", 'bSearchable':true, 'bSortable':true, 'iDataSort': 7},

        { "aTargets": 6, "sName": "Action", 'bSearchable':false, 'bSortable':false},
		
        { "aTargets": 7, "sName": "date_installed_stamp", bVisible: false, 'bSortable':true},
		

      ]

    });

  </script>
  <script>

    $('#confirm-delete').on('show.bs.modal', function(e) {

		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

    });

 </script>