<div style="display:inline-block;vertical-align:middle;line-height:16px !important;">
	{{-- Business Name --}}
	@if(!empty($print['business_name']))
		<b style="display: block !important" class="text-uppercase">{{config('settings.site_name')}}</b>
	@endif

	{{-- Product Name --}}
	@if(!empty($print['name']))
		<span style="display: block !important">
			{{$product->name}}
		</span>
	@endif

	{{-- Variation --}}
	@if(!empty($print['variations']) && $variation)
		<span style="display: block !important">
			@if($variation->variation) <b> {{$variation->variation->name}} </b>: @endif {{$variation->name}}
		</span>
	@endif

	{{-- Price --}}
	@if(!empty($print['price']))
	<span style="display: block !important">
		<b>Price:</b>
		<span class="display_currency" data-currency_symbol="true">

		@if($variation)
			@if($variation->pivot->price > 0 )
				{{$variation->pivot->price}} 
			@elseif($variation->pivot->sell_price > 0 )
				{{$variation->pivot->sell_price}}
			@elseif($product->price > 0 )
				{{$product->price}}
			@else
				{{$product->sell_price}}
			@endif
		@else
			@if($product->price > 0 )
				{{$product->price}} 
			@else
				{{$product->sell_price}}
			@endif
		@endif
		</span>
	</span>
	@endif

	{{-- Barcode --}}
	<img class="center-block" style="max-width:90% !important;max-height: {{$barcode_details->height/4}}in !important; opacity: 0.9" src="data:image/png;base64,{{DNS1D::getBarcodePNG($barcode, $barcode_details->barcode_type, 2,30,array(39, 48, 54), true)}}">

</div>