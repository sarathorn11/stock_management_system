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
  <div id="successOrFailedMessage"
    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-6" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
  </div>
  @endif
  @if(session('error'))
  <div id="successOrFailedMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-6"
    role="alert">
    <span class="block sm:inline">{{ session('error') }}</span>
  </div>
  @endif
  <div class="w-full h-auto bg-white p-6 my-4">
    <div class="mb-6">
      <label for="system_name" class="block text-gray-700 font-medium mb-2">System Name</label>
      <input type="text" id="system_name" name="system_name" value="{{ $setting->system_name ?? '' }}" required
        class="w-full border border-gray-300 rounded-lg h-[36px] p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>
    <div class="mb-6">
      <label for="system_short_name" class="block text-gray-700 font-medium mb-2">System Short Name</label>
      <input type="text" id="system_short_name" name="system_short_name" value="{{ $setting->system_short_name ?? '' }}"
        required
        class="w-full border border-gray-300 rounded-lg h-[36px] p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>
    <div class="mb-6">
      <p><strong class="text-gray-600">System Logo:</strong></p>
      <input type="file" id="system_logo" name="system_logo"
        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      <div class="my-4">
        @if($setting && $setting->system_logo && Storage::disk('public')->exists($setting->system_logo))
        <img src="{{ Storage::disk('public')->url($setting->system_logo) }}" alt="Logo" width="100" class="my-4">
        @else
        <span class="text-gray-500">No logo uploaded</span>
        @endif
      </div>
    </div>
    <div class="mb-6">
      <p><strong class="text-gray-600 mb-2">System Cover:</strong></p>
      <input type="file" id="system_cover" name="system_cover"
        class="my-2 w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      <div class="my-4">
        @if($setting && $setting->system_cover && Storage::disk('public')->exists($setting->system_cover))
        <img src="{{ Storage::disk('public')->url($setting->system_cover) }}" alt="Cover" width="100" class="my-4">
        @else
        <span class="text-gray-500">No cover uploaded</span>
        @endif
      </div>
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
</script>
@endsection