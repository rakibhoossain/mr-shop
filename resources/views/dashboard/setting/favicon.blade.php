<div class="preview_single">
	<label class="control-label" for="{{$setting->key}}">{{Str::title(str_replace('_', ' ', $setting->key))}}
		<input type="file" accept=".png, .jpg, .jpeg" id="{{$setting->key}}" class="upload_favicon" data-ratio="1" data-size="45x45" style="display: none;">
			<img @if(config('settings.'.$setting->key)) src="{{asset(config('settings.'.$setting->key))}}" @else src="{{asset('img/thumb_icon.png')}}" @endif width="50" height="50">
		<input type="hidden" name="{{$setting->key}}" class="image_input" value="{{ config('settings.'.$setting->key) }}">
	</label>
	<div class="remove_img"><i class="fas fa-trash"></i></div>
</div>