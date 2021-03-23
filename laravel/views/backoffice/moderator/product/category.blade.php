<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">1</span>
            <div class='stepper-header'>
                <h3 class='box-title'>Category</h3>
                <p>Select and define a sub-category for your product.</p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('category')">
            {!! Form::Label('category', 'Category', []) !!}
            <select id="category" class="form-control" name="category">
                <?php $selected = (!isset($product)) ? "selected = true" : ""; ?>
                <option {!! $selected !!} value='none' data-category-id='-1'>Select a category</option>
                <?php
                
                foreach($categories As $parent => $children) {
                    echo "<optgroup label='$parent'>";
                    foreach($children As $name => $child_id) {
                        
                        $selected = (isset($product) && isset($product->category) && isset($product->category->name) && $product->category->name == $name) ? "selected = true" : "";
                        echo "<option $selected value='$child_id' data-category-id='$child_id'>$name</option>";
                    }
                    echo "</optgroup>";
                }
                
                ?>
            </select>
            @showErrors('category')
        </div>
        
        <!-- Category Attributes - see category.js -->
        <div id='attributes'></div>
        
        <script type="text/javascript"> 
            var attributes = <?php echo json_encode($attributes); ?>; 
            var attributeValueProduct = <?php echo (isset($attributeValueProduct)) ? json_encode($attributeValueProduct) : json_encode([]) ?>;
            var attributes_child = <?php echo json_encode(LookupHelper::getAtrributeChild()); ?>;
        </script>
        <!-- Category Attributes -->
        
    </div>
</div>