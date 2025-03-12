<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Procedure Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">{{ $surgicalProcedure->name }}</h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('surgical-procedures.edit', $surgicalProcedure) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('surgical-procedures.destroy', $surgicalProcedure) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this procedure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-md mb-4">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Code</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surgicalProcedure->code ?? 'Not specified' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surgicalProcedure->type }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Charge</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ number_format($surgicalProcedure->charge, 2) }}</dd>
                                </div>
                                @if($surgicalProcedure->type == 'Surgical')
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fee Distribution</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        Surgeon: {{ number_format(100 - ($surgicalProcedure->anaesthetist_percentage ?? 40), 2) }}% | 
                                        Anaesthetist: {{ number_format($surgicalProcedure->anaesthetist_percentage ?? 40, 2) }}%
                                    </dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $surgicalProcedure->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $surgicalProcedure->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surgicalProcedure->description ?? 'No description available' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surgicalProcedure->created_at->format('F j, Y, g:i a') }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $surgicalProcedure->updated_at->format('F j, Y, g:i a') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('surgical-procedures.index') }}" class="text-blue-600 hover:text-blue-900">
                                &larr; Back to All Procedures
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 