<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
            MMC Import
        </h2>
        <!-- <a href="" class="btn bg-deep-orange waves-effect pull-right">Violations List</a> -->
      </div>

      <div class="body">
        <div class="row clearfix">
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

          <form action='<?php echo base_url('admin/mmc/importcsv'); ?>' class='dropzone' id='mmc-form'></form>

          <!--
          <?php //echo form_open_multipart(base_url('admin/mmc/importcsv'), 'class="form-horizontal"');  ?>

          <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="username">Import CSV</label>
            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                <div class="form-line">
                  <input type="file" id="mmc_xlsx" name="mmc_xlsx" class="form-control">
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix">
            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
              <input type="submit" name="submit" value="Save" class="btn btn-primary m-t-15 waves-effect">
            </div>
          </div>

          <?php //echo form_close(); ?>
          -->

          <script>
            Dropzone.options.mmcForm = { // camelized version of the `id`
              method: "post",
              paramName: "file", // The name that will be used to transfer the file
              maxFilesize: 20, // MB
              uploadMultiple: false,
              disablePreviews: false,
              init: function () {
                // When the upload is finished, either with success or an error.
                this.on('complete', function(file) {
                  // console.log(file);
                  if ( file.status == 'success' ) {
                    setTimeout(() => {
                      window.location.href = '<?php echo base_url('admin/mmc'); ?>';
                    }, 2000);
                  }
                  else {
                    setTimeout(() => {
                      window.location.href = '<?php echo base_url('admin/mmc/importcsv'); ?>';
                    }, 500);
                  }
                });
              }
            };
          </script>

        </div>
      </div>
    </div>
  </div>
</div>