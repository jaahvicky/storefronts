<script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.logger.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.events.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.modals.js') }}"></script>
<section class='header container row-bordered'>
	<!-- desktop -->
	<div class='header-wrapper '>
		<div class='header-logo '></div>
		<div class='header-sitename color-orange'>{{ (($step == 3)? 'Order Confirmation': 'Storefronts')}}</div>
		
		<div class='header-cart-wrapper specify'>
			<!-- <span class="glyphicon glyphicon-minus"></span> -->
			<button type="button" id='step_1' class="btn btn-default btn-circle-sm {{ (($step == 1)? 'active': '')}}">1</button><span class="vr"><hr class="hr_1"></span>
			<button type="button" id='step_2' class="btn btn-default btn-circle-sm {{ (($step == 2)? 'active': '')}}" >2</button><span class="vr"><hr class="hr_2"></span>
			<button type="button" id='step_3' class="btn btn-default btn-circle-sm {{ (($step == 3)? 'active': '')}}" >3</button>
		</div>
	</div>
	
	<!-- end desktop -->
</section>
<style type="text/css">
	.row-bordered:after {
	    content: "";
	    display: block;
	    border-bottom: 1px solid #ccc;
	    margin: 30px 0px 0 0px;
	}
</style>
<script type="text/javascript">
	var step = <?php echo $step; ?>;
	if(step == 2){
		$('#step_1').addClass('active');
		$('.hr_1').prop('id','hr_1');
	}
	if(step == 3){
		$('#step_1').addClass('active');
		$('#step_2').addClass('active');
		$('.hr_1').prop('id','hr_1');
		$('.hr_2').prop('id','hr_2');
	}
	
</script>
