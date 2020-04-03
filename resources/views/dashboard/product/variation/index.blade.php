@extends('layouts.dashboard')
@section('title', 'Variations')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('admin')}}">Home</a></li>
          <li class="breadcrumb-item active">Variations</li>
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
          <div class="card-header">
            <h3 class="card-title">Variation Table</h3>
            <div class="card-tools">
              @can('role-create')
              <a class="btn btn-success" href="#" data-url="{{route('admin.product.variation.create')}}" id="add_variation"> Create New Variation</a>
              @endcan
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="variation_table">
                <thead>
                  <tr>
                    <th style="width: 25px;">No</th>
                    <th>Name</th>
                    <th>Values</th>
                    <th style="width: 80px;">Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach (\App\Variation::latest()->get() as $variation)
                <tr>
                    <td>{{ $loop->index + 1}}</td>
                    <td>{{ $variation->name }}</td>
                    <td>{{ $variation->values->implode('name', ', ') }}</td>
                    <td>
                    	<ul class="nav tbl_btns">
                    		<li><a href ="#" data-url="{{route('admin.product.variation.edit', $variation->slug)}}" class="variation_edit"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a></li>
                    		<li><a href="#" data-url="{{route('admin.product.variation.destroy', $variation->slug)}}" class="sweet_confirm"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                    	</ul>
                    </td>
                </tr>
                @endforeach

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->



<!-- Modal Product Image -->
<div class="modal fade" id="variationModal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		</div>
	</div>
</div>




@endsection
@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	var $modal = $('#variationModal');


  $('#variation_table').delegate('.sweet_confirm', 'click', function(e){
    e.preventDefault();
    let url = $(this).data('url');
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          type: "DELETE",
          url: url,
          success: function(response) {
            if (response.success) { // if true (1)
              Swal.fire('Deleted!', response.message,'success');
              setTimeout(function() { // wait for 0.5 secs(2)
                location.reload(); // then reload the page.(3)
              }, 500);
            } else {
              Swal.fire('Error!', response.message,'error');
            }
          }
        });
      }
    })
  });

  $(document).on('click', '#add_variation', function(e){
    e.preventDefault();
    let url = $(this).data('url');
    $.ajax({
      type: "GET",
      url,
      success: function(response) {
        if (response.success) {
          $modal.find('.modal-content').html(response.html);
          $modal.modal('show');
        } else {
          Swal.fire('Error!', 'Something went wrong!','error');
        }
      }
    });    
  })

  $(document).on('click', '#variation_table .variation_edit', function(e){
    e.preventDefault();
    let url = $(this).data('url');
    $.ajax({
      type: "GET",
      url,
      success: function(response) {
        if (response.success) {
          $modal.find('.modal-content').html(response.html);
          $modal.modal('show');
        } else {
          Swal.fire('Error!', 'Something went wrong!','error');
        }
      }
    });    
  })

	// $(document).on('click', '#add_variation', function(e){
	//   	e.preventDefault();
	//   	$modal.modal('show');
	// })       

	var tr = `
		<tr>
      <td>
        <input type="checkbox" class="checkbox" name="record">
      </td>
      <td class="editMe">
        <input type="text" class="form-control" name="names[]" required>
      </td>
      <td class="editMe">
        <select class="form-control varient_type" name="types[]">
          <option value="normal" selected>Normal</option>
          <option value="color">Color</option>
        </select>
      </td>
      <td class="editMe" style="width: 100px;">
        <input type="text" class="form-control varient_data" disabled name="datas[]">
      </td>
    </tr>
	`;

	// Find and remove selected table rows
    $(document).on('click', '#variationModal .delete-row', function(){
        $("#variantTable tbody").find('input[name="record"]').each(function(){
            if($(this).is(":checked")){
              var v_id = $(this).parents("tr").data('id');
              if(v_id){
                $('#variation_fields').append(`
                  <input type="hidden" name="v_dels[]" value="${v_id}">
                `);
              }
              $(this).parents("tr").remove();
            }
        });
        $('#checkall').prop('checked', false);

        if(!($("#variantTable tbody tr").length)) $("#variantTable tbody").html(tr);
    });   

    $(document).on('click', '#variationModal .add-row', function(){
        $("#variantTable tbody").append(tr);
    });

	$(document).on('change', '#variationModal .varient_type', function(){
		if($(this).val() == 'color'){
			$(this).parents('tr').find('.varient_data').prop("disabled", false).trigger('click');
			    $(this).parents('tr').find('.varient_data').colorPicker({
			        customBG: '#222',
			        readOnly: true,
			        init: function(elm, colors) {
			            elm.style.backgroundColor = elm.value;
			            elm.style.color = elm.value;
			        },
			        actionCallback:  function(elm, colors) {
			            $(this.input).css({'color': $('input.color').val()+'!important'});
			        },
			    });
		}else{
			$(this).parents('tr').find('.varient_data').val('').removeAttr('style').prop("disabled", true);
		}
    });

    $(document).on('click', '#variantTable #checkall', function () {
      	var is_checked = $(this).is(":checked");
      	$("#variantTable .checkbox").prop("checked", !is_checked).trigger("click");
    });

});
</script>
@endpush