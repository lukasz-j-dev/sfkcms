<link href="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">  
<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<!-- Dropzone Css -->
<link href="<?= base_url() ?>public/plugins/dropzone/dropzone.css" rel="stylesheet">

 <!-- Content Wrapper. Contains page content -->
 <div class="row clearfix">
 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
 		<div class="card">
 			<div class="header">
                <h2>
                    MULTIPLE FILES UPLOAD EXAMPLE
                </h2>
            </div>
            <div class="body">
            	<!-- Upload  -->
				<?php echo form_open_multipart(base_url('admin/ci_examples/multi_file_upload'), 'class="dropzone" id="myDropzone"');?>
					<div class="dz-message">
	                    <div class="drag-icon-cph">
	                        <i class="material-icons">touch_app</i>
	                    </div>
	                    <h3>Drop files here or click to upload.</h3>
	                </div>
                  <input type="file" name="files[]" class="hidden" multiple/>
				<?php echo form_close(); ?>
					<p><small class="text-success">Allowed Types: gif, jpg, png, jpeg | Maximum Allowed Size : 2 MB | Maximum Files : 10</small></p>
            </div>
 		</div> 

 		<div class="card">
 			<div class="header">
                <h2>
                    UPLOADED FILES
                </h2>
            </div>
 			<div class="body table-responsive">
				<table id="example1" class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Image</th>
							<th>Path/Info</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php $counter = 1; foreach($files as $file): ?>
						<tr>
							<td><?= $counter ?></td>
							<td>
								<img src="<?= base_url($file['name']) ?>" width="70">
							</td>
							<td><?= $file['name'] ?></td>
							<td>
								<a href="<?= base_url('admin/ci_examples/delete_file/'.$file['id']) ?>" class="btn btn-danger btn-delete btn-sm"><i class="material-icons">delete</i></a>
							</td>
						</tr>
						<?php $counter++; endforeach;  ?>
					</tbody>
				</table>
			</div>	
 		</div>
 	</div>
 </div>

 <!-- Jquery DataTable Plugin Js -->
<script src="<?= base_url()?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?= base_url()?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<!-- Dropzone Plugin Js -->
<script src="<?= base_url() ?>public/plugins/dropzone/dropzone.js"></script>
<script>
	$("#example1").DataTable();
</script>