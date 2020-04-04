<form action="{{route('admin.product.barcode.update', $barcode->slug)}}" method="POST" enctype="multipart/form-data">
	@method('PUT')
	@csrf
	<div class="modal-header">
		<h5 class="modal-title">Update Barcode</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body row">
		<div class="col-12">
			<div class="form-group">
				<label for="name">Barcode Name</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Barcode Name" required value="{{$barcode->name}}">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="width">Barcode Width</label>
				<input type="text" class="form-control" id="width" name="width" placeholder="Barcode Width" value="{{$barcode->width}}">
			</div>
		</div>		
		<div class="col-md-6">
			<div class="form-group">
				<label for="height">Barcode Height</label>
				<input type="text" class="form-control" id="height" name="height" placeholder="Barcode Height" value="{{$barcode->height}}">
			</div>
		</div>		
		<div class="col-md-6">
			<div class="form-group">
				<label for="paper_width">Paper Width</label>
				<input type="text" class="form-control" id="paper_width" name="paper_width" placeholder="Paper Width" value="{{$barcode->paper_width}}">
			</div>
		</div>		
		<div class="col-md-6">
			<div class="form-group">
				<label for="paper_height">Paper Height</label>
				<input type="text" class="form-control" id="paper_height" name="paper_height" placeholder="Paper Height" value="{{$barcode->paper_height}}">
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="top_margin">Top Margin</label>
				<input type="text" class="form-control" id="top_margin" name="top_margin" placeholder="Top Margin" value="{{$barcode->top_margin}}">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="left_margin">Left Margin</label>
				<input type="text" class="form-control" id="left_margin" name="left_margin" placeholder="Left Margin" value="{{$barcode->left_margin}}">
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="row_distance">Row Distance</label>
				<input type="text" class="form-control" id="row_distance" name="row_distance" placeholder="Row Distance" value="{{$barcode->row_distance}}">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="col_distance">Column Distance</label>
				<input type="text" class="form-control" id="col_distance" name="col_distance" placeholder="Column Distance" value="{{$barcode->col_distance}}">
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="stickers_in_one_row">Stickers in one row</label>
				<input type="text" class="form-control" id="stickers_in_one_row" name="stickers_in_one_row" placeholder="Stickers in one row" value="{{$barcode->stickers_in_one_row}}">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="stickers_in_one_sheet">Stickers in one sheet</label>
				<input type="text" class="form-control" id="stickers_in_one_sheet" name="stickers_in_one_sheet" placeholder="Stickers in one sheet" value="{{$barcode->stickers_in_one_sheet}}">
			</div>
		</div>

		<div class="col-md-6">
			<div class="icheck-success d-inline">
				<input type="checkbox" name="is_continuous" value="1" id="is_continuous" @if($barcode->is_continuous) checked @endif >
				<label for="is_continuous">Continuous</label>
			</div>
		</div>
		<div class="col-md-6">
			<div class="icheck-success d-inline">
				<input type="checkbox" name="is_default" value="1" id="is_default" @if($barcode->is_default) checked @endif >
				<label for="is_default">Default</label>
			</div>
		</div>
		<div class="col-12 mt-3">
			<div class="form-group">
				<label for="description">Description</label>
				<textarea id="description" class="form-control" placeholder="Barcode Description" name="description">{{{$barcode->description}}}</textarea>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>
</form>