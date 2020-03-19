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
                  <textarea class="form-control textarea" id="description" name="description" placeholder="Product Description ..."></textarea>
                </div>
              </div>

              <div class="col-sm-12 col-md-3">
                  <div class="form-group">
                    <label for="purchase_price">Purchase Price</label>
                    <input type="text" class="form-control" id="purchase_price" name="purchase_price" placeholder="Purchase Price">
                  </div>
                  <div class="form-group">
                    <label for="price">Sell Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Sell Price">
                  </div>

                  <div class="form-group">
                    <label for="alert_quantity">Alert Quantity</label>
                    <input type="text" class="form-control" id="alert_quantity" name="alert_quantity" placeholder="Alert Quantity">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                <!-- brand_id -->

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

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function () {
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
});
</script>
@endpush