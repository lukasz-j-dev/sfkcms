<!-- Bootstrap Select Css -->
<style>
.err{
	color: red;
}
</style>
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<div class="card">

  <div class="header">

    <h2>

      ADD Plates

    </h2>

    <a href="<?= base_url('admin/plates/'); ?>" class="btn bg-deep-orange waves-effect pull-right">Plates List</a>

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

       

      <?php echo form_open(base_url('admin/plates/add'), 'class="form-horizontal"');  ?> 

        <div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Plate</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="plate" name="plate" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Plate Type</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="plate_type" name="plate_type" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Name</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="name" name="name" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Address</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="address" name="address" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">City</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="city" name="city" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">State</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="state" name="state" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Zip Code</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="zip_code" name="zip_code" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Vin</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="vin" name="vin" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Body</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="body" name="body" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Year</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="year" name="year" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Make</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="make" name="make" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Color</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="color" name="color" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Dmv Date Checked</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="dmv_date_checked" name="dmv_date_checked" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Dmv Status</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="dmv_status" name="dmv_status" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Expiration Date</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="exp_date" name="exp_date" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Sex</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="sex" name="sex" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Birth Date</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="birth_date" name="birth_date" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Country</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="country" name="country" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Mid Number</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="mid_number" name="mid_number" class="form-control datepicker">

                    </div>

                </div>

            </div>

        </div>
		
		<div class="row clearfix">

            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">

                <label for="username">Screenshot</label>

            </div>

            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">

                <div class="form-group">

                    <div class="form-line">

                        <input type="text" id="screenshot" name="screenshot" class="form-control datepicker">

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
	$('#plate').on('blur', function(){
		var plate = this.value;
		var elm = $(this);
		$('.err').remove();
		$.ajax({
			url: '<?= base_url('admin/plates/is_exist'); ?>',
			type: 'post',
			dataType: 'json',
			data: {plate: plate},
			success: function(result){
				console.log(result);
				if(result.success){
					if(result.records) elm.parent().parent().append('<span class="err">The plate number already exists</span>');
				}
			},
			error: function(err){
				console.log('err');
				console.log(err);
			}
		});
	});
});
</script>