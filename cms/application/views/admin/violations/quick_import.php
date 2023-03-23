<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <div>
          <h2>
            Quick Import
          </h2>
          <a href="<?= base_url('admin/violations/all'); ?>" class="btn bg-deep-orange waves-effect pull-right">Violations List</a>
        </div>
        <div>
          <p>The import will skip any rows where the combination of the fields plate AND violation date AND violation date already exists in the database, regardless of violation status.</p>
        </div>
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

          <form action='<?php echo base_url('admin/violations/quick_import_csv/' . $type); ?>' class='dropzone' id='quick-import-form'>

          <?php //echo form_open_multipart(base_url('admin/violations/quick_import_csv/' . $type), 'class="form-horizontal"'); // Shang added $type parameter  
          ?>

          <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="username">Village Court</label>
            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                <div class="form-line">
                  <select class="form-control show-tick" id="village_court" name="village_court">
                    <option value="">-- Please select --</option>
                    <?php
                    foreach ($villages as $village) { ?>
                      <option value="<?= $village['id']; ?>"><?= $village['village_court']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="username">Camera Location</label>
            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                <div class="form-line">
                  <select class="form-control show-tick" id="camera_location" name="camera_location">
                    <option value="">-- Please select --</option>
                    <?php
                    foreach ($cameras as $camera) { ?>
                      <option value="<?= $camera['id']; ?>"><?= $camera['camera_location']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="username">Notice date new</label>
            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                <div class="form-line">
                  <?php
                  $date = date('Y-m-d');
                  $ndn = date('M d Y', strtotime($date . ' + 2 days'));
                  ?>
                  <input type="text" id="notice_date_new" name="notice_date_new" value="<?= $ndn; ?>" class="form-control datepicker">
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="username">Due date new</label>
            </div>
            
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                <div class="form-line">
                  <?php
                  $ndn = date('M d Y', strtotime($ndn . ' + 30 days'));
                  ?>
                  <input type="text" id="due_date_new" name="due_date_new" value="<?= $ndn; ?>" class="form-control datepicker">
                </div>
              </div>
            </div>
          </div>

          <!--
          <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="username">Quick Import XLSX</label>
            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                <div class="form-line">
                  <input type="file" id="violation_xlsx" name="violation_xlsx" class="form-control">
                </div>
              </div>
            </div>
          </div>
          -->

          <div class="row clearfix">
            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
              <input type="button" name="submit" id="submit" value="Save" class="btn btn-primary m-t-15 waves-effect">
            </div>
          </div>

          <?php //echo form_close(); ?>

          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  Dropzone.options.quickImportForm = { // camelized version of the `id`
    method: "post",
    parallelUploads: 1,
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 20, // MB
    uploadMultiple: false,
    disablePreviews: false,
    autoProcessQueue: false,
    init: function () {
      var that = this;
      var startUpload = document.getElementById("submit");
      startUpload.addEventListener("click", function () {
        that.processQueue();
      });

      // When the upload is finished, either with success or an error.
      this.on('complete', function(file) {
        // console.log(file);
        if ( file.status == 'success' ) {
          setTimeout(() => {
            window.location.href = '<?php echo base_url('admin/violations/'.$type); ?>';
          }, 2000);
        }
        else {
          setTimeout(() => {
            window.location.href = '<?php echo base_url('admin/violations/quick_import'); ?>';
          }, 500);
        }
      });
    }
  };

  $(document).ready(function() {
    $('.datepicker').datepicker({
      dateFormat: 'M dd yy'
    });
    $('.timepicker').timepicker({});
  });
</script>