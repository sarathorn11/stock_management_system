@extends('layouts.app')

@section('content')
<form class="w-full h-full" action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="flex justify-between">
    <div class="flex items-center gap-2">
      <h1 class="text-xl font-bold text-gray-800">System Information</h1>
    </div>
    <div class="flex items-center justify-end">
      <button type="submit"
        class="bg-green-500 text-white font-bold px-4 py-[6px] rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        Update
      </button>
    </div>
  </div>

  <!-- Flash Messages -->
  @if(session('success'))
  <div id="successOrFailedMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-6" role="alert">
    <span>{{ session('success') }}</span>
  </div>
  @endif
  @if(session('error'))
  <div id="successOrFailedMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-6" role="alert">
    <span>{{ session('error') }}</span>
  </div>
  @endif

  <div class="w-full h-auto bg-white p-6 my-4">
    <!-- System Name -->
    <div class="mb-6">
      <label for="system_name" class="block text-gray-700 font-medium mb-2">System Name</label>
      <input type="text" id="system_name" name="system_name" value="{{ $setting->system_name ?? '' }}" required
        class="w-full border border-gray-300 rounded-lg h-[36px] p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <!-- System Short Name -->
    <div class="mb-6">
      <label for="system_short_name" class="block text-gray-700 font-medium mb-2">System Short Name</label>
      <input type="text" id="system_short_name" name="system_short_name" value="{{ $setting->system_short_name ?? '' }}"
        required
        class="w-full border border-gray-300 rounded-lg h-[36px] p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <!-- System Logo -->
    <div class="my-6">
      <label for="system_logo" class="block text-gray-700 font-medium mb-2">System Logo:</label>
      <input type="file" id="system_logo" name="system_logo"
        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        onchange="previewImage(event, 'previewLogo')">
      <img id="previewLogo" src="{{ $setting->system_logo ? asset('storage/' . $setting->system_logo) : '' }}"
        alt="Logo" class="w-[300px] rounded-lg my-4 {{ $setting->system_logo ? '' : 'hidden' }}">
    </div>

    <!-- System Cover -->
    <div class="my-6">
      <label for="system_cover" class="block text-gray-700 font-medium mb-2">System Cover:</label>
      <input type="file" id="system_cover" name="system_cover"
        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        onchange="previewImage(event, 'previewCover')">
      <img id="previewCover" src="{{ $setting->system_cover ? asset('storage/' . $setting->system_cover) : '' }}"
        alt="Cover" class="w-[300px] rounded-lg my-4 {{ $setting->system_cover ? '' : 'hidden' }}">
    </div>
  </div>
</form>

<script>
setTimeout(function() {
  var successMessage = document.getElementById('successOrFailedMessage');
  if (successMessage) {
    successMessage.style.display = 'none';
  }
}, 2000);

function previewImage(event, previewId) {
  var reader = new FileReader();
  reader.onload = function() {
    var output = document.getElementById(previewId);
    output.src = reader.result;
    output.classList.remove('hidden');
  };
  if (event.target.files[0]) {
    reader.readAsDataURL(event.target.files[0]);
  }
}
</script>
@endsection