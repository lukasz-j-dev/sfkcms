<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<div>
					<h2>
						Violation Import
					</h2>
					<a href="<?= base_url('admin/violations/all'); ?>" class="btn bg-deep-orange waves-effect pull-right">Violations List</a>
				</div>
				<div><p>The import will skip any rows where the combination of the fields plate AND violation date AND violation time already exists in the database, regardless of violation status.<br> If the violation time is within -60 min or +60 min, should also be skipped. During the import, each unique plate will be inserted into the plate table if it does not already exist. <br> The violation number is generated and other default values are inserted to the violation table (include violation status, amount etc).<br> The total violation count is updated in the plates table.</p></div>
			</div>

			<div class="body">
				<div class="clearfix">
					<div class="p-t-15 p-b-15">
						<?= form_open('admin/violations/download_sample_csv', ['id' => 'download_sample_csv_form']); ?>
						<p>Download sample file (.csv): <a style="cursor: pointer;" onclick="document.getElementById('download_sample_csv_form').submit();" >Click to download</a></p>
						<?= form_close(); ?>
					</div>

					<div class="col-md-12">

						<?php if (isset($msg) || validation_errors() !== '') : ?>
							<div class="alert alert-warning alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-warning"></i> Alert!</h4>
								<?= validation_errors(); ?>
								<?= isset($msg) ? $msg : ''; ?>
							</div>
						<?php endif; ?>

					</div>

					<?php if (isset($errors)): ?>
						<div class="alert alert-danger">
							<?php foreach($errors as $error): ?>
							<p><?= $error; ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if (isset($violation_total_count)): ?>
						<div class="alert alert-success">
							<p>You have uploaded this file <b><?= $file_name; ?></b>, here are the results:</p>
							<p>Violations in total: <b><?= $violation_total_count; ?></b></p>
							<p>Violations skipped: <b><?= $violation_skipped_count; ?></b>
								<?= isset($violation_skipped_url) ? '<a href="' . $violation_skipped_url . '" target="_blank" class="m-l-20" style="color: #fff;">(Download .csv)</a>' : '' ?>
							</p>
							<p>Violations created: <b><?= $violation_validated_count; ?></b></p>
						</div>
					<?php endif; ?>

					<?= form_open_multipart('admin/violations/import_save');?>

					<div class="mb-3">
						<input class="form-control" accept=".csv" type="file" name="violation_csv" required>
						<label for="violation_csv"><small>It only supports csv files</small></label>
					</div>

					<br /><br />

					<input class="btn btn-primary" type="submit" value="upload" />

					<?= form_close(); ?>

				</div>

			</div>
		</div>
	</div>
</div>
