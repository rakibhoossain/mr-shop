<form action="{{route('admin.product.variation.store')}}" method="POST">
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
              	<input type="text" class="form-control" id="variation_name" name="name" placeholder="Variation name" required>
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