@extends('layouts.dashboard')
@section('content')

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <form role="form" action="{{route('admin.product.store')}}" method="POST"  enctype="multipart/form-data" id="product_form">
          {{csrf_field()}}
          <div class="card-header">
            <h3 class="card-title">Create Product</h3>
            <div class="card-tools">
              <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Publish</button>
            </div>
          </div>
            <div class="card-body row">
              <div class="col-sm-12 col-md-9">
                <div class="form-group">
                  <label for="name">Product name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Product name" required>
                </div>
                <div class="form-group">
                  <label for="description">Product Description</label>
                  <textarea class="form-control textarea summernote" id="description" name="description" placeholder="Product Description ..."></textarea>
                </div>
                <div class="form-group">
                  <label for="excerpt">Excerpt</label>
                  <textarea class="form-control" id="excerpt" name="excerpt" placeholder="Excerpt ..."></textarea>
                </div>

                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Additional Information</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="additional_info_table" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th style="width: 10px;">
                              <input type="checkbox" id="checkall">
                            </th>
                            <th>Key</th>
                            <th>Value</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr id="no_h">
                            <td>
                              <input type="checkbox" class="checkbox" name="record">
                            </td>
                            <td class="editMe">
                              <input type="text" class="form-control Key" name="keys[]" id="additional_info_key">
                            </td>
                            <td class="editMe">
                              <input type="text" class="form-control value" name="values[]" id="additional_info_value">
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="text-right">
                        <a href="javasctipt:void(0)" class="delete-row btn btm-sm btn-danger">Remove <i class="fa fa fa-trash"></i></a>
                        <a href="javasctipt:void(0)" class="add-row-info btn btm-sm btn-success">Add more <i class="fa fa-plus-circle"></i></a>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->


              @if(App\Variation::count())
                <!-- variable product -->
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                      <h3 class="card-title">Product Type</h3>
                    </div>

                     <select class="form-control col-md-3" id="product_add_varient" data-url="{{route('admin.varient.field')}}">
                        <option value="single">Single</option>
                        <option value="varient">Varient</option>
                      </select>                       

                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" id="varient_field_area"></div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                @endif
              </div>

              <div class="col-sm-12 col-md-3">
                <div class="form-group">
                  <label for="sell_price">Sell Price</label>
                  <input type="text" class="form-control" id="sell_price" name="sell_price" placeholder="Sell Price">
                </div>
                <div class="form-group">
                  <label for="price">Offer Price</label>
                  <input type="text" class="form-control" id="price" name="price" placeholder="Offer Price">
                </div>
                <div class="form-group">
                  <label for="purchase_price">Purchase Price</label>
                  <input type="text" class="form-control" id="purchase_price" name="purchase_price" placeholder="Purchase Price">
                </div>
                <div class="form-group">
                  <label for="quantity">Quantity</label>
                  <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity">
                </div>
                <div class="form-group">
                  <label for="alert_quantity">Alert Quantity</label>
                  <input type="text" class="form-control" id="alert_quantity" name="alert_quantity" placeholder="Alert Quantity">
                </div>
                <div class="form-group">
                  <label for="brand_id">Brand</label>
                  <select class="form-control select2" id="brand_id" name="brand_id" style="width: 100%" data-placeholder="Select a Brand">
                    <option value="" hidden>Select a Brand</option>
                    @foreach(App\Brand::latest()->get() as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="category_ids">Categories</label>
                  <select class="form-control select2" id="category_ids" name="categories[]" multiple style="width: 100%" data-placeholder="Select Categories">
                    @foreach(App\ProductCategory::whereNull('product_category_id')->latest()->get() as $category)
                      @if(count($category->children))
                        <optgroup label="{{$category->name}}">
                        @foreach($category->children as $child_cat)
                          <option value="{{$child_cat->id}}">{{$child_cat->name}}</option>
                        @endforeach
                        </optgroup>
                      @else
                        <option value="{{$category->id}}">{{$category->name}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="tag_ids">Tags</label>
                  <select class="form-control select2" id="tag_ids" name="tags[]" multiple style="width: 100%" data-placeholder="Select Tags">
                    @foreach(App\ProductTag::latest()->get() as $tag)
                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="upload_product_image">Product Images</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" accept=".png, .jpg, .jpeg" class="custom-file-input" id="upload_product_image" data-crop="product">
                      <label class="custom-file-label" for="upload_product_image">Choose Image</label>
                    </div>
                  </div>
                </div>
                <!-- Image crop -->
                <div id="images"></div>
              </div>
              <!-- /.card-body -->
            </div>
          </form>
          <!-- /.card -->
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->


<!-- Modal Product Image -->
<div class="modal fade" id="UploadImageModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image_prev" src="https://via.placeholder.com/460x460.png?text=No+Photo" class="img-fluid">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
      </div>
    </div>
  </div>
</div>


<style type="text/css">
.preview {
  overflow: hidden;
  width: 160px; 
  height: 160px;
  margin: 10px;
  border: 1px solid red;
}
#images .preview_single{
  display: inline-block;
}
.preview_single {
    position: relative;
    transition: all ease 0.1s;
}
.remove_img {
    position: absolute;
    top: 50%;
    right: 85%;
    transform: translate(50%, -50%);
    cursor: pointer;
    color: #e01919;
    opacity: 0;
    z-index: -99;
    transition: all ease 0.1s;
}
.preview_single:hover .remove_img{
  right: 50%;
  z-index: 1;
  opacity: 1;
}
.preview_single:hover img{
  opacity: 0.3;
}
</style>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function () {
  var $modal = $('#UploadImageModal');
  var image = document.getElementById('image_prev');
  var cropper;

  $(document).on("change", "#upload_product_image, .varient_image_btn", function(e) {
    e.preventDefault();

    let btn_id = ($(this).data('crop'))? 'crop' : 'varient_crop';
    let id = ($(this).data('id'))? `data-id='${$(this).data('id')}'` : '';
    let modal_btn = `
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      <button type="button" class="btn btn-primary" ${id} id="${btn_id}">Crop</button>
    `;


      var files = e.target.files;
      var done = function(url) {
          image.src = url;
          $modal.find('.modal-footer').html(modal_btn);
          $modal.modal('show');
      };
      var reader;
      var file;
      var url;

      if (files && files.length > 0) {
          file = files[0];

          if( (file.size/1000000) > 2){
            toastr.error('Max image size 2MB.', 'Error!');
            return;
          };

          if (URL) {
              done(URL.createObjectURL(file));
          } else if (FileReader) {
              reader = new FileReader();
              reader.onload = function(e) {
                  done(reader.result);
              };
              reader.readAsDataURL(file);
          }
      }
      $(this).val('');
  });

  $modal.on('shown.bs.modal', function() {
      cropper = new Cropper(image, {
          aspectRatio: .9,
          viewMode: 3,
          preview: '.preview'
      });
  }).on('hidden.bs.modal', function() {
      cropper.destroy();
      cropper = null;
      image.src = 'https://via.placeholder.com/460x460.png?text=No+Photo';
  });

  $(document).on('click', '#crop', function() {
    canvas = cropper.getCroppedCanvas({
        width: 1200,
        height: 1080,
    });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            var base64data = reader.result;
            $('#images').append(`
              <div class='preview_single'>
              <input type="hidden" name="images[]" value="${base64data}">
              <img src="${base64data}" width="100" height="100">
              <div class="remove_img"><i class="fas fa-trash"></i></div>
              </div>
              `);
            $modal.modal('hide');
        }
    });
  })

  $(document).on('click', '.remove_img', function() {
    $(this).parent('.preview_single').remove();
  })

  $(document).on('click', '#varient_crop', function(e) {
    e.preventDefault();
    let id = `#varient_image_${$(this).data('id')}`;
    let preview_id = `#varient_image_preview_${$(this).data('id')}`;
    canvas = cropper.getCroppedCanvas({
        width: 1200,
        height: 1080,
    });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
            var base64data = reader.result;
            $(id).val(base64data);
            $(preview_id).attr('src', base64data);
            $modal.modal('hide');
        }
    });
  })

    //Info field Add
  $(document).on('click', '.add-row-info', function(e){
    e.preventDefault();
    let key = $('#additional_info_key').val();
    let value = $('#additional_info_value').val();

    if(!value || !key || value.length<4 || key.length<4 ){
      $('#additional_info_key').focus();
      // toastr.error('Account must be 4 length long!');
      return;
    }
    let tr = `
      <tr>
        <td>
          <input type="checkbox" class="checkbox" name="record">
        </td>
        <td class="editMe">
          <input type="text" class="form-control Key" name="keys[]" value="${key}">
        </td>
        <td class="editMe">
          <input type="text" class="form-control value" name="values[]" value="${value}">
        </td>
      </tr>
    `;
    $('#additional_info_table tbody tr:first').after(tr);
   
    $('#additional_info_key').val('').focus();
    $('#additional_info_value').val('');
  })

  $("#additional_info_table #checkall").click(function () {
    var is_checked = $(this).is(":checked");
    $("#additional_info_table .checkbox").prop("checked", !is_checked).trigger("click");
  });
  // Find and remove selected table rows
  $(".delete-row").click(function(){
      $("#additional_info_table tbody").find('input[name="record"]').each(function(){
          if($(this).is(":checked")){
            if($(this).parents("tr#no_h").length){
              $(this).parents("tr").find('.Key').val('').focus();
              $(this).parents("tr").find('.value').val('');
            }else{
              $(this).parents("tr").remove();
            }
          }
      });
      $("#additional_info_table .checkbox").prop("checked", 'false').trigger("click");
      $("#checkall").prop("checked", 'false').trigger("click");
  });



  //Form validate
  // $.validator.setDefaults({
  //   submitHandler: function () {
  //     // alert( "Form successful submitted!" );
  //   }
  // });
  $('#product_form').validate({
    rules: {
      name: {
        required: true,
      },
      // description: {
      //   required: true,
      // },
      // purchase_price: {
      //   required: true
      // },      
      // price: {
      //   required: true
      // },
      // description: {
      //   required: true
      // }
    },
    // messages: {
    //   email: {
    //     required: "Please enter a email address",
    //     email: "Please enter a vaild email address"
    //   },
    //   password: {
    //     required: "Please provide a password",
    //     minlength: "Your password must be at least 5 characters long"
    //   },
    //   terms: "Please accept our terms"
    // },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });

  $(document).on('change', '#product_add_varient', function(e){
    e.preventDefault();
    let url = $(this).data('url');
    let val = $(this).val();
    $.ajax({
      type: 'POST',
      url,
      data: {varient_create: val},
      success: function(response){
        if(response.success){
          $('#varient_field_area').html(response.html);
        }
      }
    })
  })

  $(document).on('change', '#variation_selection', function(e){
    e.preventDefault();
    let url = $(this).data('url');
    let val = $(this).val();
    $.ajax({
      type: 'POST',
      url,
      data: {variation: val},
      success: function(response){
        if(response.success){
          $('#variation_selection_body').html(response.html);
        }
      }
    })
  })  

  $(document).on('change', '#varient_select', function(e){
    e.preventDefault();

    let current_val = $(this).val();
    let i = 0;
    let find_val = $('.varient_row').each(function(){
        if($(this).data('id') == current_val) i++;
    });
    if(i) return;

    let url = $(this).data('url');
    let val = $(this).val();
    $.ajax({
      type: 'POST',
      url,
      data: {varient: val},
      success: function(response){
        if(response.success){
          if($(".varient_row[data-id='"+response.id+"']").length) return;
          $('#variation_selection_body').append(response.html);
          $('#varient_select').val('');
        }
      }
    })
  })

  $(document).on('click', '.remove_varients', function(e){
    e.preventDefault();
    $(this).parents('.varient_table').remove();
  })  
  $(document).on('click', '.remove_varient', function(e){
    e.preventDefault();
    $(this).parents('.varient_row').remove();
  })


})
</script>
@endpush