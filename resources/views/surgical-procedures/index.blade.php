<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Surgical and Minor Procedures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Procedure List</h3>
                        <a href="{{ route('surgical-procedures.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Procedure
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Code
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Charge
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Anaesthetist %
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($procedures as $procedure)
                                    <tr>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            <a href="{{ route('surgical-procedures.show', $procedure) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $procedure->name }}
                                            </a>
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">{{ $procedure->code ?? '-' }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">{{ $procedure->type }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">{{ number_format($procedure->charge, 2) }}</td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            @if($procedure->type == 'Surgical')
                                                {{ number_format($procedure->anaesthetist_percentage ?? 40, 2) }}%
                                                <span class="text-xs text-gray-500">(Surgeon: {{ number_format(100 - ($procedure->anaesthetist_percentage ?? 40), 2) }}%)</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $procedure->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $procedure->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="py-2 px-4 border-b border-gray-200">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('surgical-procedures.edit', $procedure) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                                <form action="{{ route('surgical-procedures.destroy', $procedure) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this procedure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-6 px-4 border-b border-gray-200 text-center text-gray-500">
                                            No procedures found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $procedures->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 