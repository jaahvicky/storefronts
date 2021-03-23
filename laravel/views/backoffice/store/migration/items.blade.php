<div class="btn-group" data-methys-filter='dropdown-toggle' '>
 <input type="hidden" id="orderbyname" name="orderbyname[]">
 <input type="hidden" name="migrated" id="migrated" value="{{ (($migrated->migrated == 1) ? 1: 0 )}}">
 <input type="hidden" name="migrated_number" id="migrated_number" value="{{ $migrated->phone }}">
</div>
<div class='box box-primary your-items item-box' style="display: none">
    <div class="box-header">
        <h3 class="box-title">Your Items</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body" ng-app='SyncData' ng-controller='SyncController as atr'>
        <div class='row'>
            <div class='col-sm-6'>
                <div class="form-inline">   
                    <div class="btn-group">
                        <button class="btn btn-default btn-label">Bulk Actions </button>
                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle action-toggle">Actions <span class="caret actions"></span></button>
                        <ul class="dropdown-menu">
                            <li>
                                <input type="radio" id="delete" name="actioner" value="delete" class="action-option">
                                <label for="delete">Delete</label>
                            </li>
                                            
                            <li>
                                <input type="radio" id="sync" name="actioner" value="sync" class="action-option">
                                <label for="sync">Sync</label>
                            </li><!-- /.second level-->
                                                    
                        </ul>
                    </div>
                    &nbsp;
                    <input class="btn btn-primary btn-flat action-bulk" type="button" value="Action Bulk Actions" ng-click='atr.bulkSync()'>
                </div>     
            </div> 
        </div>
        <div class="alert alert-success alert-dismissible non-selector">
            No items selected 
        </div>
        <br>
        <div class="dataTables_wrapper form-inline dt-bootstrap" id="example2_wrapper" >
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>  
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table role="grid" class="table table-bordered table-hover">
                        <thead>
                            <tr role="row">
                                <th class='' style="width:10px;"><i class="" ></i></th>
                                <th class='' ><i class="" ></i>Item Title</th>
                                <th class='' ><i class="" ></i>Item Description</th>
                                <th class='' ><i class="" ></i>Platform</th>
                                <th class='' ><i class="" ></i>Status</th>
                                <th >Action</th>
                            </tr> 
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in atr.rowData">
                                <td class="">
                                    <input type="checkbox" name="selector" class="selector" ng-click="atr.checked($event,item)">
                                </td>
                                <td>[[ item.title  ]]</td>
                                <td>[[ item.description  ]]</td>
                                <td>[[ item.platform ]]</td>
                                <td >[[ item.status ]]</td>
                                <td class='table-actions'>
                                    <button class="btn btn-sm btn-default" ng-click="atr.deleteItem(item.id)"> Delete </button>
                                    <button class="btn btn-sm btn-default" ng-click="atr.SyncItem(item)"> Sync </button>
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                    <p ng-show="isEmpty(atr.rowData)" style="text-align: center">You do not have any items </p>
                </div>
            </div>
            <div class='row'>
            <div class='col-sm-6'>
                <div class="form-inline">   
                    <div class="btn-group">
                        <button class="btn btn-default btn-label">Bulk Actions </button>
                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle action-toggle">Actions <span class="caret actions"></span></button>
                        <ul class="dropdown-menu">
                            <li>
                                <input type="radio" id="delete" name="actioner" value="delete" class="action-option">
                                <label for="delete">Delete</label>
                            </li>
                                            
                            <li>
                                <input type="radio" id="sync" name="actioner" value="sync" class="action-option">
                                <label for="sync">Sync</label>
                            </li><!-- /.second level-->
                                                    
                        </ul>
                    </div>
                    &nbsp;
                    <input class="btn btn-primary btn-flat action-bulk" type="button" value="Action Bulk Actions" ng-click='atr.bulkSync()'>
                </div>     
            </div> 
        </div>
        </div>
    </div>
    <!-- /.box-body -->
</div> 