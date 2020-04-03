<tr data-id="{{$code}}">
	<td>
		{{$product->name}} @if($variation->variation) {{$variation->variation->name}} @endif {{'('.$variation->name.')'}}
	</td>
	<td>
		<input type="number" class="form-control" name="barcodes[{{$code}}]" value="0">
	</td>
	<td>
		<a href="#" class="btn btn-danger btn-sm remove_barcode">Remove</a>
	</td>
</tr>