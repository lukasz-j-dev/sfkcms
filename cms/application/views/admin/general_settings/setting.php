<div class="container-fluid">
  <!-- Example Tab -->
  <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
              <div class="header">
                  <h2>
                    GENERAL SETTINGS
                  </h2>
              </div>
              <div class="body">
                  <!-- Nav tabs -->
                  <?php echo form_open_multipart(base_url('admin/general_settings/add')); ?> 
                  <ul class="nav nav-tabs tab-nav-right" role="tablist">
                      <li role="presentation" class="active"><a href="#general-setting" data-toggle="tab">GENERAL SETTING</a></li>
                      <li role="presentation"><a href="#email-setting" data-toggle="tab">EMAIL SETTING</a></li>
                      <li role="presentation"><a href="#social-setting" data-toggle="tab">SOCIAL MEDIA</a></li>
                      <li role="presentation"><a href="#google-setting" data-toggle="tab">GOOGLE reCAPTCHA</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="general-setting">
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Favicon (25*25)</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <?php if(!empty($general_settings['favicon'])): ?>
                                      <img src="<?= base_url($general_settings['favicon']); ?>" class="favicon">
                                    <?php endif; ?>
                                    <input type="file" name="favicon" accept=".png, .jpg, .jpeg, .gif, .svg">
                                    <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                                    <input type="hidden" name="old_favicon" value="<?php echo html_escape($general_settings['favicon']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Logo</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <?php if(!empty($general_settings['logo'])): ?>
                                      <img src="<?= base_url($general_settings['logo']); ?>" class="logo" width="150">
                                    <?php endif; ?>
                                    <input type="file" name="logo" accept=".png, .jpg, .jpeg, .gif, .svg">
                                    <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                                    <input type="hidden" name="old_logo" value="<?php echo html_escape($general_settings['logo']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Application Name</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="application_name" placeholder="application name" value="<?php echo html_escape($general_settings['application_name']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Timezone</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="timezone" placeholder="timezone"
                                   value="<?php echo html_escape($general_settings['timezone']); ?>">
                                  </div>
                                  <a href="http://php.net/manual/en/timezones.php" target="_blank">Timeszones</a>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Currency</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="currency" placeholder="currency"
                                   value="<?php echo html_escape($general_settings['currency']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Copyright</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="copyright"
                                   placeholder="Copyright"
                                   value="<?php echo html_escape($general_settings['copyright']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="email-setting">
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Email From/ Reply to</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="email_from" placeholder= "no-reply@domain.com" value="<?php echo html_escape($general_settings['email_from']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">SMTP Host</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="smtp_host" placeholder="SMTP Host" value="<?php echo html_escape($general_settings['smtp_host']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">SMTP Port</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="smtp_port" placeholder="SMTP Port" value="<?php echo html_escape($general_settings['smtp_port']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">SMTP User</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="smtp_user" placeholder="SMTP Port" value="<?php echo html_escape($general_settings['smtp_user']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">SMTP Password</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="smtp_pass" placeholder="SMTP Port" value="<?php echo html_escape($general_settings['smtp_pass']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="social-setting">
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Facebook</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="facebook_link" placeholder="" value="<?php echo html_escape($general_settings['facebook_link']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Twitter</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="twitter_link" placeholder="" value="<?php echo html_escape($general_settings['twitter_link']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Google Plus</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="google_link" placeholder="" value="<?php echo html_escape($general_settings['google_link']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->

                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Youtube</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="youtube_link" placeholder="" value="<?php echo html_escape($general_settings['youtube_link']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">LinkedIn</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="linkedin_link" placeholder="" value="<?php echo html_escape($general_settings['linkedin_link']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Instagram</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="instagram_link" placeholder="" value="<?php echo html_escape($general_settings['instagram_link']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="google-setting">
                         <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label>reCAPTCHA</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                <?php
                                  $checked = ($general_settings['recaptcha_status'] == 1) ? 'checked':'';
                                ?>
                                <div class="switch">
                                  Disable
                                  <label><input type="checkbox" <?= $checked ?> id="recaptcha_status" name="recaptcha_status" value="1"><span class="lever switch-col-blue"></span></label>
                                  Enable
                                </div>                                 
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Site Key</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="recaptcha_site_key" placeholder="Site Key" value="<?php echo ($general_settings['recaptcha_site_key']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Secret Key</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="recaptcha_secret_key" placeholder="Secret Key" value="<?php echo ($general_settings['recaptcha_secret_key']); ?>">
                                  </div>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                        <div class="row clearfix">
                          <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                              <label for="country">Language</label>
                          </div>
                          <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                              <div class="form-group">
                                  <div class="form-line">
                                    <input type="text" class="form-control" name="recaptcha_lang" placeholder="Language code" value="<?php echo ($general_settings['recaptcha_lang']); ?>">
                                  </div>
                                    <a href="https://developers.google.com/recaptcha/docs/language" target="_blank">https://developers.google.com/recaptcha/docs/language</a>
                              </div>
                          </div>
                        </div>
                        <!--  -->
                      </div>
                  </div>
                  <div class="card-footer">
                    <input type="submit" name="submit" value="SAVE CHANGES" class="btn btn-primary">
                  </div>
                  <?php echo form_close(); ?>
              </div>
          </div>
      </div>
  </div>
  <!-- #END# Example Tab -->
</div>