<form id="recordsForm" action="{{ route($route) }}" method="get">
    <input type="hidden" name="page" id="currentPage" value="{{ request('page') }}">
    <div class="inline-block relative w-full">
        <select name="limit" placeholder="Select Number of Records" id="recordsPerPage"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-left inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <option value="10">Select Number of Records</option>
            <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5 Records Per Page</option>
            <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10 Records Per Page</option>
            <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20 Records Per Page</option>
            <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30 Records Per Page</option>
            <option value="40" {{ request('limit') == 40 ? 'selected' : '' }}>40 Records Per Page</option>
            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50 Records Per Page</option>
            <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100 Records Per Page</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">

        </div>
    </div>
</form>
