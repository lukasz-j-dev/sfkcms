<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2 style="display: inline-block;">&nbsp; ADD NEW CITY</h2>
        <a href="<?= base_url('admin/location/city'); ?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> CITIES LIST</a>
      </div>
      <div class="body">
        <?php echo validation_errors(); ?>           
        <?php echo form_open(base_url('admin/location/city/add'), 'class="form-horizontal"');  ?> 
        <div class="row clearfix">
          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="country">State Name</label>
          </div>
          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                  <div class="form-line">
                    <select class="form-control show-tick" required name="state">
                    <option>Select State</option>
                    <?php foreach($states as $state):?>
                      <?php if($city['state_id'] == $state['id']): ?>
                      <option value="<?= $state['id']; ?>" selected> <?= $state['name']; ?> </option>
                    <?php else: ?>
                      <option value="<?= $state['id']; ?>"> <?= $state['name']; ?> </option>
                  <?php endif; endforeach; ?>
                  </select>
                  </div>
              </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
              <label for="country">City Name</label>
          </div>
          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
              <div class="form-group">
                  <div class="form-line">
                   <input type="text" name="city" class="form-control" id="name" placeholder="city name" required>
                  </div>
              </div>
          </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                <input type="submit" name="submit" value="ADD" class="btn btn-primary m-t-15 waves-effect">
            </div>
          </div>
        <?php echo form_close( ); ?>
      </div>
    </div>
  </div> 
</div>

<!-- Autosize Plugin Js -->
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<!-- Custom Js -->
<script src="<?= base_url() ?>public/js/pages/forms/basic-form-elements.js"></script>
