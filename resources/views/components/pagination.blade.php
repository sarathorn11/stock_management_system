<div class="w-full bg-white flex justify-end py-4 px-8 items-center">
  <!-- Items Per Page Dropdown -->
  <div>
    <label for="perPage" class="mr-2 text-gray-700">Items per page:</label>
    <select id="perPage" name="perPage" class="rounded px-5 py-2" onchange="updatePerPage(this.value)">
      @foreach([10, 20, 30, 50] as $option)
      <option value="{{ $option }}" {{ request('perPage') == $option ? 'selected' : '' }}>
        {{ $option }}
      </option>
      @endforeach
    </select>
  </div>

  <!-- Item Range Display -->
  <div class="mx-4">
    @php
    $startItem = ($pagination->currentPage() - 1) * $pagination->perPage() + 1;
    $endItem = min($pagination->currentPage() * $pagination->perPage(), $pagination->total());
    $endItem = $pagination->currentPage() == $pagination->lastPage() ? $pagination->total() : $endItem;
    @endphp
    {{ $startItem }} - {{ $endItem }} of {{ $pagination->total() }}
  </div>

  <!-- Pagination Links -->
  <div class="flex justify-end py-4 items-center">
    <ul class="flex items-center space-x-2">
      <li>
        <a href="{{ $pagination->previousPageUrl() }}" class="px-4 py-2 border rounded {{ $pagination->onFirstPage() ? ' cursor-not-allowed' : '
                 hover:bg-gray-200' }}" {{ $pagination->onFirstPage() ? 'disabled' : '' }}>
          <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
      </li>
      @foreach ($pagination->getUrlRange(1, $pagination->lastPage()) as $page => $url)
      <li>
        <a href="{{ $url }}" class="px-4 py-2 border rounded {{ $pagination->currentPage() == $page ? 'bg-blue-500 text-white' : '
                     hover:bg-gray-200' }}">{{ $page }}</a>
      </li>
      @endforeach
      <li>
        <a href="{{ $pagination->nextPageUrl() }}" class="px-4 py-2 border rounded {{ $pagination->hasMorePages() ? '
                 hover:bg-gray-200' : ' cursor-not-allowed' }}" {{ $pagination->hasMorePages() ? '' : 'disabled' }}>
          <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
      </li>
    </ul>
  </div>
</div>
<script>
function updatePerPage(perPage) {
  const url = new URL(window.location.href);
  url.searchParams.set('perPage', perPage);
  url.searchParams.set('page', 1);
  window.location.href = url.toString();
}
</script>