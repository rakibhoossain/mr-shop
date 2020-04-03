<form action="{{route('admin.product.brand.store')}}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="modal-header">
		<h5 class="modal-title">Add brand</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body row">
		<div class="col-6">
			<div class="form-group">
				<label for="brand_name">Brand name</label>
				<input type="text" class="form-control" id="brand_name" name="name" placeholder="Brand name" required>
			</div>
		</div>
		<div class="col-4">
			<div class="form-group">
				<label for="brand_image">Brand Image</label>
				<div class="input-group">
					<div class="custom-file">
						<input type="file" accept=".png, .jpg, .jpeg" class="custom-file-input" name="image" id="brand_image" required>
						<label class="custom-file-label" for="brand_image">Choose Image</label>
					</div>
				</div>
			</div>
		</div>
		<div class="col-2" id="brand_image_preview">
			<img src="{{asset('img/thumb_icon.png')}}" width="50" height="50" style="display: none;">
		</div>
		<div class="col-12">

			<div class="form-group">
				<label for="brand_description">Description</label>
				<textarea id="brand_description" class="form-control" placeholder="Brand Description" name="description"></textarea>
			</div>

		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		<button type="submit" class="btn btn-primary" id="save_varient">Save</button>
	</div>
</form>