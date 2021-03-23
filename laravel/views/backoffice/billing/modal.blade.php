<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Bill Payment</h4>
		</div>
		<div class="modal-body">
			<p>The following amount ${{$store->type->amount}}.00 will be deducted in your {{(($store->ecocash->account_type == 0)? 'Merchant' : 'Subscriber')}} account  </p>
			<p class="msg_one">Select <b>Yes</b> to confirm and <b>No</b> to cancle the transaction</p>
			<p class="msg" style="display: none">Please approve payment on your mobile before the count down</p>
			<p class="count_down" style="display: none"></p>
		</div>
		<div class="modal-footer">
			<button type="button" id='dismiss' class="btn btn-default pull-left" data-dismiss="modal" data-url="{{ URL::route('admin.billing') }}">No</button>
			<button type="button" class="btn btn-primary " id="submit" data-url="{{ URL::route('admin.billing.account.pay.ajax', ['storeid' => $store->id]) }}" data-url-too="{{ URL::route('admin.billing.account.checkupdate.ajax') }}" data-url-delete="{{ URL::route('admin.billing.account.delete.ajax') }}">Yes</a></button>
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
						
						getupdateonsec(data.transaction_id);
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
        function successcall(id){
        	disableButtons(false);
			$('.msg_one').html('Transaction was successfully').css('color', '#00a65a').show();
			setTimeout(function(){
				window.location.href = $('#dismiss').attr('data-url');
			}, 1000);
        }
        function unsuccesscall(id){
        	deleteTranscation(id);
        	disableButtons(false);
			$('.msg_one').html('Transaction was unsuccessfully, Please try again later on').css('color', '#d73925').show();
        }
        function deleteTranscation(id){
        	var url = $("#submit").attr('data-url-delete');
    		
    		$.ajax({
				url: url,
				type: 'GET',
				data:{transaction_id:id},
				success: function (data) {
					console.log('in delete',data);
				}
			});
			
        }

    	function getupdateonsec(id){

    		var url = $("#submit").attr('data-url-too');
    		var count = 0;
			var interval = setInterval(function(){
				if (count == 10){
					unsuccesscall(id);
					clearInterval(interval);
				}else{
					$.ajax({
						url: url,
						type: 'GET',
						data:{transaction_id:id},
						success: function (data) {
							console.log(data);
							if(data.success == true){
								successcall();
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

		function loop(){
			var count = 0;
			var interval = setInterval(function(){ 
		        if (count == 20){
		        	clearInterval(interval);
		        } 
		       console.log(count); 
		        count++;
		    }, 
		    5000);
			
		}

		
		
    });

</script>