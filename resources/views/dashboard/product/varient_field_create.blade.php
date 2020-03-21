@foreach(App\Variation::latest()->get() as $variation)
<div class="table-responsive varient_table">
  <table class="table table-bordered table-striped table-condensed">
    <thead>
      <tr>
        <th>Variation</th>
        <th class="responsive d-flex justify-content-between align-items-center">Variation Values <a href="#" class="btn btn-danger btn-sm remove_varients">Remove</a></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="varient_title"><b>{{$variation->name}}</b></td>
        <td>
          <table class="table table-bordered table-striped table-condensed-inner">
            <thead>
              <tr>
                <th>Name</th>
                <th>Purchase Price</th>
                <th>Sell Price</th>
                <th>Offer Price</th>
                <th>Image</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($variation->values as $value)
              <tr class="varient_row">
                <td @if($value->type == 'color') style="color: {{$value->data}}" @endif ><input type="hidden" name="variations[{{$variation->id}}][{{$value->id}}]" value="{{$value->id}}"><b>{{$value->name}}</b></td>
                <td><input type="text" name="varient_purchase_prices[{{$variation->id}}][{{$value->id}}]" class="form-control" value=""></td>
                <td><input type="text" name="varient_sell_prices[{{$variation->id}}][{{$value->id}}]" class="form-control" value=""></td>
                <td><input type="text" name="varient_prices[{{$variation->id}}][{{$value->id}}]" class="form-control" value=""></td>
                <td>
                  <label>
                    <input type="file" data-id="{{$value->id}}" class="varient_image_btn">
                  <img src="{{asset('img/thumb_icon.png')}}" id="varient_image_preview_{{$value->id}}" width="50" height="50">
                  </label>

                  <input type="hidden" id="varient_image_{{$value->id}}" name="varient_images[{{$variation->id}}][{{$value->id}}]" class="form-control varient_image_input"></td>
                <td><a href="#" class="btn btn-danger btn-sm remove_varient">Remove</a></td>
              </tr>
              @empty
              <h1>no data</h1>

              @endforelse  
            </tbody>
          </table>
        </td>
      </tr>

    </tbody>
  </table>
</div>
@endforeach