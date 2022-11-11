@props(['headers', 'data'])
<div {!! $attributes->merge(['class' => 'overflow-x-auto relative sm:rounded-lg']) !!}>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($headers as $head)
                    <th scope="col" class="px-6 py-3">
                        {{ $head }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>

    @if (isset($pagination))
        {{ $pagination }}
    @endif

    {{-- <nav class="flex items-center justify-between pt-4" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-200">Showing <span class="font-semibold text-gray-900 dark:text-white">1-10</span> of
            <span class="font-semibold text-gray-900 dark:text-white">1000</span></span>
        <ul class="inline-flex items-center -space-x-px">
            <li>
                <a href="#"
                    class="block px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg dark:text-gray-200 dark:bg-slate-900 hover:bg-gray-100 hover:text-gray-700">
                    <span class="sr-only">Previous</span>
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </li>
            <li>
                <a href="#"
                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 dark:text-gray-200 dark:bg-slate-900 hover:bg-gray-100 hover:text-gray-700">1</a>
            </li>
            <li>
                <a href="#"
                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 dark:text-gray-200 dark:bg-slate-900 hover:bg-gray-100 hover:text-gray-700">2</a>
            </li>
            <li>
                <a href="#" aria-current="page"
                    class="z-10 px-3 py-2 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">3</a>
            </li>
            <li>
                <a href="#"
                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 dark:text-gray-200 dark:bg-slate-900 hover:bg-gray-100 hover:text-gray-700">...</a>
            </li>
            <li>
                <a href="#"
                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 dark:text-gray-200 dark:bg-slate-900 hover:bg-gray-100 hover:text-gray-700">100</a>
            </li>
            <li>
                <a href="#"
                    class="block px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg dark:text-gray-200 dark:bg-slate-900 hover:bg-gray-100 hover:text-gray-700">
                    <span class="sr-only">Next</span>
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </li>
        </ul>
    </nav> --}}
</div>
