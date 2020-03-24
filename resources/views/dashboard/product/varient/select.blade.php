<tr>
  <td colspan="6">
    <select class="form-control" data-url="{{route('admin.varient.field')}}" id="varient_select">
    <option value="">Select varient</option>
    @foreach($variation->values as $value)
    <option @if($value->type == 'color') style="color: {{$value->data}}" @endif value="{{$value->id}}" ><b>{{$value->name}}</b></option>
    @endforeach
    </select>
  </td>
</tr>