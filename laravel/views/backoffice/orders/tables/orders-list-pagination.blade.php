<?php 

/*
 * Copyright (c) 2017 Methys Digital
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of Methys Digital.
 * ("Confidential Information"). You shall not disclose such
 * Confidential Information and shall use it only in accordance with
 * the terms of the license agreement you entered into with Methys Digital.
 */

?>

<div class="col-sm-8">
        Displaying <strong>{{ $orders->firstItem() }} - {{ $orders->lastItem() }}</strong> out of <strong>{{ $orders->total() }}</strong> orders
</div>
<div class="col-sm-4">
        <div class='pull-right'>
        	{{ $orders->setPath('orders')->appends(Input::except('page', '_token', 'filters', 'orderStatus'))->render() }}
        </div>
</div>