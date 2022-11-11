@section('title')
    Cache Settings
@endsection
<x-app-layout>
    <x-card title="Clear Cache">
        <x-validation-errors class="pb-6 mb-6 border-b" :errors="$errors" />
        <x-session-status class="mb-6" />

        <form action="{{ route('admin.cache.clear') }}" method="POST">
            @csrf
            <div class="flex items-center gap-2 mb-6 mt-4">
                <button class="btn btn-primary" type="submit">
                    Clear cache
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary-alt">
                    Back
                </a>
            </div>
        </form>
    </x-card>
</x-app-layout>
