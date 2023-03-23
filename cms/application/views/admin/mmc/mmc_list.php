<link href="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<style>
	input[type="checkbox"].mmc_check,
	#select_all {
		position: initial;
		opacity: 1;
	}

	.btn-import,
	.btn-export,
	.btn-dmv {
		margin-right: 10px;
		padding: 8px 18px;
	}

	tr td .btn.pdf_link, .pdf_link.btn:not(.btn-link):not(.btn-circle) {
		padding: 5px 8px;
		vertical-align: middle;
		font-size: 15px;
	}
</style>

<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2 style="display: inline-block;">
					MMC List
				</h2>
				<a href="<?= base_url('admin/mmc/add'); ?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">person_add</i> ADD MMC</a>
				<a href="<?= base_url('admin/mmc/exportallcsv'); ?>" class="btn btn-primary btn-export pull-right">Export</a>

				<a href="<?= base_url('admin/mmc/import'); ?>" class="btn btn-success btn-import pull-right">Import</a>
			</div>

			<div class="body">
				<div class="table-responsive">
					<?php echo form_open_multipart('/cms/admin/mmc/exportcsv', array('id' => 'ex_print_form', 'class' => 'form-horizontal')); ?>
					<!-- <div>
						<button class="btn btn-primary btn_ex_print" data-action="<?= '/cms/admin/mmc/exportcsv'; ?>">Export</button>
					</div> -->
					<div class="loaded_content">
						<div class="w3-border">
							<div class="w3-green" style="height:24px;width:0%"></div>
						</div>
						<div class="msg" style="display: none;">0% completed</div>
					</div>
					<table id="mmc_datatable" class="table table-bordered table-striped table-hover dataTable">
						<thead>
							<tr>
								<th><input type="checkbox" id="select_all" /></th>
								<th>#ID</th>
								<th>Video</th>
								<th>Image</th>
								<th>Plate</th>
								<th>Region</th>
								<th>Coordinates</th>
								<th>Score</th>
								<th>Type</th>
								<th>Make</th>
								<th>Model</th>
								<th>Color</th>
								<th>Orientatiton</th>
								<th>Date</th>
								<th>Time</th>
								<th width="155" class="text-right">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><input type="checkbox" id="select_all" /></th>
								<th>#ID</th>
								<th>Video</th>
								<th>Image</th>
								<th>Plate</th>
								<th>Region</th>
								<th>Coordinates</th>
								<th>Score</th>
								<th>Type</th>
								<th>Make</th>
								<th>Model</th>
								<th>Color</th>
								<th>Orientatiton</th>
								<th>Date</th>
								<th>Time</th>
								<th width="155" class="text-right">Action</th>
							</tr>
						</tfoot>
					</table>
					</form>
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
<script src="<?= base_url() ?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>

