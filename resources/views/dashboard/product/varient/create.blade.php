<div class="table-responsive varient_table">
  <table class="table table-bordered table-striped table-condensed">
    <thead>
      <tr>
        <th>Variation</th>
        <th class="responsive d-flex justify-content-between align-items-center">Variation Values </th>
        <!-- <a href="#" class="btn btn-danger btn-sm remove_varients">Remove</a> -->
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="varient_title">
          <select class="form-control" id="variation_selection"  data-url="{{route('admin.varient.field')}}">
            <option value="">Select</option>
            @foreach(App\Variation::latest()->get() as $variation)
            <option value="{{$variation->id}}">{{$variation->name}}</option>
            @endforeach
          </select>
        </td>
        <td>
          <table class="table table-bordered table-striped table-condensed-inner">
            <thead>
              <tr>
                <th>Name</th>
                <th>Purchase Price</th>
                <th>Sell Price</th>
                <th>Offer Price</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="variation_selection_body">
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</div>