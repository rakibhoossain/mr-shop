<div class="preview_single">
	<label class="control-label"for="{{$setting->key}}">{{Str::title(str_replace('_', ' ', $setting->key))}}
		<input type="file" accept=".png, .jpg, .jpeg"id="{{$setting->key}}" class="upload_logo"  data-ratio="2.94" data-size="48x179" style="display: none;">
		<img @if(config('settings.'.$setting->key)) src="{{asset(config('settings.'.$setting->key))}}" @else src="{{asset('img/thumb_icon.png')}}" @endif width="179" height="48">
		<div class="remove_img"><i class="fas fa-trash"></i></div>
		<input type="hidden" name="{{$setting->key}}" class="image_input" value="{{config('settings.'.$setting->key)}}">
	</label>
	<div class="remove_img"><i class="fas fa-trash"></i></div>
</div>