<form action="{{route('admin.product.productTag.update', $productTag->slug)}}" method="POST" enctype="multipart/form-data">
	@method('PUT')
	@csrf
	<div class="modal-header">
		<h5 class="modal-title">Update Product Tag</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body row">
		<div class="col-12">
			<div class="form-group">
				<label for="tag_name">Tag name</label>
				<input type="text" class="form-control" id="tag_name" name="name" placeholder="Tag name" required value="{{$productTag->name}}">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		<button type="submit" class="btn btn-primary">Save</button>
	</div>
</form>