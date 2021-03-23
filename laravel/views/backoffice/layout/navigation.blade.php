<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="@navActive(['dashboard'])">
				<a href="{{URL::route('admin.dashboard')}}">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
                        <li class="@navActive(['products'])">
				<a href="{!! URL::route('admin.products') !!}">
					<i class="fa fa-dashboard"></i> <span>Products</span>
				</a>
			</li>
                        <li class="@navActive(['orders'])">
				<a href="{!! URL::route('orders.index') !!}">
                                    <i class="fa fa-dashboard"></i> <span>Orders</span>
                                    <span class='label label-primary pull-right'>{{ LookupHelper::getOrderTotal() }}</span>
				</a>
			</li>
			
			<li class="treeview @navActive(['store.details', 'store.about', 'store.warranty', 'store.appearance', 'store.delivery'])">
				<a href="#">
					<i class="fa fa-dashboard"></i> <span>Store Settings</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
                                        <li class="@navActive('store.details')"><a href="{{URL::route('admin.store.details')}}"><i class="fa fa-circle-o"></i> Details</a></li>
					<li class="@navActive('store.about')"><a href="{{URL::route('admin.store.about')}}"><i class="fa fa-circle-o"></i> About</a></li>
					<li class="@navActive('store.warranty')"><a href="{{URL::route('admin.store.warranty')}}"><i class="fa fa-circle-o"></i> Warranty</a></li>
					<li class="@navActive('store.delivery')"><a href="{{URL::route('admin.store.delivery')}}"><i class="fa fa-circle-o"></i> Delivery</a></li>
                    <li class="@navActive('store.appearance')"><a href="{{URL::route('admin.store.appearance')}}"><i class="fa fa-circle-o"></i> Appearance</a></li>
                    <li class="@navActive('store.migration')"><a href="{{URL::route('admin.store.migration')}}"><i class="fa fa-circle-o"></i> Migration</a></li>
				</ul>
			</li>
           <li class="@navActive(['account'])">
				<a href="{{URL::route('admin.account')}}">
					<i class="fa fa-dashboard"></i> <span>Account</span>
				</a>
			</li>

			<li class="@navActive(['billing'])">
				<a href="{{URL::route('admin.billing')}}">
					<i class="fa fa-dashboard"></i> <span>Billing</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>