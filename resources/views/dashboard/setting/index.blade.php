@extends('layouts.dashboard')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Edit Settings</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <form role="form" action="{{ route('admin.settings.store') }}" method="POST"  enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="card-header">
            <h3 class="card-title">Edit Settings</h3>
            <div class="card-tools">
              <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button>
            </div>
          </div>
            <div class="card-body row">

              <div class="col-md-2 mb-3">
                <ul class="nav nav-pills flex-column" id="settingsTab" role="tablist">
                  @foreach($setting_groups as $group => $settings)
                  <li class="nav-item">
                    <a class="nav-link @if($loop->index == 0) active @endif" id="{{$group}}-tab" data-toggle="tab" href="#{{$group}}" role="tab" aria-controls="{{$group}}" aria-selected="false">{{Str::title(str_replace('_', ' ', $group))}}</a>
                  </li>
                  @endforeach
                </ul>
              </div>

              <div class="col-md-10">
                <div class="tab-content" id="settingsTabContent">
                  @foreach($setting_groups as $group => $settings)
                  <div class="tab-pane fade @if($loop->index == 0) show active @endif" id="{{$group}}" role="tabpanel" aria-labelledby="{{$group}}-tab">
                    @foreach($settings as $setting)
                      <div class="form-group">
                        @includeIf('dashboard.setting.'.$setting->type, compact('setting'))
                      </div>
                    @endforeach
                  </div>
                  @endforeach
                </div>
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
  var img_height = 1200;
  var img_width = 1080;
  var img_ratio = 0.9;
  var cropper;
  var img_selector;

  $(document).on("change", ".upload_logo, .upload_favicon", function(e) {
    e.preventDefault();
    img_selector = this;

    img_ratio = parseFloat($(this).data('ratio')) || 0.9;
    let size = $(this).data('size').split("x");
    if(size){
      img_height = parseInt(size[0]) || 1200;
      img_width = parseInt(size[1]) || 1080;
    }
    var files = e.target.files;
    var done = function(url) {
      image.src = url;
      // $modal.find('.modal-footer').html(modal_btn);
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
          aspectRatio: img_ratio,
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
        width: img_width,
        height: img_height,
    });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
          var base64data = reader.result;
          $(img_selector).siblings('img').attr('src', base64data);
          $(img_selector).siblings('.image_input').val(base64data);
          $modal.modal('hide');
        }
    });
  })

  $(document).on('click', '.remove_img', function(e){
    e.preventDefault();
    var dummy_img = "{{asset('img/thumb_icon.png')}}";
    $(this).parents('.preview_single').find('img').attr('src', dummy_img);
    $(this).parents('.preview_single').find('.image_input').val('del');
  })
  
})
</script>
@endpush