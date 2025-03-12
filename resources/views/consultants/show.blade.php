<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Consultant Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-semibold">{{ $consultant->title }} {{ $consultant->name }}</h3>
                        <div>
                            <a href="{{ route('consultants.edit', $consultant) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition mr-2">
                                Edit
                            </a>
                            <form class="inline" action="{{ route('consultants.destroy', $consultant) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this consultant?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Delete</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded shadow-sm">
                            <h4 class="font-semibold text-gray-800 mb-2">Contact Information</h4>
                            <p><span class="text-gray-600">Email:</span> {{ $consultant->email }}</p>
                            <p><span class="text-gray-600">Phone:</span> {{ $consultant->phone }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded shadow-sm">
                            <h4 class="font-semibold text-gray-800 mb-2">Professional Details</h4>
                            <p><span class="text-gray-600">Specialty:</span> {{ $consultant->specialty->name }}</p>
                            <p><span class="text-gray-600">Hourly Rate:</span> RM {{ number_format($consultant->hourly_rate, 2) }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded shadow-sm col-span-1 md:col-span-2">
                            <h4 class="font-semibold text-gray-800 mb-2">Notes</h4>
                            <p>{{ $consultant->notes ?? 'No notes available' }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded shadow-sm col-span-1 md:col-span-2">
                            <h4 class="font-semibold text-gray-800 mb-2">Recent Invoices</h4>
                            @if($consultant->invoices->count() > 0)
                                <ul class="mt-2 divide-y divide-gray-200">
                                    @foreach($consultant->invoices->take(5) as $invoice)
                                        <li class="py-2">
                                            <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-800">
                                                Invoice #{{ $invoice->invoice_number }} - {{ $invoice->created_at->format('d M Y') }}
                                            </a>
                                            <p class="text-sm text-gray-500">
                                                Patient: {{ $invoice->patient->name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Amount: RM {{ number_format($invoice->total_amount, 2) }}
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($consultant->invoices->count() > 5)
                                    <a href="#" class="inline-block mt-2 text-blue-600 hover:text-blue-800">View all invoices</a>
                                @endif
                            @else
                                <p class="text-gray-500">No invoices found for this consultant.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('consultants.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back to Consultant List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 