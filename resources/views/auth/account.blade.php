@extends('layouts.app')

@section('content')
<form class="w-full h-full" action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="flex justify-end">
    <button type="submit"
      class="bg-green-500 text-white font-bold px-4 py-[6px] rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
      Update
    </button>
  </div>
  <div class="w-full h-auto bg-white p-6 my-4">
    <!-- First Name -->
    <div class="mb-6">
      <label for="first_name" class="block text-gray-700 font-medium mb-2">First Name</label>
      <input type="text" id="first_name" name="first_name"
        class="w-full border border-gray-300 rounded-lg h-[36px] p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <!-- Last Name -->
    <div class="mb-6">
      <label for="last_name" class="block text-gray-700 font-medium mb-2">Last Name</label>
      <input type="text" id="last_name" name="last_name"
        class="w-full border border-gray-300 rounded-lg h-[36px] p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <!-- Username -->
    <div class="mb-6">
      <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
      <input type="text" id="username" name="username"
        class="w-full border border-gray-300 rounded-lg h-[36px] p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <!-- Password -->
    <div class="mb-6">
      <label for="password" class="block text-gray-700 font-medium mb-2">New Password (Leave blank if not
        changing)</label>
      <input type="password" id="password" name="password" placeholder="New password"
        class="w-full border border-gray-300 rounded-lg h-[36px] p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <!-- Profile Picture -->
    <div class="mb-6">
      <label for="profile_picture" class="block text-gray-700 font-medium mb-2">Profile Picture</label>
      <input type="file" id="profile_picture" name="profile_picture"
        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
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