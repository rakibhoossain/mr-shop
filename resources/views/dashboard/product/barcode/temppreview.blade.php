<div id="preview_body" style="width:150px;text-align:center; font-size:20px">
@php $loop_count = 0; @endphp

@foreach($barcodes as $barcode => $qty)



<!-- Within while loop -->
@php 
	$loop_count += 1; 
	$is_new_row = (!$barcode_details->is_continuous) && (($loop_count == 1) || ($loop_count % $barcode_details->stickers_in_one_row) == 1) ? true : false;
@endphp




<!-- end loop -->








	@include('dashboard.product.barcode.barcodes', compact('print', 'barcode', 'qty'))
@endforeach
</div>

<style type="text/css">
    .label-border-outer{
        height: 100% !important;
        width: 1.5in !important;
        line-height: 16px !important;
        margin-left: 10%;
    }
    .sticker-border{
		width: 1.8in !important;
    }
	@media print{
		#preview_body{
			display: block !important;
		}
	}
	@page {
		size: {{$barcode_details->paper_width}}in @if($barcode_details->paper_height > 0) x {{$barcode_details->paper_height}}@endif in ;
		margin-top: 0in;
		margin-bottom: 0in;
		margin-left: 0in;
		margin-right: 0in;
		
		@if($barcode_details->is_continuous)
			page-break-inside : avoid !important;
		@endif
	}
</style>