<script type="text/javascript">
	//---------------------------------------------------
	function gettimestampFromString(mon, day, year) {

		var d = Date.parse(mon + day + ", " + year);
		if (!isNaN(d)) {
			return new Date(d).getTime();
		}
		return -1;
	}

	jQuery.fn.dataTableExt.oSort["rank-desc"] = function(x, y) {
		console.log('x');
		console.log(x);
		console.log('y');
		console.log(y);
		return getRank(x) < getRank(y);
	};

	jQuery.fn.dataTableExt.oSort["rank-asc"] = function(x, y) {
		return getRank(x) > getRank(y);
	}

	jQuery.extend(jQuery.fn.dataTableExt.oSort, {
		"date_sort-pre": function(a) {
			console.log('a');
			console.log(a);
			if (a == null || a == "") {
				return 0;
			}
			myDate = a.split("-");
			var rtn = gettimestampFromString(myDate[0], myDate[1], myDate[2]);
			console.log(rtn);
			return rtn;
		},

		"date_sort-asc": function(a, b) {
			console.log('a');
			console.log(a);
			console.log('b');
			console.log(b);
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},

		"date_sort-desc": function(a, b) {
			console.log('a');
			console.log(a);
			console.log('b');
			console.log(b);
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		}
	});

	$.fn.dataTable.ext.type.order['salary-grade-pre'] = function(a) {
		console.log('a');
		console.log(a);
		switch (a) {
			case 'Dec-12-2019':
				return 1;
			case 'Dec-31-2019':
				return 2;
			case 'Jan-14-2020':
				return 3;
			case 'Mar-31-2020':
				return 4;
			case 'Apr-01-2020':
				return 5;
		}
		return 0;
	};

	$.fn.dataTable.ext.type.order['salary-grade-asc'] = function(a) {
		console.log('a');
		console.log(a);
		console.log('b');
		console.log(b);
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	};

	$(document).ready(function() {
		var table = $('#mmc_datatable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?= base_url('admin/mmc/datatable_json') ?>",
			"order": [
				[1, 'desc']
			],
			"pageLength": 100,
			"aoColumnDefs": [
				{
					"aTargets": [0],
					"sName": "check",
					'bSearchable': false,
					'bSortable': false
				},
				{
					"aTargets": [1],
					"sName": "id",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [2],
					"sName": "video_name",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [3],
					"sName": "image_name",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [4],
					"sName": "plate",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [5],
					"sName": "plate_region",
					'bSearchable': false,
					'bSortable': true
				},
				{
					"aTargets": [6],
					"sName": "plate_coordinates",
					'bSearchable': true,
					'bSortable': true,
					'iDataSort': 5
				},
				{
					"aTargets": [7],
					"sName": "plate_score",
					'bSearchable': false,
					'bSortable': true,
					'iDataSort': 6
				},
				{
					"aTargets": [8],
					"sName": "vehicle_type",
					'bSearchable': true,
					'bSortable': true,
					'iDataSort': 7
				},
				{
					"aTargets": [9],
					"sName": "make",
					'bSearchable': true,
					'bSortable': true,
					'iDataSort': 7
				},
				{
					"aTargets": [10],
					"sName": "color",
					'bSearchable': true,
					'bSortable': true,
					'iDataSort': 7
				},
				{
					"aTargets": [11],
					"sName": "vehicle_orientation",
					'bSearchable': true,
					'bSortable': true,
					'iDataSort': 7
				},
				{
					"aTargets": [12],
					"sName": "date",
					'bSearchable': true,
					'bSortable': true,
					'iDataSort': 7
				},
				{
					"aTargets": [13],
					"sName": "time",
					'bSearchable': true,
					'bSortable': true,
					'iDataSort': 7
				}
			]
		});
	});
</script>
<script>
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});

	function pdf_ajax(page = 1, action = '') {
		console.log(action);
		$.ajax({
			url: action,
			type: 'post',
			dataType: 'json',
			data: $("#ex_print_form").serialize() + '&page=' + page + '&limit=1',
			success: function(result) {
				console.log(result);
				if (typeof(result.msg) != 'undefined') {
					$('.loaded_content .msg').show();
					$('.loaded_content .msg').html(result.msg);
					$('.loaded_content .w3-green').css('width', result.percent + '%');
				}
				if (typeof(result.next_page) != 'undefined') {
					pdf_ajax(result.next_page, action);
				}
				if (typeof(result.download_file) != 'undefined') {
					var req = new XMLHttpRequest();
					req.open("GET", "https://stopforkids.com/ticket/pdf_save/" + result.download_file, true);
					req.responseType = "blob";
					req.onload = function(event) {
						var blob = req.response;
						var link = document.createElement('a');
						link.href = window.URL.createObjectURL(blob);
						link.download = result.download_file;
						link.click();
					};
					req.send();
				}
			},
			error: function(err) {
				console.log(err);
			}
		});
	}

	$(document).on('click', '.btn_ex_print', function(e) {
		e.preventDefault();
		var action = $(this).attr('data-action');
		if ($(this).hasClass('load_ajax')) {
			pdf_ajax(1, action);
		} else {
			$("#ex_print_form").attr('action', action);
			$("#ex_print_form").submit();
		}
	});

	$(document).on('click', '#select_all', function(e) {
		console.log($(this).prop('checked'));
		if ($(this).prop('checked')) $('.Mmc_check').prop('checked', true);
		else $('.Mmc_check').prop('checked', false);
	});
</script>