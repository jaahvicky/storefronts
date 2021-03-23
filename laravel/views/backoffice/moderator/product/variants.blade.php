 
<div class='box box-primary variant' >
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">2</span>
            <div class='stepper-header'>
                <h3 class='box-title'>Variations</h3>
                <p>List multiple variations of your item</p>
            </div>
        </div>
    </div>
   <input type="hidden" name="variantvalues" id="variantvalues" value='<?php echo (!empty($variantvalues)) ? $variantvalues->data : json_encode([]) ?>'/> 

    <script type="text/javascript">
        var variantvalues = <?php echo (!empty($variantvalues)) ? $variantvalues->data : json_encode([]) ?> ;
        var variantdetails = <?php echo json_encode($variants); ?>;
    </script>
    <div class='box-body' ng-app='variant' ng-controller='attribute as atr'>
            @if(!empty($variantvalues))
                <?php    
                    $data_values = json_decode($variantvalues->data);
                    $i =0;
                    
                ?>
                <table class="table table-condensed">
                <thead>
                    <tr>
                     <th></th>
                     <th ng-repeat='attributename in atr.attributeNames'> [[ attributename.name ]]</th>
                     <th></th>
                     </tr>
                </thead> 
                <tbody>
                    <tr ng-repeat='attributeValue in atr.rowData'>
                        <th></th>
                        <td>[[ attributeValue.value ]]</td>
                        <td>[[ attributeValue.option_value ]]</td>
                        <th>
                            <span ng-if="attributeValue.available == 0">
                                <span class="var_remove text-danger" data-methys-id="[[ attributeValue.id ]]" ng-click="atr.remove(attributeValue.id)">Remove</span> | 
                                <span class="var_out_stock btn disabled" data-methys-id="[[ attributeValue.id ]]" ng-click="atr.outofstock(attributeValue.id)">Out of Stock</span>  | 
                                <span class="var_hide text-primary" data-methys-id="[[ attributeValue.id ]]" ng-click="atr.hide(attributeValue.id)">hidden</span> | 
                                <span class="var_in_stock text-primary " data-methys-id="[[ attributeValue.id ]]" ng-click="atr.available(attributeValue.id)">Available</span>
                            </span>
                            <span ng-if="attributeValue.available == 1">
                                <span class="var_remove text-danger" data-methys-id="[[ attributeValue.id ]]" ng-click="atr.remove(attributeValue.id)">Remove</span> | 
                                <span class="var_out_stock text-primary " data-methys-id="[[ attributeValue.id ]]" ng-click="atr.outofstock(attributeValue.id)">Out of Stock</span>  | 
                                <span class="var_hide text-primary" data-methys-id="[[ attributeValue.id ]]" ng-click="atr.hide(attributeValue.id)">hidden</span> | 
                                <span class="var_in_stock btn disabled" data-methys-id="[[ attributeValue.id ]]" ng-click="atr.available(attributeValue.id)">Available</span>
                            </span>
                            
                        </th>
                    </tr> 
                </tbody> 
                </table>
                
              <span class="text-primary" id="extra_attribute" >Add Variations</span>
               <div class="form-group extra_attribute">

                <?php $variant_id = []; $ids_with_values =[];
                ?> 
                @if(!empty($data_values))
                    @foreach($data_values->elements as $element)
                      
                        <?php $ids_with_values[] = $element->id;?> 
                        @foreach($variants as $variantname)
                            @if($element->id == $variantname->id)
                                <label for="variant_name" class="  ">{{ $variantname->name }}</label>
                                <input type="text" name="variant_{{ $variantname->id }}" id="variant_{{ $variantname->id }}" data-variant-id="{{ $variantname->id }}" data-role="tagsinput" class="form-control variant_atrribuite"  value="{{ $element->values }}" />
                            @endif
                        @endforeach
                    @endforeach
                @endif
                @foreach($variants as $variantname)
                <?php $variant_id[] = $variantname->id;?> 
                    @if(!in_array($variantname->id, $ids_with_values))
                        <label for="variant_name" class="  ">{{ $variantname->name }}</label>
                        <input type="text" name="variant_{{ $variantname->id }}" id="variant_{{ $variantname->id }}" data-variant-id="{{ $variantname->id }}" data-role="tagsinput" class="form-control variant_atrribuite"  />
                    @endif
                    
                @endforeach
               <input type="hidden" name="variant_ids" id="variant_ids" value="<?php echo json_encode($variant_id); ?>">
            </div>
           
        @else
        <a class="text-primary" data-modal="true" href="{{ URL::route('admin.product.modal-variant.add', ['storeid' => $store->id]) }}">Add product attribute</a>
        <div class="form-group ">

            <?php $variant_id = [];?> 
            @foreach($variants as $variantname)
               <label for="variant_name" class="  ">{{ $variantname->name }}</label>
               <?php $variant_id[] = $variantname->id;?> 
               <input type="text" name="variant_{{ $variantname->id }}" id="variant_{{ $variantname->id }}" data-variant-id="{{ $variantname->id }}" data-role="tagsinput" class="form-control variant_atrribuite" />
           @endforeach
           <input type="hidden" name="variant_ids" id="variant_ids" value="<?php echo json_encode($variant_id); ?>">
        </div>
        @endif
    </div>
    
</div>