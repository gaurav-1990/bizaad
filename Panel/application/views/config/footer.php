
<!-- Scripts -->
<script src="<?= base_url() ?>allmedia/assets/js/jquery-2.2.0.min.js"></script>
<script src="<?= base_url() ?>allmedia/assets/components/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<link href="<?= base_url() ?>allmedia/chosen/chosen.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>allmedia/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/components/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>allmedia/chosen/init.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/components/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/circle-progress.min.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/calendar.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/general.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>allmedia/assets/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/js/myvalidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/js/bootstrap-notify.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/js/vendorProduct.js" type="text/javascript"></script>
<script src="<?= base_url() ?>allmedia/assets/js/extremeObfuscatemyscript.js" type="text/javascript"></script>
</body>
</html>




<link  type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/datepicker.css"/>
<script src="<?= base_url() ?>assets/js/datepicker.js" type="text/javascript"></script>

<script type="text/javascript">   
    $.noConflict();
    jQuery('#tripstartdate,#trip_closing_date').datepicker({
       
    'format': 'dd-mm-yyyy',
    'autoclose': true,
    });
</script>


<script src="<?= base_url() ?>bootstrap/vendor/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>bootstrap/vendor/datatables/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script>
    //$.noConflict();
    jQuery(document).ready(function() {
    jQuery('#example').DataTable();
 } );	
</script>