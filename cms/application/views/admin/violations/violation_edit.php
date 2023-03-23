<style>
    .err {
        color: red;
    }

    .succ {
        color: green;
    }

    .form-group.dmv {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form.dmv {
        margin-left: 10px;
    }

    .tooltip-plate {
        cursor: pointer;
    }
</style>

<link href="<?= base_url() ?>public/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<link rel="stylesheet" href="/slim-image-cropper/example/css/slim.min.css">
<link href="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<div class="similar-tooltip" style="width: 800px; display: none; display: flex;"></div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="cards">
            <div class="header">
                <h2>
                    Edit Violations
                </h2>

                <div class="row clearfix">
                    <div class="violation_nav">
                        <div class="nav-left">
                            <?php if (isset($prev_violation) && isset($prev_violation['id']) && !empty($prev_violation['id'])) { ?><a class="btn btn-primary prev" href="<?php echo base_url('admin/violations/edit/' . $prev_violation['id']); ?>">Previous</a><?php } ?>
                        </div>
                        <div class="nav-middle">
                            <button type="submit" name="submit" value="SAVE" class="btn btn-primary m-t-15 waves-effect" id="savee">SAVE</button>
                            <button type="submit" name="submit" value="UPDATE" class="btn btn-primary m-t-15 waves-effect" id="sub">UPDATE</button>
                            <span><a href="<?= "/ticket/print_ticketpdf.php?violation_id=" . $violation['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT); ?>" class="btn btn-primary m-t-15 waves-effect">PDF</a></span>
                            <span><a target="_blank" href="<?= site_url("../violations/" . $violation['violation_number'] . '-' . $violation['pin']); ?>" class="btn btn-primary m-t-15 waves-effect">WEB</a></span>
							<button data-href="<?= base_url('admin/violations/del/' . $violation['id']); ?>" type="submit" name="submit" value="DELETE" class="btn btn-danger m-t-15 waves-effect" id="delete" data-toggle="modal" data-target="#confirm-delete">DELETE</button>
						</div>
                        <div class="nav-right">
                            <?php if (isset($next_violation) && isset($next_violation['id']) && !empty($next_violation['id'])) { ?><a class="btn btn-primary next" href="<?php echo base_url('admin/violations/edit/' . $next_violation['id']); ?>">Next</a><?php } ?>
                        </div>
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

                        <?php echo form_open_multipart(base_url('admin/violations/edit/' . $violation['id']), 'id="editt" class="form-horizontal"') ?>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-5 form-control-label">
                                <label>Ticket Id</label>: <label> <span style="vertical-align: middle; display: inline-block;"><a target="_blank" href="<?= site_url("../violations/" . $violation['violation_number'] . '-' . $violation['pin']); ?>"><?= $violation['id']; ?></a></label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 form-control-label">
                                <label>Violation number</label>: <span style="vertical-align: middle; display: inline-block;"><?= $violation['violation_number']; ?> - <?= $violation['pin']; ?></label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-5 form-control-label">
                                <label>Added By</label>: <span style="vertical-align: middle; display: inline-block;"><?= $violation['added_by_details']; ?></span>
                            </div>

                            <!-- Shang -->
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-5 form-control-label">
                                <?php
                                // $sd = ($sixty_days == 1) ? ' in 60 days' : '';
                                $sd = '';
                                if (isset($sixty_days) && $sixty_days == 1)
                                    $sd = ' in 60 days';
                                ?>
                                <label>Total</label>: <span style="vertical-align: middle; display: inline-block;"><?= $total . $sd; ?></span>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5 form-control-label">
                                <?php
                                $warning_period = isset($warning_period) ? $warning_period : '';
                                ?>
                                <label>Warning Period</label>: <span style="vertical-align: middle; display: inline-block;"><?= $warning_period; ?></span>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <label for="username">Violation status:</label>
                            </div>
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
								<label for="username">Violation type:</label>
							</div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <label for="village_court">Village Court:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <label for="camera">Camera:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label d-flex">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding-left: 0px;">
                                    <label for="camera">Plate:</label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
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

                                    <select class="form-control show-tick" id="type" name="type" disabled>
                                        <option value="">-- Please select --</option>
                                        <?php
                                        foreach ($plate_type_arr as $ptr) {
                                            echo '<option value="' . $ptr . '"' . (($violation['type'] == $ptr) ? ' selected="selected"' : '') . '>' . $ptr . '</option>';
                                        }
                                        ?>
                                        <option value="OTHER" <?= ($violation['type'] == 'OTHER') ? ' selected="selected"' : ''; ?>>OTHER</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="status" name="status">
                                            <option value="">-- Please select --</option>
                                            <option value="1" <?= ($violation['status'] == '1') ? ' selected="selected"' : ''; ?>>New</option>
                                            <option value="2" <?= ($violation['status'] == '2') ? ' selected="selected"' : ''; ?>>Reviewed</option>
                                            <option value="3" <?= ($violation['status'] == '3') ? ' selected="selected"' : ''; ?>>Mailed</option>
                                            <option value="4" <?= ($violation['status'] == '4') ? ' selected="selected"' : ''; ?>>Archived</option>
                                            <option value="5" <?= ($violation['status'] == '5') ? ' selected="selected"' : ''; ?>>Dismissed</option>
                                            <option value="6" <?= ($violation['status'] == '6') ? ' selected="selected"' : ''; ?>>Disputed</option>
											<option value="7" <?= ($violation['status'] == '7') ? ' selected="selected"' : ''; ?>>Ready</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
								<div class="form-group">
									<div class="form-line">
										<select class="form-control show-tick" id="violation_type" name="violation_type">
											<option value="">-- Please select --</option>
											<option value="1" <?= ($violation['violation_type'] == '1') ? ' selected="selected"' : ''; ?>>Violation</option>
											<option value="2" <?= ($violation['violation_type'] == '2') ? ' selected="selected"' : ''; ?>>Warning</option>
										</select>
									</div>
								</div>
							</div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <div class="form-group">
                                    <div class="form-line village-court-row">
                                        <select class="form-control show-tick" id="village_court" name="village_court">
                                            <option value="">-- Please select --</option>
                                            <?php foreach ($violation['simple_villages'] as $simple_villages) { ?>
                                                <option value="<?= $simple_villages['id']; ?>" <?= ($violation['village_court'] == $simple_villages['id']) ? ' selected="selected"' : ''; ?>><?= $simple_villages['village_court']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <div class="form-group">
                                    <div class="form-line camera-row">
                                        <select class="form-control show-tick" id="camera" name="camera">
                                            <option value="">-- Please select --</option>
                                            <?php foreach ($violation['simple_cameras'] as $simple_cameras) { ?>
                                                <option value="<?= $simple_cameras['id']; ?>" <?= ($violation['camera'] == $simple_cameras['id']) ? ' selected' : ''; ?>><?= $simple_cameras['camera_location']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <div class="form-group dmv">
                                    <div class="form-line">
                                        <input type="text" id="plate" name="plate" value="<?= $violation['plate']; ?>" class="form-control">
                                    </div>
                                    <?php
                                    if (empty($violation['address1'])) { ?>
                                        <div class="form dmv">
                                            <a class="btn btn-info btn-dmv-api" href="#">DMV API lookup</a>
                                            <input type="hidden" id="dmv-url" name="dmv-url" value="<?php echo base_url('admin/plates/dmv_api/') . strtoupper($violation['plate']); ?>">
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix address-row">

                            <!-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label"> -->
                            <!-- <label for="violation_date">Address:</label> -->
                            <!-- </div> -->

                            <div class="col-lg-11 col-md-11 col-sm-1 col-xs-11">
                                <div class="form-group" style="padding-left: 15px;">
                                    <div class="form-line">
                                        <?php if (!empty($violation['full_name'])) { ?>
                                            <input type="text" id="full_name" name="full_name" disabled class="form-control" value="<?= $violation['full_name']; ?>">
                                        <?php } ?>

                                        <?php if (!empty($violation['address1'])) { ?>
                                            <input type="text" id="address1" name="address1" disabled class="form-control" value="<?= $violation['address1']; ?>">
                                        <?php } ?>

                                        <?php if (!empty($violation['address2'])) { ?>
                                            <input type="text" id="address2" name="address2" disabled class="form-control" value="<?= $violation['address2']; ?>">
                                        <?php } ?>

                                        <div class="city-state-row" style="display: flex; align-items: center;">

                                            <?php if (!empty($violation['city'])) { ?>
                                                <input type="text" id="city" name="city" disabled value="<?= $violation['city']; ?>" class="form-control" style="max-width: 100px;">
                                            <?php } ?>

                                            <?php if (!empty($violation['state'])) { ?>
                                                , <input type="text" id="state" name="state" disabled value="<?= $violation['state']; ?>" class="form-control" style="max-width: 20px;">
                                            <?php } ?>

                                            <?php //$states = array("AL", "AK", "AZ","AR", "CA", "CO", "CT", "DE","FL", "GA","HI", "ID", "IL","IN", "IA", "KS", "KY", "LA","ME", "MD","MA", "MI", "MN","MS", "MO", "MT", "NE", "NV","NH", "NJ","NM", "NY", "NC","ND", "OH", "OK", "OR", "PA","RI", "SC", "SD", "TN", "TX","UT", "VT", "VA", "WA", "WV","WI", "WY"); 
                                            ?>

                                            <?php if (!empty($violation['zip'])) { ?>
                                                , <input type="text" id="zip" name="zip" disabled value="<?= $violation['zip']; ?>" class="form-control" style="max-width: 40px;">
                                            <?php } ?>
                                        </div>
                                        <!--End of city-state-row-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <label for="violation_date">Notice date:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <label for="violation_date">Violation date:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <label for="violation_date">Violation time:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <label for="violation_date">Due date:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <label for="violation_date">Date added:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                <label for="violation_date">Date paid:</label>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <?php
                                        $ndn = $violation['notice_date_new'];
                                        if ($ndn == NULL || $ndn == '0000-00-00 00:00:00')
                                            $ndn = '';
                                        else $ndn = date('M d Y', strtotime($violation['notice_date_new']));
                                        ?>
                                        <input type="text" id="notice_date_new" name="notice_date_new" value="<?= $ndn; ?>" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <?php $ndnd = $violation['violation_date_new'];
                                        if ($ndnd == NULL || $ndnd == '0000-00-00 00:00:00')
                                            $ndnd = '';
                                        else $ndnd = date('M d Y', strtotime($violation['violation_date_new']));
                                        ?>
                                        <input type="text" id="violation_date_new" name="violation_date_new" value="<?= $ndnd; ?>" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="violation_time" name="violation_time" value="<?= $violation['violation_time']; ?>" class="form-control timepicker">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <?php $ndndd = $violation['due_date_new'];
                                        if ($ndndd == NULL || $ndndd == '0000-00-00 00:00:00')
                                            $ndndd = '';
                                        else $ndndd = date('M d Y', strtotime($violation['due_date_new']));
                                        ?>
                                        <input type="text" id="due_date_new" name="due_date_new" value="<?= $ndndd; ?>" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <?php $ndnddd = $violation['date_added_new'];
                                        if ($ndnddd == NULL || $ndndd == '0000-00-00 00:00:00')
                                            $ndnddd = '';
                                        else $ndnddd = date('M d Y', strtotime($violation['date_added_new']));
                                        ?>
                                        <input type="text" id="date_added_new" name="date_added_new" value="<?= $ndnddd; ?>" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <?php
                                        $dpn = $violation['date_paid_new'];
                                        if ($dpn == NULL || $dpn == '0000-00-00 00:00:00')
                                            $dpn = '';
                                        else $dpn = date('M d Y', strtotime($violation['date_paid_new']));
                                        ?>
                                        <input type="text" id="date_paid_new" name="date_paid_new" value="<?= $dpn; ?>" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-control-label">
                                <label for="plate_photo">Plate photo:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="plate_photo" name="plate_photo" placeHolder="URL to image" value="<?= $violation['plate_photo']; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-control-label">
                                <label for="violation_video">Violation video:</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="violation_video" name="violation_video" placeHolder="URL to video" value="<?= $violation['violation_video']; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-control-label">
                                <?php if (!empty($violation['plate_photo'])) { ?>
                                    <img src="<?= $violation['plate_photo']; ?>" style="max-width: 100%; width: 100%; height: 50vh;" />

                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-control-label">
                                <?php if (!empty($violation['violation_video'])) { ?>
                                    <video style="width: 100%; height: 50vh;" controls>
                                        <source src="<?= $violation['violation_video']; ?>" type="video/mp4">
                                        Your browser does not support the video.
                                    </video>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-control-label">
                                <div style="padding-bottom: 15px;text-decoration:underline;"><b>Plates DMV:</b></div> <!-- Shang -->
                                <?php if (!empty($plate_details['body'])) { ?>
                                    <div>
                                        <label for="violation_video">Body: </label><span> <?php echo $plate_details['body']; ?></span>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($plate_details['make'])) { ?>
                                    <div>
                                        <label for="violation_video">Make: </label><span> <?php echo $plate_details['make']; ?></span>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($plate_details['year'])) { ?>
                                    <div>
                                        <label for="violation_video">Year: </label><span> <?php echo $plate_details['year']; ?></span>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($plate_details['color'])) { ?>
                                    <div>
                                        <label for="violation_video">Color: </label><span> <?php echo $plate_details['color']; ?></span>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($plate_details['plate_type'])) { ?>
                                    <div>
                                        <label for="violation_video">Plate type: </label><span> <?php echo $plate_details['plate_type']; ?></span>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($plate_details['state'])) { ?>
                                    <div>
                                        <label for="violation_video">State: </label><span> <?php echo $plate_details['state']; ?></span>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($plate_details['dmv_status'])) { ?>
                                    <div>
                                        <label for="violation_video">DMV status: </label><span> <?php echo $plate_details['dmv_status']; ?></span>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($plate_details['exp_date'])) { ?>
                                    <div>
                                        <label for="violation_video">Expiration date: </label><span> <?php echo $plate_details['exp_date']; ?></span>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($plate_details['plate'])) { ?>
                                    <div>
                                        <label for="violation_video">Plate Number: </label><span> <?php echo $plate_details['plate']; ?></span>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-control-label d-flex">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-control-label">
                                    <div style="padding-bottom: 15px;text-decoration:underline;"><b>Plates MMC API:</b></div> <!-- Shang -->
                                    <?php if (!empty($mmc_details['vehicle_type'])) { ?>
                                        <div>
                                            <label for="violation_video">Body: </label><span> <?php echo $mmc_details['vehicle_type']; ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($mmc_details['make'])) { ?>
                                        <div>
                                            <label for="violation_video">Make: </label><span> <?php echo $mmc_details['make']; ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($mmc_details['model'])) { ?>
                                        <div>
                                            <label for="violation_video">Model: </label><span> <?php echo $mmc_details['model']; ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($mmc_details['color'])) { ?>
                                        <div>
                                            <label for="violation_video">Color: </label><span> <?php echo $mmc_details['color']; ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($mmc_details['plate_score'])) { ?>
                                        <div>
                                            <label for="violation_video">Score: </label><span> <?php echo $mmc_details['plate_score']; ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($mmc_details['plate_region'])) { ?>
                                        <div>
                                            <label for="violation_video">State: </label><span> <?php echo $mmc_details['plate_region']; ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($mmc_details['plate'])) { ?>
                                        <div>
                                            <label for="violation_video">Plate Number: </label><span> <?php echo $mmc_details['plate']; ?></span>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-control-label">
                                    <div style="padding-bottom: 15px;text-decoration:underline;"><b>Stop classification:</b></div> <!-- Shang -->
                                    <div>
                                        <select class="form-control show-tick" id="stop_classification" name="stop_classification">
                                            <option value="fail" <?= ($violation['stop_classification'] == 'fail' || $violation['stop_classification'] == '') ? ' selected="selected"' : ''; ?>>Fail</option>
                                            <option value="fullstop" <?= ($violation['stop_classification'] == 'fullstop') ? ' selected="selected"' : ''; ?>>Full Stop</option>
                                            <option value="sloweddown" <?= ($violation['stop_classification'] == 'sloweddown') ? ' selected="selected"' : ''; ?>>Slowed Down</option>
                                            <option value="wrongdirection" <?= ($violation['stop_classification'] == 'wrongdirection') ? ' selected="selected"' : ''; ?>>Wrong direction</option>
                                        </select>
                                    </div>
                                </div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-control-label">
									<div style="padding-bottom: 15px;text-decoration:underline;"><b>Threshold:</b></div>
									<div>
										<label>Threshold limit: </label><span> <?= $violation['threshold_limit'] ?: 'N/A'; ?></span>
									</div>
									<div>
										<label>Threshold time: </label><span> <?= $violation['threshold_time'] ?: 'N/A'; ?></span>
									</div>
								</div>
                            </div>
                        </div>

                        <?php
                        $sp = '';
                        if (isset($similar_mmc_plates) && is_array($similar_mmc_plates) && count($similar_mmc_plates)) {
                            foreach ($similar_mmc_plates as $idx => $s_plate) {
                                if (strtoupper($violation['plate']) != $s_plate['plate'])
                                    $sp .= '<span class="tooltip-plate" data-id="' . $s_plate['plate'] . '" data-idx="mmc-' . $s_plate['plate'] . '-' . $idx . '">' . $s_plate['plate'] . '</span>, ';
                            }
                            if (strlen($sp))
                                $sp = substr($sp, 0, -2);
                        }

                        $dmvp = '';
                        if (isset($similar_dmv_plates) && is_array($similar_dmv_plates) && count($similar_dmv_plates)) {
                            foreach ($similar_dmv_plates as $idx => $d_plate) {
                                if (strtoupper($violation['plate']) != $d_plate['plate'])
                                    $dmvp .= '<span class="tooltip-plate" data-id="' . $d_plate['plate'] . '" data-idx="dmv-' . $d_plate['plate'] . '-' . $idx . '">' . $d_plate['plate'] . '</span>, ';
                            }
                            if (strlen($dmvp))
                                $dmvp = substr($dmvp, 0, -2);
                        }
                        ?>
                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 form-control-label">
                                <div class="mmc-plate">
                                    <label for="status">Similar DMV Plates found:&nbsp;&nbsp;&nbsp;</label><?php echo $dmvp; ?>
                                </div>
                                <div class="dmv-plate">
                                    <label for="status">Similar MMC Plates found:&nbsp;&nbsp;&nbsp;</label><?php echo $sp; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="status">Payment Status:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="status">Amount Due:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="status">Amount paid:</label>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="payment_status" name="payment_status">
                                            <option value="">-- Please select --</option>
                                            <option value="0" <?= ($violation['payment_status'] == '0') ? ' selected="selected"' : ''; ?>>Unpaid</option>
                                            <option value="1" <?= ($violation['payment_status'] == '1') ? ' selected="selected"' : ''; ?>>Paid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="amount_due" name="amount_due" value="<?= $violation['amount_due']; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="amount_paid" name="amount_paid" value="<?= $violation['amount_paid']; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix" id="valreson" <?= ($violation['status'] != '5') ? 'style="display:none"' : ''; ?>>
                            <div class=" col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="amount_paid">Dismiss reason</label>
                            </div>
                            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea class="form-control" id="dismissres" name="dismissreason" rows="4" cols="50">
                                        <?= $violation['dismissreason']; ?>
                                    </textarea>
                                    </div>
                                </div>
                                <div style="display:none; color:red;" class="message" id="resvalidation">Max 60 Characters</div>
                            </div>
                        </div>

                        <div style="display:none;" class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="check_mo_copy">Check/MO copy</label>
                            </div>
                            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <div class="slim">
                                            <input type="file" id="check_mo_copy" name="check_mo_copy" accept="image/jpeg, image/gif" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($violation['check_mo_copy'])) { ?>
                                    <div style="margin-top: 10px;">
                                        <img src="<?= base_url("public/images/violations/" . $violation['check_mo_copy']); ?>" style="max-height: 120px;" />
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row clearfix edit-form-new">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                <label for="payment_method">Payment method</label>
                            </div>
                            <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="payment_method" name="payment_method">
                                            <option value="">-- Please select --</option>
                                            <option value="Credit card" <?= ($violation['payment_method'] == 'Credit card') ? ' selected="selected"' : ''; ?>>Credit card</option>
                                            <option value="Check/Money Order" <?= ($violation['payment_method'] == 'Check/Money Order') ? ' selected="selected"' : ''; ?>>Check/Money Order</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php echo form_close(); ?>

                        <div class="row clearfix">
                            <div class="violation_nav">
                                <div class="nav-left">
                                    <?php if (isset($prev_violation) && isset($prev_violation['id']) && !empty($prev_violation['id'])) { ?><a class="btn btn-primary prev" href="<?php echo base_url('admin/violations/edit/' . $prev_violation['id']); ?>">Previous</a><?php } ?>
                                </div>
                                <div class="nav-middle">
                                    <button type="submit" name="submit" value="SAVE" class="btn btn-primary m-t-15 waves-effect" id="savee">SAVE</button>
                                    <button type="submit" name="submit" value="UPDATE" class="btn btn-primary m-t-15 waves-effect" id="sub">UPDATE</button>
                                    <span><a href="<?= "/ticket/print_ticketpdf.php?violation_id=" . $violation['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT); ?>" class="btn btn-primary m-t-15 waves-effect">PDF</a></span>
                                    <span><a target="_blank" href="<?= site_url("../violations/" . $violation['violation_number'] . '-' . $violation['pin']); ?>" class="btn btn-primary m-t-15 waves-effect">WEB</a></span>
                                </div>
                                <div class="nav-right">
                                    <?php if (isset($next_violation) && isset($next_violation['id']) && !empty($next_violation['id'])) { ?><a class="btn btn-primary next" href="<?php echo base_url('admin/violations/edit/' . $next_violation['id']); ?>">Next</a><?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix" style="margin-top: 50px;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <div><p>List of other violations with the same plate number or vehicles at this location address, including archived violations.</p></div>
                                    <div class="table-responsive">

                                        <table id="other_v_datatable" class="table table-bordered table-striped table-hover dataTable">
                                            <thead>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Thumbnail</th>
                                                    <th>Video</th>
                                                    <th>Violation number</th>
                                                    <th>Plate</th>
                                                    <th>Violation date/time</th>
                                                    <th>Notice date</th>
                                                    <th>Status</th>
                                                    <th>Camera</th>
                                                    <th>Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Zipcode</th>
                                                    <th>First notice date</th>
								                    <th>Warning Period</th>
                                                    <th>DMV Status</th>
													<th>Type</th>
                                                    <th width="80" class="text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>#ID</th>
                                                    <th>Thumbnail</th>
                                                    <th>Video</th>
                                                    <th>Violation number</th>
                                                    <th>Plate</th>
                                                    <th>Violation date/time</th>
                                                    <th>Notice date</th>
                                                    <th>Status</th>
                                                    <th>Camera</th>
                                                    <th>Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Zipcode</th>
                                                    <th>First notice date</th>
								                    <th>Warning Period</th>
                                                    <th>DMV Status</th>
													<th>Type</th>
                                                    <th width="80" class="text-right">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

					<div class="row clearfix" style="margin-top: 50px;">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="form-line">
									<div><p>List of other violations that have duplicate images or videos or a combination of plate number and violation date (+-6 hours)</p></div>
									<div class="table-responsive">

										<table id="duplicates_datatable" class="table table-bordered table-striped table-hover dataTable">
											<thead>
											<tr>
												<th>#ID</th>
												<th>Thumbnail</th>
												<th>Video</th>
												<th>Violation number</th>
												<th>Plate</th>
												<th>Violation date/time</th>
												<th>Notice date</th>
												<th>Status</th>
												<th>Camera</th>
												<th>Address</th>
												<th>City</th>
												<th>State</th>
												<th>Zipcode</th>
												<th>First notice date</th>
												<th>Warning Period</th>
												<th>DMV Status</th>
												<th>Type</th>
												<th width="80" class="text-right">Action</th>
											</tr>
											</thead>
											<tfoot>
											<tr>
												<th>#ID</th>
												<th>Thumbnail</th>
												<th>Video</th>
												<th>Violation number</th>
												<th>Plate</th>
												<th>Violation date/time</th>
												<th>Notice date</th>
												<th>Status</th>
												<th>Camera</th>
												<th>Address</th>
												<th>City</th>
												<th>State</th>
												<th>Zipcode</th>
												<th>First notice date</th>
												<th>Warning Period</th>
												<th>DMV Status</th>
												<th>Type</th>
												<th width="80" class="text-right">Action</th>
											</tr>
											</tfoot>
										</table>

									</div>
								</div>
							</div>
						</div>
					</div>

                </div> <!-- Body -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="confirm-archive" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Archive</h4>
                </div>
                <div class="modal-body">
                    <p>As you sure you want to archive selected violation?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a class="btn btn-primary btn-ok">Archive</a>
                </div>
            </div>
        </div>
    </div>

	<div id="confirm-delete" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete</h4>
				</div>
				<div class="modal-body">
					<p>As you sure you want to delete.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<a class="btn btn-danger btn-ok">Delete</a>
				</div>
			</div>
		</div>
	</div>

    <script src="<?= base_url() ?>public/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?= base_url() ?>public/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>

    <script>
        $('#confirm-archive').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

		$('#confirm-delete').on('show.bs.modal', function(e) {
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

        $(document).ready(function() {
            var table = $('#other_v_datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?= base_url('admin/violations/datatable_json_other_violations/') . $violation['id'] . '/' . $violation['plate'] ?>",
                "order": [
                    [0, 'desc']
                ],
                "lengthMenu": [10, 25, 50, 100, 250, 500, 1000, 5000],
                "pageLength": 50,
                "aoColumnDefs": [{
                        "aTargets": [0],
                        "sName": "t.id",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [1],
                        "sName": "t.plate_photo",
                        'bSearchable': false,
                        'bSortable': false
                    },
                    {
                        "aTargets": [2],
                        "sName": "t.violation_video",
                        'bSearchable': false,
                        'bSortable': false
                    },
                    {
                        "aTargets": [3],
                        "sName": "t.violation_number",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [4],
                        "sName": "t.plate",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [5],
                        "sName": "t.violation_date_new",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [6],
                        "sName": "t.notice_date_new",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [7],
                        "sName": "t.status",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [8],
                        "sName": "camera_location",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [9],
                        "sName": "address",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [10],
                        "sName": "city",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [11],
                        "sName": "state",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [12],
                        "sName": "zip_code",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [13],
                        "sName": "b.first_notice_date",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [14],
                        "sName": "a.within_warning_period",
                        'bSearchable': true,
                        'bSortable': true
                    },
                    {
                        "aTargets": [15],
                        "sName": "dmv_status",
                        'bSearchable': true,
                        'bSortable': true
                    },
					{
						"aTargets": [16],
						"sName": "t.violation_type",
						'bSearchable': true,
						'bSortable': true
					},
                    {
                        "aTargets": [17],
                        "sName": "Action",
                        'bSearchable': false,
                        'bSortable': false
                    }
                ]
            });

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

            $('#cards #status').on('change', function() {
                if ($(this).val() == 5) {
                    $("#valreson").css("display", "block");
                } else {
                    $("#valreson").css("display", "none");
                }
            });

            $('#cards #savee').on('click', function() {
                var len = parseInt($('#dismissres').val().replace(/\s+/g, '').length);
                var statsue = $('#status option:selected').val();
                if (statsue == 5) {
                    if (len > 60) {
                        $("#resvalidation").css("display", "block");
                        return;
                    } else {
                        $("#resvalidation").css("display", "none");
                        var deditt = $('#editt').attr('action');
                        var urll = deditt + '?save=1';
                        $('#editt').attr('action', urll).submit();
                    }
                    // document.getElementById("editt").submit();
                } else {
                    $("#resvalidation").css("display", "none");
                    var deditt = $('#editt').attr('action');
                    var urll = deditt + '?save=1';
                    $('#editt').attr('action', urll).submit();
                }
            });

            $('#cards #sub').on('click', function() {
                var len = parseInt($('#dismissres').val().replace(/\s+/g, '').length);
                var statsue = $('#status option:selected').val();
                if (statsue == 5) {
                    if (len > 60) {
                        $("#resvalidation").css("display", "block");
                        return;
                    } else {
                        $("#resvalidation").css("display", "none");
                        document.getElementById("editt").submit();
                    }
                } else {
                    $("#resvalidation").css("display", "none");
                    document.getElementById("editt").submit();
                }
            });

            $('#cards #dismissres').on('focusout', function() {
                var len = parseInt($('#dismissres').val().replace(/\s+/g, '').length);
                if (len > 60) {
                    $("#resvalidation").css("display", "block");
                    return;
                }
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

            $('#add_plate').on('click', function(e) {
                e.preventDefault();
                var plate = $('#plate').val();
                var elm = $(this);
                elm.prop('disabled', true);
                $('.err').remove();
                $.ajax({
                    url: '<?= base_url('admin/plates/add_ajax'); ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        plate: plate
                    },
                    success: function(result) {
                        elm.prop('disabled', false);
                        console.log(result);
                        if (result.success) {
                            if (result.exist) elm.after('<span class="err">The plate number already exists</span>');
                            else if (result.resp) elm.after('<span class="succ">Plate successfully added</span>');
                            elm.remove();
                        }
                    },
                    error: function(err) {
                        elm.prop('disabled', false);
                        console.log('err');
                        console.log(err);
                    }
                });
            });

            $('.btn-dmv-api').on('click', function(e) {
                e.preventDefault();

                if ($('.btn-dmv-api').text() == 'Checking...') {
                    return;
                }
                $('.btn-dmv-api').html('Checking...');

                // var url = $('#dmv-url').val();
                var url = "<?php echo base_url('admin/plates/dmv_api/'); ?>";
                var id = "<?php echo $violation['id']; ?>";
                url = url + $('#plate').val() + '/' + id;

                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    success: function(result) {
                        $('.btn-dmv-api').html('DMV API lookup');
                        console.log(result);
                    },
                    error: function(err) {
                        $('.btn-dmv-api').html('DMV API lookup');
                        console.log(err);
                    },
                    complete: function(result) {
                        // window.location.reload();
                        window.location.href = "<?php echo base_url('admin/violations/edit/'); ?>" + id;
                    }
                });
            });

            var currentMousePos = {
                x: -1,
                y: -1
            };

            $(document).mousemove(function(event) {
                if ($(".similar-tooltip")) {
                    var el = $(".similar-tooltip");
                    el.css({
                        'position': 'absolute',
                        'z-index': '1000'
                    });
                    el.css("left", event.pageX + 50);
                    el.css("top", event.pageY - 200);
                }
            });

            $(".tooltip-plate").on("mouseenter", function() {
                    var id = $(this).attr('data-id');
                    var url = "<?php echo base_url('admin/violations/tooltip/') ?>";
                    url = url + id;
                    $.ajax({
                        url: url,
                        type: 'get',
                        async: false,
                        success: function(response) {
                            $(".similar-tooltip").empty();
                            $(".similar-tooltip").append(response);
                            $(".similar-tooltip").show();
                        }
                    });
                })
                .on("mouseleave", function() {
                    if ($(".similar-tooltip"))
                        $(".similar-tooltip").hide();
                });
        });
		$(document).ready(function() {
			var table = $('#duplicates_datatable').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "<?= base_url('admin/violations/datatable_json_duplicates_by_violation/') . $violation['id'] ?>",
				"order": [
					[0, 'desc']
				],
				"lengthMenu": [10, 25, 50, 100, 250, 500, 1000, 5000],
				"pageLength": 50,
				"aoColumnDefs": [{
					"aTargets": [0],
					"sName": "t.id",
					'bSearchable': true,
					'bSortable': true
				},
					{
						"aTargets": [1],
						"sName": "t.plate_photo",
						'bSearchable': false,
						'bSortable': false
					},
					{
						"aTargets": [2],
						"sName": "t.violation_video",
						'bSearchable': false,
						'bSortable': false
					},
					{
						"aTargets": [3],
						"sName": "t.violation_number",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [4],
						"sName": "t.plate",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [5],
						"sName": "t.violation_date_new",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [6],
						"sName": "t.notice_date_new",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [7],
						"sName": "t.status",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [8],
						"sName": "camera_location",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [9],
						"sName": "address",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [10],
						"sName": "city",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [11],
						"sName": "state",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [12],
						"sName": "zip_code",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [13],
						"sName": "b.first_notice_date",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [14],
						"sName": "a.within_warning_period",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [15],
						"sName": "dmv_status",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [16],
						"sName": "t.violation_type",
						'bSearchable': true,
						'bSortable': true
					},
					{
						"aTargets": [17],
						"sName": "Action",
						'bSearchable': false,
						'bSortable': false
					}
				]
			});

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

			$('#cards #status').on('change', function() {
				if ($(this).val() == 5) {
					$("#valreson").css("display", "block");
				} else {
					$("#valreson").css("display", "none");
				}
			});

			$('#cards #savee').on('click', function() {
				var len = parseInt($('#dismissres').val().replace(/\s+/g, '').length);
				var statsue = $('#status option:selected').val();
				if (statsue == 5) {
					if (len > 60) {
						$("#resvalidation").css("display", "block");
						return;
					} else {
						$("#resvalidation").css("display", "none");
						var deditt = $('#editt').attr('action');
						var urll = deditt + '?save=1';
						$('#editt').attr('action', urll).submit();
					}
					// document.getElementById("editt").submit();
				} else {
					$("#resvalidation").css("display", "none");
					var deditt = $('#editt').attr('action');
					var urll = deditt + '?save=1';
					$('#editt').attr('action', urll).submit();
				}
			});

			$('#cards #sub').on('click', function() {
				var len = parseInt($('#dismissres').val().replace(/\s+/g, '').length);
				var statsue = $('#status option:selected').val();
				if (statsue == 5) {
					if (len > 60) {
						$("#resvalidation").css("display", "block");
						return;
					} else {
						$("#resvalidation").css("display", "none");
						document.getElementById("editt").submit();
					}
				} else {
					$("#resvalidation").css("display", "none");
					document.getElementById("editt").submit();
				}
			});

			$('#cards #dismissres').on('focusout', function() {
				var len = parseInt($('#dismissres').val().replace(/\s+/g, '').length);
				if (len > 60) {
					$("#resvalidation").css("display", "block");
					return;
				}
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

			$('#add_plate').on('click', function(e) {
				e.preventDefault();
				var plate = $('#plate').val();
				var elm = $(this);
				elm.prop('disabled', true);
				$('.err').remove();
				$.ajax({
					url: '<?= base_url('admin/plates/add_ajax'); ?>',
					type: 'post',
					dataType: 'json',
					data: {
						plate: plate
					},
					success: function(result) {
						elm.prop('disabled', false);
						console.log(result);
						if (result.success) {
							if (result.exist) elm.after('<span class="err">The plate number already exists</span>');
							else if (result.resp) elm.after('<span class="succ">Plate successfully added</span>');
							elm.remove();
						}
					},
					error: function(err) {
						elm.prop('disabled', false);
						console.log('err');
						console.log(err);
					}
				});
			});

			$('.btn-dmv-api').on('click', function(e) {
				e.preventDefault();

				if ($('.btn-dmv-api').text() == 'Checking...') {
					return;
				}
				$('.btn-dmv-api').html('Checking...');

				// var url = $('#dmv-url').val();
				var url = "<?php echo base_url('admin/plates/dmv_api/'); ?>";
				var id = "<?php echo $violation['id']; ?>";
				url = url + $('#plate').val() + '/' + id;

				$.ajax({
					url: url,
					type: 'get',
					dataType: 'json',
					success: function(result) {
						$('.btn-dmv-api').html('DMV API lookup');
						console.log(result);
					},
					error: function(err) {
						$('.btn-dmv-api').html('DMV API lookup');
						console.log(err);
					},
					complete: function(result) {
						// window.location.reload();
						window.location.href = "<?php echo base_url('admin/violations/edit/'); ?>" + id;
					}
				});
			});

			var currentMousePos = {
				x: -1,
				y: -1
			};

			$(document).mousemove(function(event) {
				if ($(".similar-tooltip")) {
					var el = $(".similar-tooltip");
					el.css({
						'position': 'absolute',
						'z-index': '1000'
					});
					el.css("left", event.pageX + 50);
					el.css("top", event.pageY - 200);
				}
			});

			$(".tooltip-plate").on("mouseenter", function() {
				var id = $(this).attr('data-id');
				var url = "<?php echo base_url('admin/violations/tooltip/') ?>";
				url = url + id;
				$.ajax({
					url: url,
					type: 'get',
					async: false,
					success: function(response) {
						$(".similar-tooltip").empty();
						$(".similar-tooltip").append(response);
						$(".similar-tooltip").show();
					}
				});
			})
				.on("mouseleave", function() {
					if ($(".similar-tooltip"))
						$(".similar-tooltip").hide();
				});
		});
    </script>

    <script src="/slim-image-cropper/example/js/slim.kickstart.min.js"></script>
