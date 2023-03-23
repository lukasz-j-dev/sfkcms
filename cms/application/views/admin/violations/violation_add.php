<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    ADD Violations
                </h2>
                <a href="<?= base_url('admin/violations/'); ?>" class="btn bg-deep-orange waves-effect pull-right">Violations List</a>
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

                    <?php echo form_open(base_url('admin/violations/add'), 'class="form-horizontal"');  ?>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="username">Notice date</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="notice_date_new" name="notice_date_new" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="village_court">Village Court</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="village_court" name="village_court">
                                        <option value="">-- Please select --</option>
                                        <?php foreach ($violation['simple_villages'] as $simple_villages) { ?>
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
                            <label for="camera">Camera</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="camera" name="camera">
                                        <option value="">-- Please select --</option>
                                        <?php foreach ($violation['simple_cameras'] as $simple_cameras) { ?>
                                            <option value="<?= $simple_cameras['id']; ?>"><?= $simple_cameras['camera_location']; ?></option>
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
                            <label for="plate">Plate</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="plate" name="plate" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="state">State</label>
                        </div>

                        <?php $states = array("AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY"); ?>

                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="state" name="state">
                                        <option value="">-- Please select --</option>
                                        <?php foreach ($states as $state) { ?>
                                            <option value="<?= $state; ?>" <?= ($state == 'NY' ? ' selected="selected"' : ''); ?>><?= $state; ?></option>
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
                            <label for="type">Type</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php $plate_type = "AGC
AGR
AMB
ARG
ATD
ATV
AYG
BOB
BOT
CBS
CCK
CHC
CLG
CME
CMH
COM
CSP
DLR
EDU
FAR
FPW
GAC
GSC
GSM
HAC
HAM
HIF
HIR
HIS
HOU
HSM
IRP
ITP
JCA
JCL
JSC
JWV
LMA
LMB
LMC
LOC
LTR
LUA
MCD
MCL
MED
MOT
NLM
NYA
NYC
NYS
OMF
OML
OMO
OMR
OMS
OMT
OMV
ORC
ORG
ORM
PAS
PHS
PPH
PSD
RGC
RGL
SCL
SEM
SNO
SOS
SPC
SPO
SRF
SRN
STA
STG
SUP
THC
TOW
TRA
TRC
TRL
USC
USS
VAS
VPL
WUG";
                                    $plate_type_arr = explode("\n", $plate_type);
                                    ?>
                                    <select class="form-control show-tick" id="type" name="type">
                                        <option value="">-- Please select --</option>
                                        <?php
                                        foreach ($plate_type_arr as $ptr) {
                                            echo '<option value="' . $ptr . '">' . $ptr . '</option>';
                                        }
                                        ?>
                                        <option value="OTHER">OTHER</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="violation_date">Full Name</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="full_name" name="full_name" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="violation_date">Address 1</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="address1" name="address1" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="violation_date">Address 2</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" id="address2" name="address2" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="violation_date">City</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="city" name="city" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="violation_date">Zip</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="zip" name="zip" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="violation_date">Violation date</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="violation_date_new" name="violation_date_new" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="violation_time">Violation time</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="violation_time" name="violation_time" class="form-control timepicker">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="due_date">Due date</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="due_date_new" name="due_date_new" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="amount_due">Amount Due</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="amount_due" name="amount_due" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="plate_photo">Plate photo</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="plate_photo" name="plate_photo" placeHolder="URL to image" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="violation_video">Violation video</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="violation_video" placeHolder="URL to video" name="violation_video" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <input type="submit" name="submit" value="ADD" class="btn btn-primary m-t-15 waves-effect">
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
            dateFormat: 'M-dd-yy'
        });
        $('.timepicker').timepicker({});
        $('#village_court').on('change', function() {
            var village_court = this.value;
            $.ajax({
                url: '/cms/admin/villages/get_village_due/' + village_court + '/',
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                    if (typeof result.violation.fine_amount != 'undefined') $('#amount_due').val(result.violation.fine_amount);
                },
                error: function(err) {
                    console.log('err');
                    console.log(err);
                },
            });
        });
        $('#plate').on('blur', function() {
            var plate = this.value;
            $.ajax({
                url: '/cms/admin/plates/plate_search/' + plate + '/',
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                    if (typeof result.plate_details.id != 'undefined') {
                        $('#state').val(result.plate_details.state);
                        $('#type').val(result.plate_details.plate_type);
                        $('#type').selectpicker('refresh');
                        $('#full_name').val(result.plate_details.name);
                        $('#address1').val(result.plate_details.address);
                        $('#city').val(result.plate_details.city);
                        $('#zip').val(result.plate_details.zip_code);
                    }
                },
                error: function(err) {
                    console.log('err');
                    console.log(err);
                },
            });
        });
    });
</script>