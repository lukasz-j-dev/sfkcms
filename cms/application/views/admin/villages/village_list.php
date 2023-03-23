<link href="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2 style="display: inline-block;">
          Villages List
        </h2>

        <a href="<?= base_url('admin/villages/add'); ?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">person_add</i> ADD Village</a>
      </div>

      <div class="body">
        <div class="table-responsive">
          <table id="na_datatable" class="table table-bordered table-striped table-hover dataTable">
            <thead>
              <tr>
                <th>#ID</th>
                <th>Village Court</th>
                <th>Fine amount</th>
                <th>Status</th>
                <th>Payable to</th>
                <th width="200" class="text-right">Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>#ID</th>
                <th>Village Court</th>
                <th>Fine amount</th>
                <th>Status</th>
                <th>Payable to</th>
                <th width="200" class="text-right">Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

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
<script src="<?= base_url() ?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>

<script type="text/javascript">
  var table = $('#na_datatable').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": "<?= base_url('admin/villages/datatable_json') ?>",
    "order": [
      [0, 'desc']
    ],
    "pageLength": 100,
    "columnDefs": [{
        "targets": 0,
        "name": "id",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 1,
        "name": "village_court",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 2,
        "name": "fine_amount",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 3,
        "name": "status",
        'searchable': false,
        'orderable': false
      },
      {
        "targets": 4,
        "name": "payable_to",
        'searchable': true,
        'orderable': true
      },
      {
        "targets": 5,
        "name": "Action",
        'searchable': false,
        'orderable': false,
        'width': '100px'
      }
    ]
  });
</script>

<script>
  $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
</script>