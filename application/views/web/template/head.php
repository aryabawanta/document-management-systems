<meta charset="utf-8">
<title><?= 'Eoffice - '.$title ?></title>
<meta name="csrf-token" content="XYZ123">
<meta name="description" content="Eoffice">
<meta name="author" content="Eoffice">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/plugins/bootstrap/css/bootstrap.min.css') ?>" >
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/plugins/chartist-js/dist/chartist.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/plugins/chartist-js/dist/chartist-init.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/plugins/c3-master/c3.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/css/style.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/css/custom.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/plugins/calendar/dist/custom_fullcalendar.css') ?>">

<!-- Kuta -->
<!-- <link type="text/css" href="<?php// echo base_url('assets/web/css/colors/red.css') ?>" id="theme" rel="stylesheet" > -->

<!-- DPRD -->
<link type="text/css" href="<?= base_url('assets/web/css/colors/green.css') ?>" id="theme" rel="stylesheet" >

<link rel="icon" type="image/png" href="<?php echo base_url('assets/web/images/favicon.png') ?>">

<script type="text/javascript" src="<?= base_url('assets/web/plugins/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/plugins/popper/popper.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/plugins/bootstrap/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/js/jquery.slimscroll.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/js/waves.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/js/sidebarmenu.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/plugins/sticky-kit-master/dist/sticky-kit.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/plugins/sparkline/jquery.sparkline.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/js/custom.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/plugins/d3/d3.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/web/plugins/c3-master/c3.min.js') ?>"></script>

<!-- calendar -->
<script src="<?= base_url('assets/web/plugins/moment/moment.js') ?>"></script>
<script src="<?= base_url('assets/web/plugins/calendar/dist/custom_fullcalendar.js') ?>"></script>
<script src="<?= base_url('assets/web/plugins/calendar/dist/custom_locale-all.js') ?>"></script>

<!-- qtip -->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/css/jquery.qtip.min.css') ?>">
<script src="<?= base_url('assets/web/js/jquery.qtip.min.js') ?>"></script>

<!-- datepicker -->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/web/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>">
<script src="<?= base_url('assets/web/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>

<!-- Select2 -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/web/plugins/select2/dist/css/select2.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/web/plugins/select2/dist/css/select2.min.css') ?>">
<script type="text/javascript" src="<?php echo base_url('assets/web/plugins/select2/dist/js/select2.full.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/web/plugins/select2/dist/js/select2.full.min.js') ?>"></script>
<!-- End Select2 -->

<!-- Sweet-Alert  -->
	<link href="<?= base_url('assets/web/plugins/sweetalert2/dist/sweetalert2.min.css'); ?>" rel="stylesheet" type="text/css">
	<script src="<?= base_url('assets/web/plugins/sweetalert2/dist/sweetalert2.min.js') ?>"></script>
<!-- END Sweet Alert -->

<!-- Table Responsive -->
    <style type="text/css">
        .tablesaw-modeswitch{
            /*display: none !important;*/
        }
    </style>
    <!-- jQuery peity -->
    <script src="<?= base_url('assets/web/plugins/tablesaw-master/dist/tablesaw.jquery.js') ?>"></script>
    <script src="<?= base_url('assets/web/plugins/tablesaw-master/dist/tablesaw-init.js') ?>"></script>
    <!-- Bootstrap responsive table CSS -->
    <link href="<?= base_url('assets/web/plugins/tablesaw-master/dist/tablesaw.css') ?>" rel="stylesheet">
<!-- End Responsive Table -->

<!-- Block UI JS -->
	<script src="<?= base_url() ?>/assets/web/plugins/blockUI/jquery.blockUI.js"></script>
<!-- End Block UI JS -->

<!-- Toaster -->
	<!-- <script type="text/javascript" src="<?= base_url('assets/web/plugins/toast-master/js/jquery.toast.js') ?>"></script> -->
<!-- End Toaster -->


<style type="text/css">
	/* Absolute Center Spinner */
	.loadings {
	  position: fixed;
	  z-index: 10000;
	  height: 2em;
	  width: 2em;
	  overflow: show;
	  margin: auto;
	  top: 0;
	  left: 0;
	  bottom: 0;
	  right: 0;
	}

	/* Transparent Overlay */
	.loadings:before {
	  content: '';
	  display: block;
	  position: fixed;
	  top: 0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	  background-color: rgba(0,0,0,0.3);
	}

	/* :not(:required) hides these rules from IE9 and below */
	.loadings:not(:required) {
	  /* hide "loadings..." text */
	  font: 0/0 a;
	  /*color: transparent;*/
	  text-shadow: none;
	  background-color: transparent;
	  border: 0;
	}

	/*.loadings:not(:required):after {
	  content: '';
	  display: block;
	  font-size: 10px;
	  width: 1em;
	  height: 1em;
	  margin-top: -0.5em;
	  -webkit-animation: spinner 1500ms infinite linear;
	  -moz-animation: spinner 1500ms infinite linear;
	  -ms-animation: spinner 1500ms infinite linear;
	  -o-animation: spinner 1500ms infinite linear;
	  animation: spinner 1500ms infinite linear;
	  border-radius: 0.5em;
	  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
	  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
	}*/
</style>
<style type="text/css">
	.mytooltip{
		z-index: initial;
	}
</style>


