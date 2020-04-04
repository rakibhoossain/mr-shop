@if(strpos($barcode, '-') !== false)
    @php $full_code = explode('-', $barcode); $code = $full_code[0]; $v_id = $full_code[1]; @endphp

	@php  
	$v_product = \App\Product::where('code', $code)->first(); 
	$variation = $v_product->variation_values()->where('variation_values.id', $v_id)->first();
	@endphp

	@if($variation)
        @php  $code = $v_product->code.'-'.$v_id; @endphp
		@while($qty > 0)
			<div style="display:inline-block;vertical-align:middle;line-height:10px !important;">
				@if(!empty($print['business_name']))
					<b style="font-size:12px;display: block !important;    margin-bottom:8px;" class="text-uppercase">{{config('settings.site_name')}}</b>
				@endif
				@if(!empty($print['name']))
					<span style="font-size:17px;display: block !important;margin-bottom: 7px;">
					<b>{{$v_product->name}}</b>
						
					</span>
				@endif	
			@if(!empty($print['variations']))
			<span style="display: block !important">
				 @if($variation->variation) <b> {{$variation->variation->name}} </b>: @endif {{$variation->name}}
			</span>
			@endif		
				@if(!empty($print['price']))
					<label  style="font-size:17px;margin-bottom:6px;">TK.
					<span style="font-size:17px;">
						@if($variation->pivot->price > 0 )
							{{$variation->pivot->price}} 
						@elseif($variation->pivot->sell_price > 0 )
							{{$variation->pivot->sell_price}}
						@elseif($v_product->price > 0 )
							{{$v_product->price}}
						@else
							{{$v_product->sell_price}}
						@endif
					</span>
					</label>
				@endif
			</div>
		@php $qty = $qty-1; @endphp 
		@endwhile
	@endif

@else

	@php  $single_product = \App\Product::where('code', $barcode)->first(); @endphp
	@while($qty > 0)
		<div style="display:inline-block;vertical-align:middle;line-height:10px !important;">
			@if(!empty($print['business_name']))
				<b style="font-size:12px;display: block !important;    margin-bottom:8px;" class="text-uppercase">{{config('settings.site_name')}}</b>
				
			@endif
			@if(!empty($print['name']))
				<span style="font-size:17px;display: block !important;margin-bottom: 7px;">
				<b>{{$single_product->name}}</b>
					
				</span>
			@endif			
			@if(!empty($print['price']))
				<label  style="font-size:17px;margin-bottom:6px;">TK.
				<span style="font-size:17px;">
					@if($single_product->price > 0 )
						{{$single_product->price}} 
					@else
						{{$single_product->sell_price}}
					@endif
				</span>
				</label>
			@endif
		</div>
		@php $qty--; @endphp 
	@endwhile

@endif