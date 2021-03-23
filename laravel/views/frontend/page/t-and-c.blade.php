@extends('frontend/layout/default')

@section('content')


@include('frontend.layout.header')

<!-- breadcrumbs -->
@include('frontend.page.page-crumbs')

<!-- Main content -->

<section class="container">

	<div class='page-content-wrapper'>
		
		<div class='page-title'>{{ $pageTitle }}</div>
		<div class='page-content-text-wrapper'>	

			<h3>Our Terms &amp; Conditions</h3>

			<p>1.1 These terms of use explain how you may access and use this website (the Site), our services, applications and tools.</p>

			<p>1.2 References in these terms to the Site includes the following websites: [<a href="http://www.ownai.co.zw">www.ownai.co.zw</a>], and all associated web pages.</p>

			<p>1.3 You should read these terms and conditions carefully before using the Site.</p>

			<p>1.4 BY CLICKING ON THE ACCEPTANCE BUTTON REQUIRED TO COMPLETE REGISTRATION AS VENDOR OR TO COMPLETE A SALES TRANSACTION (MARKED 'DO YOU ACCEPT THESE TERMS AND CONDITIONS? 'YOU INDICATE ACCEPTANCE OF THESE TERMS AND CONDITIONS. YOUR ACCEPTANCE MEANS THAT YOU AGREE TO AND SHALL COMPLY WITH OUR WEBSITE ACCEPTABLE USE POLICY, OUR PRIVACY POLICY, OUR COOKIE POLICY AND OUR WEBSITE TERMS AND CONDITIONS OF SUPPLY AND/OR LISTING. SUCH ACCEPTANCE IS EITHER ON YOUR OWN BEHALF OR ON BEHALF OF ANY CORPORATE ENTITY WHICH EMPLOYS YOU OR WHICH YOU REPRESENT (‘CORPORATE ENTITY’). IN THESE TERMS AND CONDITIONS, 'YOU' AND ‘YOUR’ INCLUDES BOTH THE READER AND ANY CORPORATE ENTITY</p>

			<p>1.5 If you have any questions about the Site, please contact <a title="ownaisupport@econet.co.zw" href="mailto:ownaisupport@econet.co.zw">ownaisupport@econet.co.zw</a></p>

			<p>1.6 Definitions</p>

			<div class="definitions">

				<p><strong>Content</strong><br />means any text, images, video, audio or other multimedia content, software or other information or material submitted to or on the Site;</p>

				<p><strong>Unwanted Submission</strong><br />has the meaning given to it in clause 5.1;</p>

				<p><strong>Website acceptable use policy</strong><br />means the <a href="{{URL::route('content-page', ['storeslug' => $store->slug, 'pageslug' => 'terms-and-conditions'])}}" target="_blank">policy</a>, which governs your permitted use of the Site;</p>

				<p><strong>Website cookie policy</strong><br />means the <a href="{{URL::route('content-page', ['storeslug' => $store->slug, 'pageslug' => 'cookies'])}}" target="_blank">policy</a>, which governs how we use cookies in the Site;</p>

				<p><strong>Website privacy policy</strong><br />means the <a href="{{URL::route('content-page', ['storeslug' => $store->slug, 'pageslug' => 'privacy'])}}" target="_blank">policy</a>, which governs how we process any personal data collected from you;</p>

				<p><strong>Website terms and conditions of supply</strong><br />means the <a href="{{URL::route('content-page', ['storeslug' => $store->slug, 'pageslug' => 'terms-and-conditions'])}}" target="_blank">terms and conditions</a>, which will apply to you ordering goods using the Site;</p>

				<p><strong>Website terms and conditions of listing</strong><br />means the <a href="{{URL::route('content-page', ['storeslug' => $store->slug, 'pageslug' => 'terms-and-conditions'])}}" target="_blank">terms and conditions</a>, which will apply to you listing and selling goods using the Site;</p>

				<p><strong>We, us or our</strong><br />means Econet Wireless Zimbabwe company registration number 7548/1998 whose registered office is at No. 2 Old Mutare Road, Msasa, Harare, Zimbabwe. References to we, us or our in these Terms and Conditions or in any policy referenced in these Terms and Conditions, also includes our subsidiary companies from time to time;</p>

				<p><strong>You or your</strong><br />means the person (natural person or if accessed on behalf of a juristic person the juristic person) accessing or using the Site or its Content.</p>

			</div>

			<p>1.7 Your use of the Site means that you must also comply with our Website acceptable use policy, our Privacy policy, our Cookie policy and our Website terms and conditions of supply and/or listing.</p>

			<p><strong>2. Using the Site</strong></p>

			<p>2.1 Ownai.co.zw is a marketplace that allows users to offer, sell and buy goods and services. The actual contract for sale is directly between the sellers and buyers.</p>

			<p>2.2 You agree that you are solely responsible for:</p>

			<p>2.2.1 all costs and expenses you may incur in relation to your use of the Site; and</p>

			<p>2.2.2 keeping your password and other account details confidential.</p>

			<p>2.3 The Site is intended for use only by those who can access it from within Zimbabwe. We may accept orders for delivery to locations outside of Zimbabwe although this may depend on certain customs, legal and other practical restrictions. If you choose to access the Site from locations outside Zimbabwe or place orders for delivery to locations outside Zimbabwe, you are responsible for compliance with local laws where they are applicable.</p>

			<p>2.4 We seek to make the Site as accessible as possible. If you have any difficulties using the Site, please contact us at <a title="ownaisupport@econet.co.zw" href="mailto:ownaisupport@econet.co.zw">ownaisupport@econet.co.zw</a>.</p>

			<p>We may prevent or suspend your access to the Site if you do not comply with any part of these Website terms and conditions, any terms or policies to which they refer or any applicable law.</p>

			<p><strong>3. Ownership, use and intellectual property rights</strong></p>

			<p>3.1 This Site and all intellectual property rights in it including but not limited to any Content are owned by us, our licensors or both (as applicable). Intellectual property rights means rights such as: copyright, trade marks, domain names, design rights, database rights, patents and all other intellectual property rights of any kind whether or not they are registered or unregistered (anywhere in the world). We and our licensors reserve all of our and their rights in any intellectual property in connection with these terms and conditions. This means, for example, that we remain owners of them and free to use them as we see fit.</p>

			<p>3.2 Nothing in these terms and conditions grants you any legal rights in the Site other than as necessary to enable you to access the Site. You agree not to adjust to try to circumvent or delete any notices contained on the Site (including any intellectual property notices) and in particular in any digital rights or other security technology embedded or contained within the Site.</p>

			<p>3.3 Trademarks: "Ownai" and "Econet" are our trademarks. Other trademarks and trade names may also be used on this Site. The use of any trademarks on the Site is strictly prohibited unless you have our prior written permission.</p>

			<p><strong>4. Software</strong></p>

			<p>4.1 Software may be made available for you to download in order to help the Site work better. You may only use such software if you agree to be bound by the terms and conditions that apply to such software (this is sometimes known as an end user licence agreement). You will be made aware of any terms and conditions that apply to the software when you try to download it. If you do not accept such terms and conditions, you will not be allowed to download the software. You should read any terms and conditions carefully to protect your own interests (they may contain provisions that set out what your legal responsibilities are when using software, what the software provider's legal responsibilities are, and provisions that limit a software provider's legal responsibilities to you.</p>

			<p>4.2 Using the software in an unlawful way (such as reproducing or redistributing it in a way that breaches these terms and conditions and any others that apply to it) is expressly prohibited and may result in civil and criminal penalties.</p>

			<p><strong>5. Submitting information to the Site</strong></p>

			<p>5.1 While we try to make sure that the Site is secure, we cannot guarantee the security of any information that you supply to us and therefore we cannot guarantee that it will be kept confidential. For that reason, you should not let us have any patentable ideas or patent applications, advertising or marketing suggestions, prototypes, or any other information that you regard as confidential, commercially sensitive or valuable (Unwanted Submissions). While we value your feedback, you agree not to submit any Unwanted Submissions.</p>

			<p>5.2 We may use any Unwanted Submissions as we see reasonably fit on a free-of-charge basis (bear in mind that we have no way of knowing whether such information is confidential, commercially sensitive or valuable because we do not monitor the Site to check for these matters). Therefore, we will not be legally responsible for keeping any Unwanted Submissions confidential nor will we be legally responsible to you or anybody else for any use of such Unwanted Submissions.</p>

			<p><strong>6. Accuracy of information and availability of the Site</strong></p>

			<p>6.1 While we try to make sure that the Site is accurate, up-to-date and free from bugs, we cannot promise that it will be. Furthermore, we cannot promise that the Site will be fit or suitable for any purpose. Any reliance that you may place on the information on this Site is at your own risk.</p>

			<p>6.2 We may suspend or terminate operation of the Site at any time as we see fit.</p>

			<p>6.3 Any Content is provided for your general information purposes only and to inform you about us and our products and news, features, services and other websites that may be of interest. It does not constitute technical, financial or legal advice or any other type of advice and should not be relied on for any purposes.</p>

			<p>6.4 While we try to make sure that the Site is available for your use, we do not promise that the Site is available at all times nor do we promise the uninterrupted use by you of the Site.</p>

			<p><strong>7. Hyperlinks and third party sites</strong></p>

			<p>7.1 The Site may contain hyperlinks or references to third party websites other than the Site. Any such hyperlinks or references are provided for your convenience only. We have no control over third party websites and accept no legal responsibility for any content, material or information contained in them. The display of any hyperlink and reference to any third party website does not mean that we endorse that third party's website, products or services. Your use of a third party site may be governed by the terms and conditions of that third party site.</p>

			<p><strong>8. Limitation on our liability</strong></p>

			<p>8.1 Except for:</p>

			<p>8.1.1 death or personal injury caused by our negligent acts or omissions (or those of any of our employees or agents);</p>

			<p>8.1.2 fraud or fraudulent misrepresentation;</p>

			<p>8.1.3 breach of any of the provisions implied into these terms and conditions under the Zimbabwe Consumer Contracts Act Chapter 8:3;</p>

			<p>we will only be liable for any loss or damage that is a reasonably foreseeable consequence of a breach of these terms and conditions. Losses are foreseeable where they could be contemplated by you and us at the time these terms and conditions are entered into. We are not responsible for indirect losses that happen as a side effect of the main loss or damage and which are not foreseeable by you and us (such as loss of profits or loss of opportunity).</p>

			<p>8.2 You agree that you are making use of our Services at your own risk, and that they are being provided to you on an "AS IS" and "AS AVAILABLE" basis. Accordingly, to the extent permitted by applicable law, we exclude all express or implied warranties, terms and conditions including, but not limited to, implied warranties of merchantability, fitness for a particular purpose, and non-infringement.</p>

			<p>8.3 The contract for sale shall be personal between the Seller (the person offering and/or selling goods using the Site) and the Buyer (the person ordering goods using the Site) and We shall not be responsible for nor have any liability in terms of any dealings between the Seller and the Buyer. For the avoidance of doubt We shall not be responsible for nor be liable with regards to the delivery of or the payment for the goods or with regards to the safety or quality of the goods supplied.</p>

			<p><strong>9. Events beyond our control</strong></p>

			<p>9.1 We shall have no liability to you for any breach of these terms caused by any event or circumstance beyond our reasonable control including, without limitation, strikes, lock-outs or other industrial disputes; breakdown of systems or network access; or flood, fire, explosion or accident.</p>

			<p><strong>10. Rights of third parties</strong></p>

			<p>10.1 No one other than a party to these terms and conditions has any right to enforce any of these terms and conditions.</p>

			<p><strong>11. Variation</strong></p>

			<p>11.1 These terms are dated 3 November 2015. No changes to these terms are valid or have any effect unless agreed by us in writing. We reserve the right to vary these terms and conditions from time to time. Our new terms will be displayed on the Site and by continuing to use and access the Site following such changes, you agree to be bound by any variation made by us. It is your responsibility to check these terms and conditions from time to time to verify such variations.</p>

			<p><strong>12. Disputes</strong></p>

			<p>12.1 We will try to resolve any disputes quickly and efficiently. If you are unhappy with the way we deal with any dispute and you want to take court proceedings, the relevant courts of the Republic of Zimbabwe will have exclusive jurisdiction in relation to the Terms and Conditions. Relevant Zimbabwean law will apply to these Terms and Conditions</p>

			<h3>Acceptable Use Policy</h3>

			<p><strong>1. Introduction</strong></p>

			<p>1.1 Together with our General website Terms and Conditions of use, this acceptable use policy governs how you may access and use the Site.</p>

			<p>1.2 Definitions</p>

			<div class="definitions">

				<p><strong>Site</strong><br />includes the following website(s): www.ownai.co.zw, and all associated web pages.</p>

				<p><strong>Submission or submissions</strong><br />means any text, images, video, audio or other multimedia content, software or other information or material submitted by you or other users to the Site;</p>

				<p><strong>We, us or our</strong><br />means Econet Zimbabwe Limited company registration number 7548/1998 whose registered office is at No. 2 Old Mutare Road, Msasa, Harare, Zimbabwe. References to us in these terms also includes our subsidiary companies from time to time;</p>

				<p><strong>You or your</strong><br />means the person accessing or using the Site or its Content.</p>

			</div>

			<p><strong>2. Restrictions on use</strong></p>

			<p>2.1 As a condition of your use of the Site, you agree:</p>

			<p>2.1.1 not to use the Site for any purpose that is unlawful under any applicable law or prohibited by this policy or our General website terms and conditions of use;</p>

			<p>2.1.2 not to use the Site to commit any act of fraud;</p>

			<p>2.1.3 not to use the Site to distribute viruses or malware or other similar harmful software code</p>

			<p>2.1.4 not to use the Site for purposes of promoting unsolicited advertising or sending spam;</p>

			<p>2.1.5 not to use the Site to simulate communications from us or another service or entity in order to collect identity information, authentication credentials, or other information (‘phishing’);</p>

			<p>2.1.6 not to use the Site in any manner that disrupts the operation of our Site or business or the website or business of any other entity;</p>

			<p>2.1.7 not to use the Site in any manner that harms minors;</p>

			<p>2.1.8 not to promote any unlawful activity;</p>

			<p>2.1.9 not to represent or suggest that we endorse any other business, product or service unless we have separately agreed to do so in writing;</p>

			<p>2.1.10 not to use the Site to gain unauthorised access to or use of computers, data, systems, accounts or networks;</p>

			<p>2.1.11 not to attempt to circumvent password or user authentication methods; and</p>

			<p>2.1.12 to comply with the provisions relating to our Intellectual Property Rights and Software contained in our General website terms and conditions of use.</p>

			<p><strong>3. Interactive services</strong></p>

			<p>3.1 We may make bulletin boards, chat rooms or other communication services (‘Interactive Services’) available on the Site.</p>

			<p>3.2 We are not obliged to monitor or moderate Submissions to Interactive Services. Where we do monitor or moderate Submissions we shall indicate how this is performed and who should be contacted in relation to any Submission of concern to you.</p>

			<p>3.3 We may remove or edit any Submissions to any of our Interactive Services whether they are moderated or not.</p>

			<p>3.4 Any Submission you make must comply with our Submission standards set out below.</p>

			<p><strong>4. Submission standards</strong></p>

			<p>4.1 Any Submission or communication to users of our Site must conform to standards of accuracy, decency and lawfulness, which shall be applied in our absolute discretion. In particular, you warrant that any Submission or communication is</p>

			<p>4.1.1 your own original work and lawfully submitted;</p>

			<p>4.1.2 factually accurate or your own genuinely held belief;</p>

			<p>4.1.3 provided with the necessary consent of any third party;</p>

			<p>4.1.4 not defamatory or likely to give rise to an allegation of defamation;</p>

			<p>4.1.5 not offensive, obscene, sexually explicit, discriminatory or deceptive; and</p>

			<p>4.1.6 unlikely to cause offence, embarrassment or annoyance to others.</p>

			<p><strong>5. Linking and framing</strong></p>

			<p>5.1 You may create a link to our Site from another website without our prior written consent provided no such link:</p>

			<p>5.1.1 creates a frame or any other browser or border environment around the content of our Site;</p>

			<p>5.1.2 implies that we endorse your products or services or any of the products or services of, or available through, the website on which you place a link to our Site;</p>

			<p>5.1.3 displays any of the trade marks or logos used on our Site without our permission or that of the owner of such trade marks or logos; or</p>

			<p>5.1.4 is placed on a website that itself does not meet the acceptable use requirements of this policy.</p>

			<p>5.2 We reserve the right to require you to immediately remove any link to the Site at any time, and you shall immediately comply with any request by us to remove any such link.</p>

			<p><strong>6. Using the Ownai name and logo</strong></p>

			<p>6.1 You may not use our trade marks, logos or trade names except in accordance with this policy and our General website terms and conditions of use.</p>

			<p><strong>7. Breach</strong></p>

			<p>7.1 We shall apply the terms of this policy in our absolute discretion. In the event of your breach of these terms we may terminate or suspend your use of the Site, remove or edit Submissions, disclose Submissions to law enforcement authorities or take any action we consider necessary to remedy the breach.</p>

			<p><strong>8. Disputes</strong></p>

			<p>8.1 We will try to resolve any disputes quickly and efficiently. If you are unhappy with the way we deal with any dispute and you want to take court proceedings, the relevant courts of the Zimbabwe will have exclusive jurisdiction in relation to the Terms. Relevant Zimbabwe law will apply to these Terms.</p>

		</div>

	</div>
	
	<hr>

</section>
<!-- /.content -->


@include('frontend.layout.store-footer')
@include('frontend.layout.footer')

@stop
