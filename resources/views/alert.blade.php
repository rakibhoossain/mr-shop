@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
  toastr.options = {
  "positionClass": "toast-bottom-right",
  }
  @if ($message = Session::get('success'))
    toastr.success("{{ $message }}");
  @endif

  @if(count($errors) > 0)
      @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}");
      @endforeach
  @endif

  @if (session('status'))
    toastr.info("{{ session('status') }}");
  @endif

  @if (session('error'))
    toastr.error("{{ session('error') }}");
  @endif
  @if (session('info'))
    toastr.info("{{ session('info') }}");
  @endif
  @if (session('warning'))
    toastr.warning("{{ session('warning') }}");
  @endif
});
</script>
 @endpush