<form action="{{route('admin.product.variation.update', $variation->slug)}}" method="POST">
@method('PUT')
@csrf
	<div class="modal-header">
		<h5 class="modal-title">Add variation</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body row">
		<div class="col-12">
			<div class="form-group">
        <label for="variation_name">Variation name</label>
          <input type="text" class="form-control" id="variation_name" name="name" placeholder="Variation name" value="{{$variation->name}}" required>
        </div>
    </div>
    <div class="col-12">
      <h3 class="text-center">Variation Values</h3>
			<div id="variation_fields">
		    <table id="variantTable" class="table table-bordered table-striped">
	        <thead>
            <tr>
              <th style="width: 10px;">
                <input type="checkbox" id="checkall">
              </th>
              <th>Name</th>
              <th>Type</th>
              <th>Data</th>
            </tr>
	        </thead>
	        <tbody>
	        @foreach($variation->values as $value)
            <tr data-id="{{$value->id}}">
                <td>
                  <input type="checkbox" class="checkbox" name="record">
                </td>
                <td class="editMe">
                  <input type="text" class="form-control" name="old_names[{{$value->id}}]" value="{{$value->name}}" required>
                </td>
                <td class="editMe">
                  <select class="form-control varient_type" name="old_types[{{$value->id}}]">
                    <option value="normal" @if($value->type == 'normal') selected @endif >Normal</option>
                    <option value="color" @if($value->type == 'color') selected @endif >Color</option>
                  </select>
                </td>
                <td class="editMe" style="width: 100px;">
                @if($value->type == 'color')
                  	<input type="text" class="form-control varient_data color_v" value="{{$value->data}}" name="old_datas[{{$value->id}}]" style="background-color: {{$value->data}};" >
                @else
                	<input type="text" class="form-control varient_data" disabled name="old_datas[{{$value->id}}]" value="">
                @endif
                </td>
            </tr>
            @endforeach
	        </tbody>
		    </table>
		    <div class="row">
	        <div class="col-md-12">
	           <div class="text-right">
	              <a href="javasctipt:void(0)" class="delete-row btn btm-sm btn-danger">Remove <i class="fa fa fa-trash"></i></a>
	              <a href="javasctipt:void(0)" class="add-row btn btm-sm btn-success">Add more <i class="fa fa-plus-circle"></i></a>
	           </div>
	        </div>
		    </div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		<button type="submit" class="btn btn-primary" id="save_varient">Save</button>
	</div>
</form>