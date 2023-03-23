<link href="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<!-- Exportable Table -->
<style>
	input[type="checkbox"].violation_check,
	#select_all {
		position: initial;
		opacity: 1;
	}

	.btn-import,
	.btn-export,
	.btn-quick-import,
	.btn-first-notice-date,
	.btn-recalc-totals {
		margin-right: 10px;
		padding: 8px 18px;
	}

	tr td .btn.pdf_link,
	.pdf_link.btn:not(.btn-link):not(.btn-circle) {
		padding: 5px 8px;
		vertical-align: middle;
		font-size: 15px;
	}

	.tooltip-text {
		position: absolute;
		top: -150px;
		left: -50%;
		z-index: 2;
		width: 300px;
		color: white;
		font-size: 12px;
		background-color: #192733;
		border-radius: 10px;
		padding: 10px 15px 10px 15px;
	}

	.tooltip-text p {
		margin: 3px !important;
		font-weight: 300;
	}

	#fade {
		opacity: 0;
		transition: opacity 0.5s;
	}

	.total-text:hover #fade {
		opacity: 1;
	}
</style>

<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<div>
					<h2 style="display: inline-block;">
						Violations List(Unpaid)
					</h2>
					<a href="<?= base_url('admin/violations/add'); ?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">person_add</i> ADD Violation</a>
					<a href="<?= base_url('admin/violations/exportallcsv/unpaid'); ?>" class="btn btn-primary btn-export pull-right">Export All</a>
					<a href="<?= base_url('admin/violations/import/unpaid'); ?>" class="btn btn-success btn-import pull-right">Import</a>
					<a href="<?= base_url('admin/violations/quick_import/unpaid'); ?>" class="btn btn-success btn-quick-import pull-right">Quick Import</a> <!-- Shang -->
					<a href="#" class="btn bg-deep-orange waves-effect btn-first-notice-date pull-right">Update first notice date</a>
					<a href="#" class="btn bg-deep-orange waves-effect btn-recalc-totals pull-right">Recalculate Totals</a>
				</div>
				<div>
					<p>Showing a list of all violations where the payment status is "unpaid" and the status is "Mailed". DEMO plates are excluded.</p>
				</div>
			</div>

			<div class="body">
				<div class="table-responsive">
					<?php echo form_open_multipart('/cms/admin/violations/exportcsv', array('id' => 'ex_print_form', 'class' => 'form-horizontal')); ?>
					<div>
						<button class="btn btn-danger btn_ex_print load_ajax_multi" data-action="/ticket/print_ticketpdf.php">Combined PDF</button>
						<button class="btn btn-danger btn_ex_print load_ajax_single" data-action="/ticket/print_ticketpdf.php">Multiple PDF</button>
					</div>
					<div class="loaded_content">
						<div class="w3-border">
							<div class="w3-green" style="height:24px;width:0%"></div>
						</div>
						<div class="msg" style="display: none;">0% completed</div>
					</div>

					<table id="na_datatable" class="table table-bordered table-striped table-hover dataTable">
						<thead>
							<tr>
								<th><input type="checkbox" id="select_all" /></th>
								<th>#ID</th>
								<th>Violation number</th>
								<th>Plate</th>
								<th>Thumbnail</th>
								<th>Violation date</th>
								<th>Notice date</th>
								<th>Due date</th>
								<th>Amount Due</th>
								<th>Status</th>
								<th>Payment Status</th>
								<th>Zipcode</th>
								<th class="total-text">Total
									<span class="tooltip-text" id="fade">
										<p>1. Get today date</p>
										<p>2. Get notice date</p>
										<p>3. Calculate diff between today and notice date</p>
										<p>4. Filter records less than 60 and status is not archived</p>
									</span>
								</th>
								<th>DMV Status</th>
								<th width="155" class="text-right">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>#</th>
								<th>#ID</th>
								<th>Violation number</th>
								<th>Plate</th>
								<th>Thumbnail</th>
								<th>Violation date</th>
								<th>Notice date</th>
								<th>Due date</th>
								<th>Amount Due</th>
								<th>Status</th>
								<th>Payment Status</th>
								<th>Zipcode</th>
								<th>Total</th>
								<th>DMV Status</th>
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
	function gettimestampFromString(mon, day, year) {

		var d = Date.parse(mon + day + ", " + year);
		if (!isNaN(d)) {
			return new Date(d).getTime();
		}
		return -1;
	}
	jQuery.fn.dataTableExt.oSort["rank-desc"] = function(x, y) {
		return getRank(x) < getRank(y);
	};

	jQuery.fn.dataTableExt.oSort["rank-asc"] = function(x, y) {
		return getRank(x) > getRank(y);
	}
	jQuery.extend(jQuery.fn.dataTableExt.oSort, {
		"date_sort-pre": function(a) {
			if (a == null || a == "") {
				return 0;
			}
			myDate = a.split("-");
			var rtn = gettimestampFromString(myDate[0], myDate[1], myDate[2]);
			console.log(rtn);
			return rtn;
		},

		"date_sort-asc": function(a, b) {
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},

		"date_sort-desc": function(a, b) {
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		}
	});
	$.fn.dataTable.ext.type.order['salary-grade-pre'] = function(a) {
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
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	};
	$(document).ready(function() {
		var table = $('#na_datatable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?= base_url('admin/violations/datatable_json_unpaid') ?>",
			"order": [
				[1, 'asc']
			],
			"lengthMenu": [100, 250, 500, 1000, 5000],
			"pageLength": 250,
			"aoColumnDefs": [{
					"aTargets": [0],
					"sName": "check",
					'bSearchable': false,
					'bSortable': false
				},
				{
					"aTargets": [1],
					"sName": "a.id",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [2],
					"sName": "a.violation_number",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [3],
					"sName": "a.plate",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [4],
					"sName": "a.thumbnail",
					'bSearchable': false,
					'bSortable': false
				},
				{
					"aTargets": [5],
					"sName": "a.violation_date_new",
					'bSearchable': true,
					'bSortable': true,
					'iDataSort': 5
				},
				{
					"aTargets": [6],
					"sName": "a.notice_date_new",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [7],
					"sName": "a.due_date_new",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [8],
					"sName": "a.amount_due",
					'bSearchable': false,
					'bSortable': true,
					'iDataSort': 8
				},
				{
					"aTargets": [9],
					"sName": "a.status",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [10],
					"sName": "a.payment_status",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [11],
					"sName": "b.zip_code",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [12],
					"sName": "b.total_violations",
					'bSearchable': false,
					'bSortable': true
				},
				{
					"aTargets": [13],
					"sName": "b.dmv_status",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [14],
					"sName": "Action",
					'bSearchable': false,
					'bSortable': false
				},
				{
					"aTargets": [15],
					"sName": "a.full_name",
					bVisible: false,
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [16],
					"sName": "a.address1",
					bVisible: false,
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [17],
					"sName": "a.address2",
					bVisible: false,
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [18],
					"sName": "a.zip",
					bVisible: false,
					'bSearchable': true,
					'bSortable': true
				}
			]
		});
	});
