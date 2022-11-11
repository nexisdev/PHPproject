@section('title')
    Edit {{ $user->name }}
@endsection
<x-app-layout>
    <x-card title="Edit {{ $user->name }}">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <x-validation-errors class="mb-4" />

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <x-input-field name="name" :value="$user->name" required />
                <x-input-field name="email" :value="$user->email" required />
                <x-select name="status" type="select" :options="['active' => 'Active', 'suspended' => 'Suspended']" required :value="$user->status" />
            </div>

            <div class="flex items-center gap-2 my-6">
                <x-button> Update </x-button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary-alt">
                    Back
                </a>
            </div>
        </form>
    </x-card>
</x-app-layout>
