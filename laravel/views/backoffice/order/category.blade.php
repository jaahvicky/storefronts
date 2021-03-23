<div class='box box-primary @if( !isset($order_id) ) cat-ele @endif'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">2</span>
            <div class='stepper-header'>
                <h3 class='box-title required'>Category</h3>
                <p>Select and define a sub-category for your order.</p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('category')">
            {!! Form::Label('category', 'Category', []) !!}
            <select id="category" class="form-control" name="category">
                <option value='' data-category-id='-1'>Select a category</option>
                <?php
                foreach($categories As $parent => $children) {
                    echo "<optgroup label='$parent'>";
                    foreach($children As $name => $child_id) {
                        if(isset($cur_order)){
                            if($cur_category == $child_id){
                                echo "<option value='$child_id' data-category-id='$child_id' selected>$name</option>";
                            } else {
                                echo "<option value='$child_id' data-category-id='$child_id'>$name</option>";
                            }
                        } else {
                            echo "<option value='$child_id' data-category-id='$child_id'>$name</option>";
                        }
                        
                        
                    }
                    echo "</optgroup>";
                }
                
                ?>
            </select>
            @showErrors('category')
        </div>
        <div class="alert alert-warning alert-dismissible cat-warning">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Sorry!</h4>
            No products for this category.
        </div>
        
        <div class="overlay cat-overlay">
          <i class="fa fa-refresh fa-spin"></i>
        </div>

        
    </div>
</div>