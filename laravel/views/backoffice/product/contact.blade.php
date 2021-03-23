<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">3</span>
            <div class='stepper-header'>
                <h3 class='box-title'>Contact Information</h3>
            </div>
        </div>
    </div>
    
    <div class='box-body'>
        <div class="form-group @hasError('contact_name')">
            {!! Form::Label('contact_name', 'Contact Name', ['class' => '  ']) !!}
          
                @php $name = $store->contactDetails->firstname.' '.$store->contactDetails->lastname; @endphp 
            <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Contact Name" value="{{ ((isset($product->ContactDetails) && empty(old('contact_name')) ) ? $product->ContactDetails->contact_name : ((empty( old('contact_name')))?  $name : old('contact_name'))      )}}">  
            @showErrors('contact_name')
        </div>
        <div class="form-group @hasError('phone')">
            {!! Form::Label('phone', 'Phone', ['class' => '  ']) !!}
           
            <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">+263</span>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="cellphone" value="{{ ((isset($product->ContactDetails) && empty(old('phone')) ) ? $product->ContactDetails->phone : ((empty( old('phone')))?  $store->contactDetails->phone: old('phone'))      )}}">
            </div>
            @showErrors('phone')   
        </div>
        <div class="form-group @hasError('city')">
            {!! Form::Label('city', 'City', ['class' => '  ']) !!}
            {!! Form::select('city', $city, 
                \ViewHelper::showValue(old('city'), (isset($product) && !is_null($product->ContactDetails)) ? $product->ContactDetails : null, 'city_id'),
                ['class' => 'form-control', 'id' => 'ccity']); !!}    
            @showErrors('city')
        </div>
        @php
           
            if(old('suburb') != null ){
                $sub = old('suburb');
            }elseif(isset($product->ContactDetails)){
                $sub =$product->ContactDetails->suburb_id;
            }else{
                $sub = $store->contactDetails->suburb_id;
            }

            if(old('city') != null ){
                $cty = old('city');
            }elseif(isset($product->ContactDetails)){
                $cty =$product->ContactDetails->city_id;
            }else{
                $cty = $store->contactDetails->city_id;
            }

          
        @endphp
        <div class="form-group @hasError('suburb')">
            {!! Form::Label('suburb', 'Suburb', ['class' => '  ']) !!}
            <select class="form-control" id="csuburb" name="suburb" disabled="true" data-cvalue="{{ $cty }}" data-svalue="{{ $sub }}">
                <option value="0">Select Suburb</option>
            </select>  
            @showErrors('suburb')
        </div>
        
    </div>
    
</div>
<script type="text/javascript">
$(function(){
    var suburb = {
        data: <?php echo json_encode($suburb); ?>,
        activeSuburb: [],
        cityid:$('#csuburb').attr('data-cvalue'),
        suburbid:$('#csuburb').attr('data-svalue'),
        selected:function(id){
            var data = [];
            $.each(this.data, (i, val)=>{
                if(val.city_id == parseInt(id)){
                    data.push(val);
                }
                
            })
            this.activeSuburb = data;
            return this;
        },
        dropdown:function(selectorid){
            $('#'+selectorid).html('');
            var options = '<option value="0">Select Suburb</option>';
            $.each(this.activeSuburb, (i, val)=>{
                options += '<option value="'+ val.id+'">'+ val.name+'</option>';
            });
            $('#'+selectorid).html(options).attr('disabled', false);
            
        },
        Onloaddropown:function(selectorid){
            if(this.cityid != '0' && this.cityid !=''){
                console.log(this.suburbid);
                $('#ccity').val(this.cityid);
                this.selected(this.cityid);
                $('#'+selectorid).html('');
                var options = '<option value="0">Select Suburb</option>';
                $.each(this.activeSuburb, (i, val)=>{
                    if(val.id == this.suburbid){
                        options += '<option value="'+ val.id+'" selected>'+ val.name+'</option>';
                    }else{
                        options += '<option value="'+ val.id+'">'+ val.name+'</option>';
                    }
                    
                });
                $('#'+selectorid).html(options).attr('disabled', false);
            }
            
        }
        
    };
    suburb.Onloaddropown('csuburb');
    $('#ccity').on('change', function(){
        var cityid = $(this).val();
        if(cityid != '0'){
           suburb.selected(cityid).dropdown('csuburb');
        }else{
            var options = '<option value="0">Select Suburb</option>';
            $('#csuburb').html(options).attr('disabled', true);
        }
    })
    
});
</script>