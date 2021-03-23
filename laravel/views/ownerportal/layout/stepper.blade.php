<?php

$step1_class = $step2_class = $step3_class = '';

if (!is_null($step)) {
    
    if ($step === 1) {
        $step1_class = 'active';
    }
    else if ($step === 2) {
        $step1_class = 'done';
        $step2_class = 'active';
    }
    else {
        $step1_class = 'done';
        $step2_class = 'done';
        $step3_class = 'active';
    }
}

?>

<!-- stepper-->
<form id="sp-setup">
    <section id="sp-stepper" class="clearfix" role="progress indicator">
            <h4 class="text-center">Your Progress</h4>	
            <div class="sp-steps text-center clearfix">
                    <div class="sp-step 1 {!! $step1_class !!}">
                            <a href="{!! URL::route('store.setup.details') !!}" >{!! ($step1_class == 'done') ? "<i class='material-icons'>check</i>" : 1 !!}</a>
                            <span class="sp-step-title">Store Details</span>
                    </div>
                    <div class="sp-track"></div>
                    <div class="sp-step 2 {!! $step2_class !!}">
                            <a href="{!! URL::route('store.setup.contact-details') !!}">{!! ($step2_class == 'done') ? "<i class='material-icons'>check</i>" : 2 !!}</a>
                            <span class="sp-step-title">Contact Details</span>	
                    </div>									
                    <div class="sp-track"></div>
                    <div class="sp-step 3 {!! $step3_class !!}">
                            <a href="{!! URL::route('store.setup.payment-details') !!}">{!! ($step3_class == 'done') ? "<i class='material-icons'>check</i>" : 3 !!}</a>
                            <span class="sp-step-title">EcoCash Details</span>
                    </div>											
            </div>		
    </section>
</form>
<!-- stepper end -->