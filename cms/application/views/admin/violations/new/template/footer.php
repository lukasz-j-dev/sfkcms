<!-- Jquery DataTable Plugin Js -->
<script src="<?= base_url() ?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
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

<script>
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

	$('#confirm-delete').on('show.bs.modal', function(e) {
		console.log($(e.relatedTarget).parent().siblings().first())
		$(e.relatedTarget).parent().siblings().first().find('.violation_check').prop('checked', true);
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
				console.log('err');
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
	$(document).on('click', '.btn-bulk-edit', function(e) {
		$.ajax({
			url: 'bulk_update_violation_status',
			type: 'post',
			data: $("#ex_print_form").serialize(),
			success: function(res) {
				if (res.trim() != 'noids') {
					var response = JSON.parse(res);
					var id_part = '';
					var camera_part = '';
					var village_part = '';

					// violation ids
					response.data.forEach((value, idx) => {
						id_part +=
							'<input type="hidden" name="' +
							idx +
							'" value="' +
							value +
							'"></input>';
					});
					id_part += '<input type="hidden" name="type" value="' + $('#type').val() + '"></input>';

					// camera locations
					response.cameras.forEach((value, idx) => {
						camera_part +=
							'<input type="hidden" name="camera__' +
							value.id +
							'" value="' +
							value.camera_location +
							'"></input>';
					});

					// village court
					response.villages.forEach((value, idx) => {
						village_part +=
							'<input type="hidden" name="village__' +
							value.id +
							'" value="' +
							value.village_court +
							'"></input>';
					});

					if (id_part != '') {
						var form_part =
							'<form action="<?= base_url('admin/violations/bulk_edit'); ?>" method="post">' +
							id_part + camera_part + village_part +
							'</form>';
						var form = $(form_part);
						$('body').append(form);
						$(form).submit();
					} else alert('Please select records to bulk edit.');
				} else {
					console.log('a');
					alert('Please select records to bulk edit.');
				}
			},
			error: function(err) {
				console.log(err);
			}
		});
	});
</script>
