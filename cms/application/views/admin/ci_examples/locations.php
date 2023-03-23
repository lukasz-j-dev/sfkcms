<!-- Bootstrap Select Css -->
<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
          <h2 style="display: inline-block;"> COUNTRY, STATE & CITY</h2>
      </div>
      <div class="body">
         <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="country">Country</label>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                    <div class="form-line">
                      <select class="form-control show-tick country" required name="country">
                       <option value="">Select Country</option>
                        <?php foreach($countries as $country):?>
                          <option value="<?= $country['id']; ?>"> <?= $country['name']; ?> </option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                </div>
            </div>
         </div>

         <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="country">State</label>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                    <div class="form-line state-wrapper">
                      <select class="form-control show-tick state" required name="state">
                       <option value="">Select State</option>
                      </select>
                    </div>
                </div>
            </div>
         </div>

         <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="country">City</label>
            </div>
            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                    <div class="form-line city-wrapper">
                      <select class="form-control show-tick city" required name="city">
                       <option value="">Select City</option>
                      </select>
                    </div>
                </div>
            </div>
         </div>
      </div>
    </div>
  </div> 
</div>


<!-- Autosize Plugin Js -->
<script src="<?= base_url() ?>public/plugins/autosize/autosize.js"></script>
<!-- Moment Plugin Js -->
<script src="<?= base_url() ?>public/plugins/momentjs/moment.js"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="<?= base_url() ?>public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<!-- Custom Js -->
<script src="<?= base_url() ?>public/js/pages/forms/basic-form-elements.js"></script>


<script>

var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';

var csfr_token_value = '<?php echo $this->security->get_csrf_hash(); ?>';

$(function(){
  //-------------------------------------------------------------------
  // Country State & City Change

  $(document).on('change','select.country',function()
  {
    if(this.value == '')
    {
      $('.state').html('<option value="">Select State</option>');

      $('.city').html('<option value="">Select City</option>');

      return false;
    }

    var data =  {

      country : this.value,

    }

    data[csfr_token_name] = csfr_token_value;

    $.ajax({

      type: "POST",

      url: "<?= base_url('admin/ci_examples/get_country_states') ?>",

      data: data,

      dataType: "json",

      success: function(obj) {

        $('.state-wrapper').html(obj.msg);

     },
    });
  });

  $(document).on('change','select.state',function()
  {

    var data =  {

      state : this.value,

    }

    data[csfr_token_name] = csfr_token_value;

    $.ajax({

      type: "POST",

      url: "<?= base_url('admin/ci_examples/get_state_cities') ?>",

      data: data,

      dataType: "json",

      success: function(obj) {

        $('.city-wrapper').html(obj.msg);

     },

    });

  });

});
</script>