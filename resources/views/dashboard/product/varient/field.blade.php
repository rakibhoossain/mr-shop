<tr class="varient_row" data-id="{{$value->id}}">
  <td @if($value->type == 'color') style="color: {{$value->data}}" @endif ><input type="hidden" name="variations[{{$value->variation_id}}][{{$value->id}}]" value="{{$value->id}}"><b>{{$value->name}}</b></td>
  <td><input type="text" name="varient_purchase_prices[{{$value->variation_id}}][{{$value->id}}]" class="form-control" value=""></td>
  <td><input type="text" name="varient_sell_prices[{{$value->variation_id}}][{{$value->id}}]" class="form-control" value=""></td>
  <td><input type="text" name="varient_prices[{{$value->variation_id}}][{{$value->id}}]" class="form-control" value=""></td>
  <td><input type="text" name="varient_quantities[{{$value->variation_id}}][{{$value->id}}]" class="form-control" value="0"></td>
  <td>
    <label>
      <input type="file" data-id="{{$value->id}}" class="varient_image_btn">
    <img src="{{asset('img/thumb_icon.png')}}" id="varient_image_preview_{{$value->id}}" width="50" height="50">
    </label>
    <input type="hidden" id="varient_image_{{$value->id}}" name="varient_images[{{$value->variation_id}}][{{$value->id}}]" class="form-control varient_image_input"></td>
  <td><a href="#" class="btn btn-danger btn-sm remove_varient">Remove</a></td>
</tr>