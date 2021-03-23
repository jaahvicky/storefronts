<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Order Payment</h4>
		</div>
		<div class="modal-body">
			<p>To complete the order the following amount ${{ ($amount/100) + $delivery_cost }}.00 will be deducted in your EcoCash account  </p>
			<p class="msg_one">Select <b>Yes</b> to confirm and <b>No</b> to cancle the order</p>
			<p class="msg" style="display: none">Please approve payment on your mobile before the count down</p>
			<p class="count_down" style="display: none"></p>
		</div>
		<div class="modal-footer">
			<button type="button" id='dismiss' class="btn btn-default pull-left" data-dismiss="modal">No</button>
			<button type="button" class="btn btn-primary " id="submit" data-url="{{ URL::route('shopping.details.ecocashpay', ['slug' => $store->slug]) }}" data-url-too="{{ URL::route('shopping.details.ecocashupdate',['slug' => $store->slug]) }}">Yes</a></button>
			<i class="fa fa-circle-o-notch fa-spin pull-right" id="spinner" style="display: none; font-size:24px"></i>


		</div>
	</div>
</div>
<script type="text/javascript" src="{{ asset('plugins/jquery/jquery-2.2.3.min.js') }}"></script>
<script type="text/javascript">
$(function() {
        $("#submit").on('click', function() {
           disableButtons(true);
           var url = $(this).attr('data-url');
          
           $.ajax({
				url: url,
				type: 'GET',
				success: function (data) {
					console.log(data);
					if(data.success == false){
						disableButtons(false);
						$('.msg_one').html('Transaction was unsuccessfully, Please try again later on').css('color', '#d73925').show();
					}else{
						getupdateonsec(data.order.invoice_number)
						timer(
						    59000, 
						    function(timeleft) { 
						    	$('.count_down').html(timeleft+" second(s)").show();
						    },
						    function() { 
						       $('.count_down').css('color', '#d73925');
						    }
						);
					}
					
				}
			});
        });
        
  
    	function successcall(data){
        	disableButtons(false);
			$('.msg_one').html('Transaction was successfully').css('color', '#00a65a').show();
			setTimeout(function(){
				window.location.href = data.url;
				}, 1000);
        }
        function unsuccesscall(){
        	disableButtons(false);
			$('.msg_one').html('Transaction was unsuccessfully, Please try again later on').css('color', '#d73925').show();
        }
    	function getupdateonsec(clientCorrelator){

    		var url = $("#submit").attr('data-url-too');
    		var count = 0;
			var interval = setInterval(function(){
				if (count == 10){
					unsuccesscall();
					clearInterval(interval);
				}else{
					$.ajax({
						url: url,
						type: 'GET',
						data:{correlator:clientCorrelator},
						success: function (data) {
							console.log(data);
							if(data.success == true){
								successcall(data);
							   	clearInterval(interval);
							}
											
						}
					});
				}
				count++;
			}, 
			5000);
			
			
    	}
    	function disableButtons(status){
    		if(status){
    			$("#submit").prop('disabled', true);
           		$('#dismiss').prop('disabled', true);
           		$('.close').prop('disabled', true);
           		$("body").prop('disabled', true);
 				$('#spinner').show();
           		$('.msg').show();
           		$('.msg_one').hide();
    		}else{
    			$("#submit").prop('disabled', false);
           		$('#dismiss').prop('disabled', false);
           		$('.close').prop('disabled', false);
           		$("body").prop('disabled', false);
 				$('#spinner').hide();
           		$('.msg').hide();
           		
    		}
    		
    	}

    	function timer(time,update,complete) {
		    var start = new Date().getTime();
		    var interval = setInterval(function() {
		        var now = time-(new Date().getTime()-start);
		        if( now <= 0) {
		            clearInterval(interval);
		            complete();
		        }
		        else update(Math.floor(now/1000));
		    },100);
		}
    });

</script>