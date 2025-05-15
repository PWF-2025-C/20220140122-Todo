<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Todo') }}
        </h2>
    </x-slot>

    <div class="p-6 text-gray-900 dark:text-gray-100">
        <form method="POST" action="{{ route('todo.update', $todo) }}" class="">
            @csrf
            @method('PATCH')

            <div class="mb-6">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input
                    id="title"
                    name="title"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('title', $todo->title)"
                    required
                    autofocus
                    autocomplete="title"
                />
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
            </div>
            {{-- Category Dropdown --}}
            <div class="mb-6">
                        <x-input-label for="category_id" :value="('Category')" />
                        <select
                            id="category_id"
                            name="category_id"
                            class="block w-full mt-1 rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:ring focus:ring-indigo-500"
                        >
                            <option value="">-- Choose Category --</option>
                            @foreach ($category as $category)
                                <option value="{{ $category->id }}" @if ($category->id == $todo->category_id) selected @endif>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                    </div>'

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <x-cancel-button href="{{ route('todo.index') }}" />
            </div>
        </form>
    </div>
</x-app-layout>
