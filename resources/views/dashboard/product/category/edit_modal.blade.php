<form action="{{route('admin.product.productCategory.update', $productCategory->slug)}}" method="POST" enctype="multipart/form-data">
	@method('PUT')
	@csrf
	<div class="modal-header">
		<h5 class="modal-title">Edit Product Category</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body row">
		<div class="col-6">
			<div class="form-group">
				<label for="brand_name">Category name</label>
				<input type="text" class="form-control" id="brand_name" name="name" placeholder="Category name" required value="{{$productCategory->name}}">
			</div>
		</div>
		<div class="col-4">
			<div class="form-group">
				<label for="category_image">Category Image</label>
				<div class="input-group">
					<div class="custom-file">
						<input type="file" accept=".png, .jpg, .jpeg" class="custom-file-input" name="image" id="category_image">
						<label class="custom-file-label" for="category_image">Choose Image</label>
					</div>
				</div>
			</div>
		</div>
		<div class="col-2" id="category_image_preview">
			@if($productCategory->image)
			<img src="{{asset($productCategory->image)}}" width="50" height="50">
			@else
			<img src="{{asset('img/thumb_icon.png')}}" width="50" height="50" style="display: none;">
			@endif
		</div>
		<div class="col-12">
			<div class="form-group">
				<label for="category_description">Description</label>
				<textarea id="category_description" class="form-control" placeholder="Category Description" name="description">{{$productCategory->description}}</textarea>
			</div>
		</div>
		<div class="col-12">
			<div class="form-group">
				<label for="sub_category_select">Sub Catagories</label>
				<select class="form-control sub_category select-2" id="sub_category_select" name="sub_categories[]" multiple style="width: 100%">
					@foreach($productCategory->children as $ccategory)
					<option value="{{$ccategory->id}}" selected>{{$ccategory->name}}</option>
					@endforeach
					@foreach($categories as $category)
					<option value="{{$category->id}}">{{$category->name}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		<button type="submit" class="btn btn-primary" id="save_varient">Save</button>
	</div>
</form>