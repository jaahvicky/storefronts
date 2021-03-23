@php
    $back_notifications = NotificationHelper::userNotifications();
@endphp
<header class="main-header">
				<!-- Logo -->
				<a href="#" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>A</b>LT</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>Ownai</b> Storefronts</span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- Notifications: style can be found in dropdown.less -->
							<li class="dropdown notifications-menu">
								<a href="#" class="dropdown-toggle read-notification" data-toggle="dropdown">
									<i class="fa fa-bell-o"></i>
									<span class="label label-warning read-number">
										@if( isset($back_notifications) )
											{{ $back_notifications['total'] }}
										@endif
									</span>
								</a>
								<ul class="dropdown-menu">
									@if( isset($back_notifications) )
						              <li class="header">Since {{ date('F d, Y, h:i', strtotime($back_notifications['last_activity'])) }}</li>
						              
						            @endif
						             	@if( isset($back_notifications) && $back_notifications['storeOwner'] )
						            	<li>
						                <!-- inner menu: contains the actual data -->
						                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
						               
						                  <li>
						                    <a href="{!! URL::route('orders.index') !!}">
						                      <i class="fa fa-credit-card text-aqua"></i>
						                      
							                      @if ($back_notifications['new_orders'] != 1)
							                      	{{ $back_notifications['new_orders'] }} orders have been placed
							                      @else
													{{ $back_notifications['new_orders'] }} order has been placed
												  @endif
											  
						                    </a>
						                  </li>

						                  <li>
						                    <a href="{!! URL::route('admin.products') !!}">
						                      <i class="fa fa-shopping-cart text-green"></i>
						                     
							                      @if ($back_notifications['approved_products'] != 1)
							                      	{{ $back_notifications['approved_products'] }} products have been approved
							                      @else
													{{ $back_notifications['approved_products'] }} product has been approved
												  @endif
											  
						                    </a>
						                  </li>
						                 
						                  <li>
						                    <a href="{!! URL::route('admin.products') !!}">
						                      <i class="fa fa-shopping-cart text-red"></i>
						                      
							                      @if ($back_notifications['rejected_products'] != 1)
							                      	{{ $back_notifications['rejected_products'] }} products have been rejected
							                      @else
													{{ $back_notifications['rejected_products'] }} product has been rejected
												  @endif
											 
						                    </a>
						                  </li>
						                  
						                  
						                </ul><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 195.122px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
						              </li>
						               @endif
						              <li class="footer"><a href="#">View all</a></li>
						        </ul>
							</li>
							
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">

								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                        <?php $loggedIn = (Auth::user() != null) ? Auth::user()->username : "" ?>

									Signed in as: 
                                                                        <span><b>{!! $loggedIn !!}</b></span>
								</a>
							</li>
                                                        <li>
                                                                <a href='{{URL::route('admin.logout')}}'>
                                                                        Logout
                                                                </a>
                                                        </li>
						</ul>
					</div>
				</nav>
                                
			</header>