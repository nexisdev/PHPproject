<x-app-layout>
    <h1 class="mb-4 text-2xl text-center lg:text-4xl text-primary-700">
        {{ __('translation::translation.languages') }}
    </h1>
    <h4 class="mb-10 text-center text-gray-500 dark:text-gray-200 lg:text-lg">
        {{ __('admin.translations_description') }}
    </h4>
    <x-card>
        @if (count($languages))
            <div class="flex items-center justify-end flex-grow">
                <a href="{{ route('languages.create') }}" class="btn btn-primary">
                    {{ __('translation::translation.add') }}
                </a>
            </div>

            <div class="relative mt-4 overflow-x-auto sm:rounded-lg">
                @php
                    $headers = [__('translation::translation.language_name'), __('translation::translation.locale'), 'Edit'];
                @endphp
                <x-table class="min-h-[calc(100vh-270px)]" :headers="$headers">
                    @foreach ($languages as $language => $name)
                        <tr class="bg-white dark:bg-slate-900 border-b hover:bg-gray-50">
                            <th class="px-6 py-4">
                                {{ $name }}
                            </th>
                            <td class="px-6 py-4">
                                <a href="{{ route('languages.translations.index', $language) }}">
                                    {{ $language }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('languages.translations.index', $language) }}" target="_blank"
                                    class="btn btn-secondary">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>
        @endif
    </x-card>
</x-app-layout>
