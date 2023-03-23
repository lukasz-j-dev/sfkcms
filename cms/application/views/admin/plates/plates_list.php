<!-- JQuery DataTable Css -->

<link href="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">  

<!-- Bootstrap Select Css -->

<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<!-- Exportable Table -->

<style>
input[type="checkbox"].plate_check, #select_all{
	position: initial;
	opacity: 1;
}
.btn-import, .btn-export, .btn-dmv, .btn-dmv-api {
	margin-right: 10px;
	padding: 8px 18px;
}
tr td .btn.pdf_link, .pdf_link.btn:not(.btn-link):not(.btn-circle){
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

          Plates List 

        </h2>		
        <a href="<?= base_url('admin/plates/add');?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">person_add</i> ADD Plate</a>
		<a href="<?= base_url('admin/plates/exportallcsv');?>" class="btn btn-primary btn-export pull-right">Export All</a>

		<a href="<?= base_url('admin/plates/import');?>" class="btn btn-success btn-import pull-right">Import</a>
		
		<!-- Shang -->
		<a href="#" class="btn btn-info btn-dmv pull-right">DMV</a>
		<a href="#" class="btn btn-success btn-dmv-api pull-right">DMV API</a>

      </div>

      <div class="body">

        <div class="table-responsive">
			<?php echo form_open_multipart('/cms/admin/plates/exportcsv', array('id' => 'ex_print_form', 'class' => 'form-horizontal'));?>        
			<div>
				<button class="btn btn-primary btn_ex_print" data-action="<?= '/cms/admin/plates/exportcsv'; ?>">Export</button>
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
                <th>Plate</th>
                <th>Plate Type</th>
                <th>City</th>
				<th>State</th>
				<th>Zip Code</th>
                <th>Name</th>
                <th>Body</th>
                <th>Year</th>
                <th>Make</th>
                <th>Model</th>
                <th>Color</th>
				<th>Dmv Status </th>
				<th>Last Fetched Date</th>
                <th width="155" class="text-right">Action</th>

              </tr>

            </thead>

            <tfoot>

                 <tr>

                <th><input type="checkbox" id="select_all" /></th>
                <th>#ID</th>
                <th>Plate</th>
                <th>Plate Type</th>
                <th>City</th>
				<th>State</th>
				<th>Zip Code</th>
                <th>Name</th>
                <th>Body</th>
                <th>Year</th>
                <th>Make</th>
                <th>Model</th>
                <th>Color</th>
				<th>Dmv Status </th>
				<th>Last Fetched Date</th>
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

<script src="<?= base_url()?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>

<script src="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>

 <script type="text/javascript">

  //---------------------------------------------------
	function gettimestampFromString(mon, day, year){

	   var d = Date.parse(mon + day + ", " +year);
	   if(!isNaN(d)){
		  return new Date(d).getTime();
	   }
	   return -1;
	}
	jQuery.fn.dataTableExt.oSort["rank-desc"] = function (x, y) {
		console.log('x');
		console.log(x);
		console.log('y');
		console.log(y);
			return getRank(x) < getRank(y);
	};
		 
	jQuery.fn.dataTableExt.oSort["rank-asc"] = function (x, y) {
			return getRank(x) > getRank(y);
	}
	jQuery.extend( jQuery.fn.dataTableExt.oSort, {
		"date_sort-pre": function ( a ) {
			console.log('a');
			console.log(a);
			if (a == null || a == "") {
				return 0;
			}
			myDate=a.split("-");
			var rtn = gettimestampFromString(myDate[0], myDate[1], myDate[2]);
			console.log(rtn);
			return rtn;
		},
	 
		"date_sort-asc": function ( a, b ) {
			console.log('a');
			console.log(a);
			console.log('b');
			console.log(b);
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},
	 
		"date_sort-desc": function ( a, b ) {
			console.log('a');
			console.log(a);
			console.log('b');
			console.log(b);
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		}
	} );
	$.fn.dataTable.ext.type.order['salary-grade-pre'] = function ( a ) {
		console.log('a');
		console.log(a);
		switch ( a ) {
			case 'Dec-12-2019':    return 1;
			case 'Dec-31-2019':    return 2;
			case 'Jan-14-2020':   return 3;
			case 'Mar-31-2020':   return 4;
			case 'Apr-01-2020':   return 5;
		}
		return 0;
	};
	$.fn.dataTable.ext.type.order['salary-grade-asc'] = function ( a ) {
		console.log('a');
		console.log(a);
		console.log('b');
		console.log(b);
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	};
	$(document).ready(function() {
	  var table = $('#na_datatable').DataTable( {

		  "processing": true,
		  "serverSide": true,
		  "ajax": "<?=base_url('admin/plates/datatable_json')?>",
		  "order": [[1,'desc']],
		  "pageLength": 100,
		  "aoColumnDefs": [
			{ "aTargets": [0], "sName": "check", 'bSearchable':false, 'bSortable':false},
			{ "aTargets": [1], "sName": "a.id", 'bSearchable':true, 'bSortable':true},
			{ "aTargets": [2], "sName": "a.plate", 'bSearchable':true, 'bSortable':true},
			{ "aTargets": [3], "sName": "a.plate_type", 'bSearchable':true, 'bSortable':false},
			{ "aTargets": [4], "sName": "a.city", 'bSearchable':true, 'bSortable':false},
			{ "aTargets": [5], "sName": "a.state", 'bSearchable':true, 'bSortable':false},
			{ "aTargets": [6], "sName": "a.zip_code", 'bSearchable':true, 'bSortable':false},
			{ "aTargets": [7], "sName": "a.name", 'bSearchable':true, 'bSortable':true},
			{ "aTargets": [8], "sName": "a.body", 'bSearchable':true, 'bSortable':false},
			{ "aTargets": [9], "sName": "a.year", 'bSearchable':true, 'bSortable':true, 'iDataSort': 5},
			{ "aTargets": [10], "sName": "a.make", 'bSearchable':true, 'bSortable':true, 'iDataSort': 6},
			{ "aTargets": [11], "sName": "b.model", 'bSearchable':true, 'bSortable':true, 'iDataSort': 6},
			{ "aTargets": [12], "sName": "a.color", 'bSearchable':true, 'bSortable':true, 'iDataSort': 7},
			{ "aTargets": [13], "sName": "a.dmv_status", 'bSearchable':true, 'bSortable':true, 'iDataSort': 7},
			{ "aTargets": [14], "sName": "a.last_fetched_date", 'bSearchable':true, 'bSortable':true, 'iDataSort': 7},
		  ]
		});
    });
  </script>
  <script>
    // Shang
	$('.btn-dmv').on('click', function(e) {
		e.preventDefault();

		if ( $('.btn-dmv').text() == 'DMV Fetching...' ) {
			return;
		}
		$('.btn-dmv').html('DMV Fetching...');

		$.ajax({
			url: "<?=base_url('admin/plates/dmv')?>",
			type: 'get',
			dataType: 'json',
			success: function(result) {
				console.log(result);
				$('.btn-dmv').html('DMV');

			},
			error: function(err){
				$('.btn-dmv').html('DMV');
				console.log(err);
			}
		});
	});
	$('.btn-dmv-api').on('click', function(e) {
		e.preventDefault();

		if ( $('.btn-dmv-api').text() == 'DMV Fetching...' ) {
			return;
		}
		$('.btn-dmv-api').html('DMV Fetching...');

		$.ajax({
			url: "<?=base_url('admin/plates/dmv_api')?>",
			type: 'get',
			dataType: 'json',
			success: function(result) {
				console.log(result);
				$('.btn-dmv-api').html('DMV API');

			},
			error: function(err){
				$('.btn-dmv-api').html('DMV API');
				console.log(err);
			}
		});
	});
    $('#confirm-delete').on('show.bs.modal', function(e) {

		$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

    });
	function pdf_ajax(page = 1, action = ''){
		console.log(action);
		$.ajax({
			url: action,
			type: 'post',
			dataType: 'json',
			data: $( "#ex_print_form" ).serialize() + '&page=' + page + '&limit=1',
			success: function(result){
				console.log(result);
				if(typeof(result.msg) != 'undefined'){
					$('.loaded_content .msg').show();
					$('.loaded_content .msg').html(result.msg);
					$('.loaded_content .w3-green').css('width', result.percent + '%');
				}
				if(typeof(result.next_page) != 'undefined'){
					pdf_ajax(result.next_page, action);
				}
				if(typeof(result.download_file) != 'undefined'){
					var req = new XMLHttpRequest();
					req.open("GET", "https://stopforkids.com/ticket/pdf_save/" + result.download_file, true);
					req.responseType = "blob";
					req.onload = function (event) {
						var blob = req.response;
						var link = document.createElement('a');
						link.href = window.URL.createObjectURL(blob);
						link.download = result.download_file;
						link.click();
					};

					req.send();
				}
			},
			error: function(err){
				console.log(err);
			}
		});
	}
	$(document).on('click', '.btn_ex_print', function(e){
		e.preventDefault();
		var action = $(this).attr('data-action');
		if($(this).hasClass('load_ajax')){
			pdf_ajax(1, action);
		}else{
			$( "#ex_print_form" ).attr('action', action);
			$( "#ex_print_form" ).submit();
		}
	});
	$(document).on('click', '#select_all', function(e){
		console.log($(this).prop('checked'));
		if($(this).prop('checked')) $('.Plate_check').prop('checked', true);
		else $('.Plate_check').prop('checked', false);
	});
 </script>