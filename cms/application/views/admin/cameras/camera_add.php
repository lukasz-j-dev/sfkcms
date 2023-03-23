<!-- Bootstrap Select Css -->

<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<div class="card">

  <div class="header">

    <h2>

      ADD Cameras

    </h2>

    <a href="<?= base_url('admin/cameras/'); ?>" class="btn bg-deep-orange waves-effect pull-right">Cameras List</a>

  </div>

  <div class="body">

    <div class="row clearfix">

      <div class="col-md-12">

        <?php if(isset($msg) || validation_errors() !== ''): ?>

          <div class="alert alert-warning alert-dismissible">

              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

              <h4><i class="icon fa fa-warning"></i> Alert!</h4>

              <?= validation_errors();?>

              <?= isset($msg)? $msg: ''; ?>

          </div>

        <?php endif; ?>

      </div>

       

      <?php echo form_open(base_url('admin/cameras/add'), 'class="form-horizontal"');  ?> 
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="village_court">Village Court</label>

            </div>
			<?php //print_r($camera['village']); ?>
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <select class="form-control show-tick" id="village_court" name="village_court">

                            <option value="">-- Please select --</option>
                            <?php foreach($camera['simple_villages'] as $simple_villages){ ?>
								<option value="<?= $simple_villages['id']; ?>"><?= $simple_villages['village_court']; ?></option>
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

                <label for="camera_location">Camera location</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                       <input type="text" id="camera_location" name="camera_location" class="form-control">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="camera_zip">Camera zip code</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                       <input type="number" min="10000" max="99999" id="camera_zip" name="camera_zip" class="form-control">

                    </div>

                </div>

            </div>

        </div>
		
        <div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="camera_model">Camera model</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="camera_model" name="camera_model" class="form-control">

                    </div>

                </div>

            </div>

        </div>

        <div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="date_installed">Date installed</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="date_installed" name="date_installed" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>

        <div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="gps"><a href="https://www.gps-coordinates.net/" target="_blank">GPS</a></label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="gps" name="gps" class="form-control">

                    </div>

                </div>

            </div>

        </div>

        <div class="row clearfix">

            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">

                <input type="submit" name="submit" value="ADD" class="btn btn-primary m-t-15 waves-effect">

            </div>

        </div>

      <?php echo form_close();?>

    </div>

  </div>

</div>

</div>

</div>
<script>
$(document).ready(function(){
	$('.datepicker').datepicker({ dateFormat: 'M-dd-y' });
	$('.timepicker').timepicker({});
});
</script>



