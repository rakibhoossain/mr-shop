<tr data-id="{{$product->code}}">
	<td>
		{{$product->name}}
	</td>
	<td>
		<input type="number" class="form-control" name="barcodes[{{$product->code}}]" value="0">
	</td>
	<td>
		<a href="#" class="btn btn-danger btn-sm remove_barcode">Remove</a>
	</td>
</tr>