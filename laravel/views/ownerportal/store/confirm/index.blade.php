
@extends('ownerportal/layout/default')

@section('content')

@css('/css/ownerportal.css')


<!-- main container -->
<div class="container">	
    <main class="main" role="main content">

        <!-- confirm completeion -->
        <section id="sp-complete" class="text-center" role="confirm completion">
                <i class="material-icons sp-confirm-check">assignment_turned_in</i>
                <h1 class="mbsm">We're processing your application</h1>	

                <p>A Storefronts representative will contact you shortly to confirm your store’s details.</p>
                <p class="par-md">You should receive a welcome email in a moment, with your account details. Why not start customizing your store and uploading your products?</p>

                <p class="mblg">Please read our terms and conditions below</p>

                <a href="#" class="btn btn-primary mblg">Terms &amp; Conditions <i class="material-icons sp-btn-ic">insert_drive_file</i></a>	
<!-- reg_confirm.html -->
                <p class="text-center">Back to <a class="underline" href="{!! 'https://ownai.co.zw/' !!}">Ownai</a></p>

                <p class="text-center">
                    Need Help?<br />
                    Dial 118<br />
                    <a href="mailto:ownaisupport@econet.co.zw">ownaisupport@econet.co.zw</a>
                </p>

        </section>
        <!-- confirm completeion  end -->
    </main>
    <!-- main end -->
</div>

@stop