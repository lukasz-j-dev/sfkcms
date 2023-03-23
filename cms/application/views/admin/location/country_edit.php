<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2 style="display: inline;">&nbsp; EDIT COUNTRY</h2>
        <a href="<?= base_url('admin/location'); ?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> COUNTRIES LIST</a>
      </div>
      <div class="body">
        <div class="row clearfix">
          <?php validation_errors(); ?>
          <?php echo form_open(base_url('admin/location/country/edit/'.$country['id']), 'class="form-horizontal"' )?> 
            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                  <label for="username">Country Name</label>
              </div>
              <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                  <div class="form-group">
                      <div class="form-line">
                          <input type="text" name="country" value="<?= $country['name']; ?>" class="form-control" id="name" placeholder="">
                      </div>
                  </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                  <label for="username">Status</label>
              </div>
              <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                  <div class="form-group">
                      <div class="form-line">
                        <select class="form-control show-tick" name="status">
                          <option value="">-- Please select --</option>
                          <option value="1" <?= ($country['status'] == 1)?'selected': '' ?> >Active</option>
                          <option value="0" <?= ($country['status'] == 0)?'selected': '' ?>>Deactive</option>
                        </select>                        
                      </div>
                  </div>
              </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                    <input type="submit" name="submit" value="UPDATE" class="btn btn-primary m-t-15 waves-effect">
                </div>
            </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div> 
</div>

<!-- Autosize Plugin Js -->
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<!-- Custom Js -->
<script src="<?= base_url() ?>public/js/pages/forms/basic-form-elements.js"></script>
