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