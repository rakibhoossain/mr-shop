<form action="{{route('admin.product.brand.update', $brand->slug)}}" method="POST" enctype="multipart/form-data">
  @method('PUT')
  @csrf
  <div class="modal-header">
    <h5 class="modal-title">Update brand</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body row">
    <div class="col-6">
      <div class="form-group">
        <label for="brand_name">Brand name</label>
        <input type="text" class="form-control" id="brand_name" name="name" placeholder="Brand name" required value="{{$brand->name}}">
      </div>
    </div>
    <div class="col-4">
      <div class="form-group">
        <label for="brand_image">Brand Image</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" accept=".png, .jpg, .jpeg" class="custom-file-input" name="image" id="brand_image">
            <label class="custom-file-label" for="brand_image">Choose Image</label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-2" id="brand_image_preview">
      <img src="{{asset($brand->image)}}" width="50" height="50" alt="{{$brand->name}}">
    </div>
    <div class="col-12">
      <div class="form-group">
        <label for="brand_description">Description</label>
        <textarea id="brand_description" class="form-control" placeholder="Brand Description" name="description">{{$brand->description}}</textarea>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-primary" id="save_varient">Save</button>
  </div>
</form>