<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar ">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu list-unstyled">

			@if(!Auth::user()->hasRole('productmoderator'))
			<li class="@navActive(['stores'])">
				<a href="{{URL::route('admin.stores')}}">
					<i class="fa fa-list"></i> <span>Manage Stores</span>
				</a>
			</li>
			<li class="treeview @navActive(['moderator', 'variants'])">
				<a href="#">
					<i class="fa fa-list"></i> <span>Moderate</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="@navActive('moderator')"><a href="{{URL::route('admin.moderator')}}"><i class="fa fa-check-square-o"></i> Moderate Products</a></li>
                    {{--<li class="@navActive('variants')"><a href="{{URL::route('admin.variants')}}"><i class="fa fa-check-square-o"></i> Products Attributes</a></li>--}}
                    <li class="@navActive('manageorders')"><a href="{{URL::route('admin.manage.orders')}}"><i class="fa fa-check-square-o"></i> Orders</a></li>
				</ul>
			</li>
			
			<!-- <li class="treeview @navActive(['ecocash'])">
				<a href="#">
					<i class="fa fa-list"></i> <span>Admin Settings</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu"> -->
                   <!--  <li class="@navActive('ecocash')"><a href="{{URL::route('admin.config.ecocash')}}"><i class="fa fa-check-square-o"></i> EcoCash</a></li>
					<li class="@navActive('permissions')"><a href="#"><i class="fa fa-check-square-o"></i> Permissions</a></li>
					<li class="@navActive('sample')"><a href="{{URL::route('admin.store.warranty')}}"><i class="fa fa-check-square-o"></i> sample</a></li> -->
                     
				<!-- </ul>
			</li> -->
			@endif
			
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>