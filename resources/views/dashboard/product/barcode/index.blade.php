@extends('layouts.dashboard')
@section('title', 'Print Barcode')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
					<li class="breadcrumb-item active">Print Barcode</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
	<form id="barcode_print_form">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Print Barcode</h3>
					</div>
					<div class="card-body">
						<div class="row justify-content-md-center">
							<div class="col-sm-8">
								<div class="input-group mb-4">
									<div class="input-group-prepend">
										<button id="button-addon7" type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
									</div>
									<input type="search" placeholder="Search product by Name/Barcode" id="barcode_search_input" aria-describedby="button-addon7" class="form-control" autofocus>
								</div>
							</div>
							<div class="col-sm-8">
								<table class="table table-bordered table-striped table-condensed" id="barcode_label_table">
									<thead>
										<tr>
											<th>Products</th>
											<th style="width: 200px;">No. of labels</th>
											<th style="width: 50px;">Action</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row justify-content-md-center">
							<div class="col-sm-3">
								<div class="icheck-success d-inline">
									<input type="checkbox" checked="" name="print[name]" value="1" id="print_product_name">
									<label for="print_product_name">Product Name</label>
								</div>
							</div>				
							<div class="col-sm-3">
								<div class="icheck-success d-inline">
									<input type="checkbox" checked="" name="print[variations]" value="1" id="print_product_variation">
									<label for="print_product_variation">Product Variation (recommended)</label>
								</div>
							</div>				
							<div class="col-sm-3">
								<div class="icheck-success d-inline">
									<input type="checkbox" checked="" name="print[price]" value="1" id="print_product_price">
									<label for="print_product_price">Product Price</label>
								</div>
							</div>				
							<div class="col-sm-3">
								<div class="icheck-success d-inline">
									<input type="checkbox" checked="" name="print[business_name]" value="1" id="print_business_name">
									<label for="print_business_name">Business name</label>
								</div>
							</div>
							<div class="col-sm-12"><hr></div>
							<div class="col-sm-4 col-sm-offset-8">
								<button type="button" id="labels_preview" class="btn btn-primary pull-right btn-flat btn-block">Preview</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row justify-content-md-center">
							<div id="barcode_show_area"></div>




							<div class="col-sm-12"><hr></div>
						</div>
					</div>
				</div>
			</div>



		</div>
	</div><!-- /.container-fluid -->
	</form>
</div>
<!-- /.content -->
@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {

  $(document).on('keyup', '#barcode_search_input', function(e){
    e.preventDefault();
    let search = $(this).val();
    if(e.keyCode == 17 || search.length < 4) return;
    var _this = this;

    let url = "{{route('admin.barcode.index')}}";
    $.ajax({
      type: "Post",
      url,
      data: {search},
      success: function(response) {
        if(response.success) {
        	$(_this).val('').focus();
        	var $varient = $("#barcode_label_table tbody tr[data-id='"+response.code+"']");
        	if($varient.length){
        		var input_v = $varient.find('input.form-control');
        		var val = parseInt($(input_v).val()) || 0;
        		$(input_v).val(++val);
        	}else{
        		$('#barcode_label_table tbody').append(response.html);        		
        	}
        }else {
          Swal.fire('Error!', response.message,'error');
        }
      }
    });    
  })

  $(document).on('click', '.remove_barcode', function(e){
  	e.preventDefault();
  	$(this).parents('tr').remove();
  })
  $('#barcode_print_form').submit(function(e){
  	e.preventDefault();

  })



  $(document).on('click', '#labels_preview', function(e){
    e.preventDefault();
    let url = "{{route('admin.barcode.preview')}}";
    $.ajax({
      type: "Post",
      url,
      dataType: "json",
      data: $('form#barcode_print_form').serialize(),
      success: function(response) {
        if(response.success) {
        	$('#barcode_show_area').html(response.html);
        }else {
          Swal.fire('Error!', response.message,'error');
        }
      }
    });    
  })






});
</script>
@endpush