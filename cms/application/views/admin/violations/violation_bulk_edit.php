<?php
$violation_ids = '';
$cameras = '';
$villages = '';
$type = 'all';

foreach ($_POST as $key => $value) {
  if ( strpos($key, 'camera__') !== FALSE ) {
    $id = trim(str_replace('camera__', '', $key));
    $cameras .= '<option value="'.$id.'">'.$value.'</option>';
  }
  else if ( strpos($key, 'village__') !== FALSE ) {
    $id = trim(str_replace('village__', '', $key));
    $villages .= '<option value="'.$id.'">'.$value.'</option>';
  }
  else {
    $violation_ids .= "<input type='hidden' name='$key' value='$value' />";
  }
}

if ( isset($_POST['type']) )
  $type = $_POST['type'];
?>

<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          Bulk Edit
        </h2>
        <a href="<?= base_url('admin/violations/' . $type); ?>" class="btn bg-deep-orange waves-effect pull-right">Violations List</a>
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

          <?php echo form_open_multipart(base_url('admin/violations/violation_bulk_edit/' . $type), 'class="form-horizontal"'); // Shang added $type parameter 
            echo $violation_ids;
            echo "<input type='hidden' name='type' value='$type' />"
          ?>
          <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="username">Village Curt</label>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                <div class="form-line">
                  <select class="form-control show-tick" id="village_court" name="village_court">
                    <option value="">-- Please select --</option>
                    <?php
                    echo $villages;
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
                    echo $cameras;
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="username">Violation status</label>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                <div class="form-line">
                  <select class="form-control show-tick" id="violation_status" name="violation_status">
                    <option value="" selected>-- Please select --</option>
                    <option value="1">New</option>
                    <option value="2">Reviewed</option>
                    <option value="3">Mailed</option>
                    <option value="4">Archived</option>
                    <option value="5">Dismissed</option>
                    <option value="6">Disputed</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="username">Payment status</label>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                <div class="form-line">
                  <select class="form-control show-tick" id="payment_status" name="payment_status">
                    <option value="">-- Please select --</option>
                    <option value="0">UnPaid</option>
                    <option value="1">paid</option>
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
                  <input type="text" id="notice_date_new" name="notice_date_new" value="" class="form-control datepicker">
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
                  <input type="text" id="due_date_new" name="due_date_new" value="" class="form-control datepicker">
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix">
            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
              <input type="submit" name="submit" value="Save" class="btn btn-primary m-t-15 waves-effect">
            </div>
          </div>

          <?php echo form_close(); ?>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.datepicker').datepicker({
      dateFormat: 'M dd yy'
    });
    $('.timepicker').timepicker({});
  });
</script>