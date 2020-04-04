<div id="preview_body">
@php
	$loop_count = 0;
@endphp
@foreach($barcodes as $barcode => $qty)

	@if(strpos($barcode, '-') !== false)
		@php 
			$full_code = explode('-', $barcode); $code = $full_code[0]; $v_id = $full_code[1];
			$product = \App\Product::where('code', $code)->first(); 
			$variation = $product->variation_values()->where('variation_values.id', $v_id)->first();
		@endphp
	@else
		@php
			$product = \App\Product::where('code', $barcode)->first();
			$variation = null;
		@endphp

	@endif

	@while($qty > 0)
		@php
			$loop_count += 1;
			$is_new_row = (!$barcode_details->is_continuous) && (($loop_count == 1) || ($loop_count % $barcode_details->stickers_in_one_row) == 1) ? true : false;
		@endphp

		@if(($barcode_details->is_continuous && $loop_count == 1) || (!$barcode_details->is_continuous && ($loop_count % $barcode_details->stickers_in_one_sheet) == 1))
			{{-- Actual Paper --}}
			<div style="@if(!$barcode_details->is_continuous) height:{{$barcode_details->paper_height}}in !important; @else height:100% !important; @endif width:{{$barcode_details->paper_width}}in !important; line-height: 16px !important;" class="label-border-outer">

			{{-- Paper Internal --}}
			<div style="margin-top:{{$barcode_details->top_margin}}in !important; margin-bottom:{{$barcode_details->top_margin}}in !important; margin-left:{{$barcode_details->left_margin}}in !important;margin-right:{{$barcode_details->left_margin}}in !important;" class="label-border-internal">
		@endif

			@if((!$barcode_details->is_continuous) && ($loop_count % $barcode_details->stickers_in_one_sheet) <= $barcode_details->stickers_in_one_row)
				@php $first_row = true @endphp
			@elseif($barcode_details->is_continuous && ($loop_count <= $barcode_details->stickers_in_one_row) )
				@php $first_row = true @endphp
			@else
				@php $first_row = false @endphp
			@endif

			<div style="height:{{$barcode_details->height}}in !important; line-height: {{$barcode_details->height}}in; width:{{$barcode_details->width*0.97}}in !important; display: inline-block; @if(!$is_new_row) margin-left:{{$barcode_details->col_distance}}in !important; @endif @if(!$first_row)margin-top:{{$barcode_details->row_distance}}in !important; @endif" class="sticker-border text-center">
				@include('dashboard.product.label.code', compact('print', 'barcode', 'product', 'variation', 'barcode_details'))
			</div>

		@if(!$barcode_details->is_continuous && ($loop_count % $barcode_details->stickers_in_one_sheet) == 0)
			{{-- Actual Paper --}}
			</div>

			{{-- Paper Internal --}}
			</div>
		@endif

		@php $qty--; @endphp
	@endwhile
@endforeach

@if($barcode_details->is_continuous || ($loop_count % $barcode_details->stickers_in_one_sheet) != 0)
	{{-- Actual Paper --}}
	</div>

	{{-- Paper Internal --}}
	</div>
@endif

</div>
<style type="text/css">

	@media print{
		#preview_body{
			display: block !important;
		}
	}
	@page {
		size: {{$barcode_details->paper_width*0.64}}in @if($barcode_details->paper_height > 0){{$barcode_details->paper_height}}in @endif;
		margin-top: 0in;
		margin-bottom: 0in;
		margin-left: 0in;
		margin-right: 0in;
		@if($barcode_details->is_continuous)
			page-break-inside : avoid !important;
		@endif
	}
</style>