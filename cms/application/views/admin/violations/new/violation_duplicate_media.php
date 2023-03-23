<?php include('template/header.php'); ?>

<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<div>
					<h2 style="display: inline-block;">
						<?php if ($type === 'images'): ?>
						Violations List(Duplicate Images)
						<?php else: ?>
						Violations List(Duplicate Videos)
						<?php endif; ?>
					</h2>
					<?php include('template/header_menu.php'); ?>
				</div>
				<div>
					<p>
						<?php if ($type === 'images'): ?>
						List of all duplicate violations, where the photo's file name appear in at least on other violation, regardless of violation status. It shows DEMO plates aswel.
						<?php else: ?>
						List of all duplicate violations, where the video's file name appear in at least on other violation, regardless of violation status. It shows DEMO plates aswel.
						<?php endif; ?>
					</p>
				</div>
			</div>

			<div class="body">
				<div class="table-responsive">
					<?php echo form_open_multipart('admin/violations/delete', array('id' => 'delete_group', 'class' => 'form-horizontal')); ?>
					<input type="hidden" id="type" name="type" value="all" />
					<input type="hidden" name="current_uri" value="<?= uri_string(); ?>" />
					<div>
						<div class="row">
							<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
								<button class="btn btn-danger btn_ex_print load_ajax_multi" data-action="/ticket/print_ticketpdf.php">Combined PDF</button>
								<button class="btn btn-danger btn_ex_print load_ajax_single" data-action="/ticket/print_ticketpdf.php">Multiple PDF</button>
							</div>
						</div>
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
							<th>Video</th>
							<th>Violation date</th>
							<th>Date added</th>
							<th>Notice date</th>
							<th>Camera</th>
							<th>Status</th>
							<th>Payment status</th>
							<th>Zipcode</th>
							<th>DMV status</th>
							<th>Type</th>
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
							<th>Video</th>
							<th>Violation date</th>
							<th>Date added</th>
							<th>Notice date</th>
							<th>Camera</th>
							<th>Status</th>
							<th>Payment status</th>
							<th>Zipcode</th>
							<th>DMV status</th>
							<th>Type</th>
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

<?php include('template/footer.php'); ?>
<script>
	$(document).ready(function() {
		var table = $('#na_datatable').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "<?= base_url('admin/violations/datatable_json_duplicate_media/'.$type) ?>",
			"order": [
				["1", 'asc']
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
					"sName": "a.violation_video",
					'bSearchable': false,
					'bSortable': false,
					'iDataSort': 5
				},
				{
					"aTargets": [6],
					"sName": "a.violation_date_new",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [7],
					"sName": "a.date_added_new",
					'bSearchable': false,
					'bSortable': true,
					'iDataSort': 7
				},
				{
					"aTargets": [8],
					"sName": "a.notice_date_new",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [9],
					"sName": "c.camera_location",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [10],
					"sName": "a.status",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [11],
					"sName": "a.payment_status",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [12],
					"sName": "b.dmv_status",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [13],
					"sName": "a.zipcode",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [14],
					"sName": "a.violation_type",
					'bSearchable': true,
					'bSortable': true
				},
				{
					"aTargets": [15],
					"sName": "Action",
					'bSearchable': false,
					'bSortable': false
				}
			]
		});

		$(document).on('click', '.btn_bulk_update_dmv_status', function(e) {
			e.preventDefault();

			if ($('.btn_bulk_update_dmv_status').text() == 'Updating...')
				return;

			let text = "Are you sure to bulk update the DMV status?";
			if (confirm(text) == true) {
				var plate = {};
				var platesArray = [];
				var rows = table.rows().data();
				for (var i = 0; i < rows.length; i++) {
					if (document.querySelectorAll('.violation_check')[i].checked == true) {
						// plate.id = rows[i][0].replace(/\D/g, '').trim();
						// if ( $.isNumeric(plate.id) ) {
						plate.plate = rows[i][3].trim();
						platesArray.push({
							...plate
						});
						// }
					}
				}
				if (platesArray.length) {
					$('.btn_bulk_update_dmv_status').html('Updating...');
					$.ajax({
						url: "<?php echo base_url('admin/plates/bulk_update_dmv_status'); ?>",
						type: 'post',
						data: {
							data: JSON.stringify(platesArray)
						},
						success: function(response) {
							console.log(response);
							$('.btn_bulk_update_dmv_status').html('DMV Status Bulk Update');
							if (response.trim() == 'success') {
								alert('Status has been bulk updated.');
								location.reload();
							} else {
								alert('Please select records to bulk update the DMV status.');
							}
						},
						error: function(err) {
							console.log('err');
							console.log(err);
						}
					});
				}
				else alert('Please select records to bulk update the DMV status.');
			}
		});

		// on click event for group delete button (to delete selected violations)
		$('#confirm-delete .btn-ok').click((e) => {
			e.preventDefault();

			var selectedViolations = $('.violation_check:checked').map(function(){
				return $(this).val();
			}).get();
			if (selectedViolations.length) {
				$("#delete_group").submit();
			}
			else {
				alert('Please select records to delete.');
			}

		});
	});
</script>
