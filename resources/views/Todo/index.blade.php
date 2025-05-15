<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            {{-- Create Button + Flash Message --}}
            <div class="flex justify-between items-center px-6">
                <x-create-button href="{{ route('todo.create') }}">
                    Create Todo
                </x-create-button>
                @if (session('success'))
                    <div class="text-green-600 dark:text-green-400 text-sm font-semibold px-4 py-2">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <>
                                <th scope="col" class="px-6 py-3">Title</th>
                                <th scope="col" class="px-6 py-3 text-center">Category</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                                <th scope="col" class="px-6 py-3 text-center">Action</th>
                            </>
                        </thead>
                        <tbody>
                            @forelse ($todos as $data)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 font-medium text-white whitespace-nowrap group">
                                        <a href="{{ route('todo.edit', $data) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                            {{ $data->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $data->category->title ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center">
                                            @if (!$data->is_done)
                                                <span class="bg-indigo-900 text-blue-400 text-xs font-semibold px-3 py-1 rounded-full">
                                                    Ongoing
                                                </span>
                                            @else
                                                <span class="bg-green-900 text-green-400 text-xs font-semibold px-3 py-1 rounded-full">
                                                    Done
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center items-center space-x-6">
                                            @if (!$data->is_done)
                                                <form action="{{ route('todo.complete', $data) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 dark:text-green-400 hover:underline text-sm">
                                                        Complete
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('todo.uncomplete', $data) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                                        Uncomplete
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('todo.destroy', $data) }}" method="POST">
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
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No todos found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Delete All Completed Task --}}
            @if ($todosCompleted > 1)
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <form action="{{ route('todo.deleteallcompleted') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-primary-button>
                            Delete All Completed Task
                        </x-primary-button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
