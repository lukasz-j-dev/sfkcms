<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2 style="display: inline-block;"> ADD NEW COUNTRY</h2>
        <a href="<?= base_url('admin/location'); ?>" class="btn bg-deep-orange waves-effect pull-right"><i class="material-icons">list</i> COUNTRIES LIST</a>
      </div>
      <!-- /.card-header -->
      <div class="body">
        <div class="row clearfix">
          <?php echo validation_errors(); ?>           
          <?php echo form_open(base_url('admin/location/country/add'), 'class="form-horizontal"');  ?> 
            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                  <label for="username">Country Name</label>
              </div>
              <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                  <div class="form-group">
                      <div class="form-line">
                          <input type="text" name="country" class="form-control" id="name" placeholder="">
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
      <!-- /.box-body -->
    </div>
  </div>
</div> 