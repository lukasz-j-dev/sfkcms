<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?=isset($title)?$title:'SignIn - Codeigniter Material Admin' ?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?= base_url() ?>public/favicon.ico" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <link href="<?= base_url() ?>public/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="<?= base_url() ?>public/plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="<?= base_url() ?>public/plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Materialize Css -->
    <link href="<?= base_url() ?>public/css/materialize.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="<?= base_url() ?>public/css/style.css" rel="stylesheet">
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KFG5D94');</script>
<!-- End Google Tag Manager -->
</head>

<body class="login-page">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KFG5D94"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">CI Material Admin</a>
        </div>
        <?php if(isset($msg) || validation_errors() !== ''): ?>
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <?= validation_errors();?>
                <?= isset($msg)? $msg: ''; ?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('warning')): ?>
             <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
              <?=$this->session->flashdata('warning')?>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('success')): ?>
              <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <?=$this->session->flashdata('success')?>
              </div>
        <?php endif; ?>
        <div class="card">
            <div class="body">
                <?php echo form_open(base_url('auth/login'), 'class="login-form" '); ?>
                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="Email" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-5 text-right">
                            <a  href="<?= base_url('auth/forgot_password'); ?>">Forgot password?</a>
                        </div>
                    </div>
                    
                    <?php if($this->recaptcha->_status): ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <?= $this->recaptcha->getWidget(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <input type="submit" name="submit" id="submit" class="btn btn-block btn-success waves-effect" value="Submit">
                        </div>
                    </div>
                    <div class="m-t-25 align-center">
                        <a href="<?= base_url('auth/register'); ?>">Don't have an account? Sign Up</a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="<?= base_url() ?>public/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap Core Js -->
    <script src="<?= base_url() ?>public/plugins/bootstrap/js/bootstrap.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?= base_url() ?>public/plugins/node-waves/waves.js"></script>
    <!-- Validation Plugin Js -->
    <script src="<?= base_url() ?>public/plugins/jquery-validation/jquery.validate.js"></script>
    <!-- Custom Js -->
    <script src="<?= base_url() ?>public/js/admin.js"></script>
    <script src="<?= base_url() ?>public/js/pages/examples/sign-in.js"></script>
</body>

</html>