</script>

<script>
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});

	function pdf_ajax(page = 1, action = '', type = 'multi') {
		$.ajax({
			url: action,
			type: 'post',
			dataType: 'json',
			data: $("#ex_print_form").serialize() + '&page=' + page + '&limit=1&type=' + type,
			success: function(result) {
				console.log(result);
				if (typeof(result.msg) != 'undefined') {
					$('.loaded_content .msg').show();
					$('.loaded_content .msg').html(result.msg);
					$('.loaded_content .w3-green').css('width', result.percent + '%');
				}
				if (typeof(result.next_page) != 'undefined') {
					pdf_ajax(result.next_page, action, type);
				}
				if (typeof(result.download_file) != 'undefined') {
					var req = new XMLHttpRequest();
					req.open("GET", "https://stopforkids.com/ticket/" + result.download_file, true);
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
		if ($(this).hasClass('load_ajax_multi')) {
			pdf_ajax(1, action, 'multi');
		} else if ($(this).hasClass('load_ajax_single')) {
			pdf_ajax(1, action, 'single');
		} else {
			$("#ex_print_form").attr('action', action);
			$("#ex_print_form").submit();
		}
	});
	$(document).on('click', '#select_all', function(e) {
		console.log($(this).prop('checked'));
		if ($(this).prop('checked')) $('.violation_check').prop('checked', true);
		else $('.violation_check').prop('checked', false);
	});

	$(document).on('click', '.btn-first-notice-date', function(e) {
		e.preventDefault();

		if ($('.btn-first-notice-date').text() == 'Updating...')
			return;

		$('.btn-first-notice-date').html('Updating...');

		$.ajax({
			url: 'update_first_notice_date',
			type: 'post',
			success: function(result) {
				$('.btn-first-notice-date').html('Update first notice date');
				alert(result.trim());
			},
			error: function(err) {
				$('.btn-first-notice-date').html('Update first notice date');
				alert('Something went wrong while updating.');
			}
		});
	});

	$(document).on('click', '.btn-recalc-totals', function(e) {
		e.preventDefault();

		if ($('.btn-recalc-totals').text() == 'Recalculating...')
			return;

		$('.btn-recalc-totals').html('Recalculating...');

		$.ajax({
			url: 'recalculate_totals',
			type: 'post',
			success: function(result) {
				$('.btn-recalc-totals').html('Recalculate Totals');
				alert(result);
				location.reload();
			},
			error: function(err) {
				$('.btn-recalc-totals').html('Recalculate Totals');
				alert('Something went wrong while updating.');
			}
		});
	});
</script>