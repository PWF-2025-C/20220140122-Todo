<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

            {{-- Search Form + Flash Message (1 baris) --}}
            <div class="px-6 pt-4">
                <div class="flex justify-between items-center flex-wrap gap-2">
                    {{-- Search Form (kiri) --}}
                    <form method="GET" action="{{ route('user.index') }}" class="flex gap-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search by name or email ..."
                            class="px-4 py-2 w-64 rounded-lg border dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        />
                        <button type="submit" class="px-4 py-2 bg-white text-gray-800 rounded-lg border border-gray-300 hover:bg-gray-100">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('user.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                Reset
                            </a>
                        @endif
                    </form>

                    {{-- Flash Message (kanan) --}}
                    @if (session('success'))
                        <div class="text-green-600 dark:text-green-400 text-sm font-semibold">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="relative overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">NAME</th>
                            <th class="px-6 py-3">EMAIL</th>
                            <th class="px-6 py-3">TODO</th>
                            <th class="px-6 py-3">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user as $data)
                            <tr class="border-b odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-white">{{ $data->id }}</td>
                                <td class="px-6 py-4 text-white">{{ $data->name }}</td>
                                <td class="px-6 py-4 text-white">{{ $data->email }}</td>
                                <td class="px-6 py-4 text-white whitespace-nowrap">
                                    {{ $data->todos->count() }}
                                    <span>
                                        (<span class="text-green-400">{{ $data->todos->where('is_done', true)->count() }}</span> /
                                        <span class="text-blue-400">{{ $data->todos->where('is_done', false)->count() }}</span>)
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-white">
                                    <div class="flex space-x-3">
                                        @if ($data->is_admin)
                                            <form action="{{ route('user.removeadmin', $data) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="text-blue-600 dark:text-blue-400 hover:underline">Remove Admin</button>
                                            </form>
                                        @else
                                            <form action="{{ route('user.makeadmin', $data) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="text-red-600 dark:text-red-400 hover:underline">Make Admin</button>
                                            </form>
                                        @endif
                                        {{-- Delete Button --}}
                                        <form action="{{ route('user.destroy', $data) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-400">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end">
                    {{ $user->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>