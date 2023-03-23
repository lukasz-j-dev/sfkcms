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
	.btn-bulk-edit,
	.btn-quick-import,
	.btn-first-notice-date,
	.btn-recalc-totals,
	.btn_bulk_update_dmv_status,
	.btn_group_delete {
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
