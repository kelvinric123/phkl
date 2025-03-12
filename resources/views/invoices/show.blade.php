<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice Details') }}: {{ $invoice->invoice_number }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('invoices.edit', $invoice) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Edit Invoice
                </a>
                <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Invoice Header -->
                    <div class="flex justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-bold mb-2">INVOICE</h3>
                            <p class="text-gray-600"># {{ $invoice->invoice_number }}</p>
                            <p class="text-gray-600">Date: {{ $invoice->invoice_date->format('M d, Y') }}</p>
                            <p class="text-gray-600">Due Date: {{ $invoice->due_date->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="inline-block px-3 py-1 rounded-full text-sm font-semibold 
                                @if($invoice->status == 'paid') bg-green-100 text-green-800
                                @elseif($invoice->status == 'draft') bg-blue-100 text-blue-800
                                @elseif($invoice->status == 'sent') bg-yellow-100 text-yellow-800
                                @elseif($invoice->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($invoice->status) }}
                            </div>
                            <p class="mt-2 text-gray-600">
                                Payment Mode: <span class="font-semibold">{{ ucfirst($invoice->payment_mode) }}</span>
                            </p>
                            <p class="text-gray-600">
                                Patient Type: <span class="font-semibold">{{ ucfirst($invoice->patient_type) }}</span>
                            </p>
                            @if($invoice->is_foreigner)
                                <p class="mt-1 text-purple-600 font-medium">Foreigner Patient</p>
                            @endif
                            @if($invoice->after_office_hours)
                                <p class="mt-1 text-orange-600 font-medium">After Office Hours</p>
                            @endif
                        </div>
                    </div>

                    <!-- Client & Consultant Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                        <div>
                            <h4 class="text-gray-600 font-semibold mb-2">Patient Information</h4>
                            <p class="font-bold">{{ $invoice->patient->name }}</p>
                            <p>{{ $invoice->patient->email }}</p>
                            <p>{{ $invoice->patient->phone }}</p>
                            <p>{{ $invoice->patient->address }}</p>
                            @if($invoice->patient->medical_record_number)
                                <p class="mt-2">MRN: {{ $invoice->patient->medical_record_number }}</p>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-gray-600 font-semibold mb-2">Consultant Information</h4>
                            <p class="font-bold">{{ $invoice->consultant->title }} {{ $invoice->consultant->name }}</p>
                            <p>{{ $invoice->consultant->email }}</p>
                            <p>{{ $invoice->consultant->phone }}</p>
                            <p>{{ $invoice->consultant->specialty }}</p>
                        </div>
                        <div>
                            <h4 class="text-gray-600 font-semibold mb-2">Anaesthetist Information</h4>
                            @if(isset($invoice->anaesthetist))
                                <p class="font-bold">{{ $invoice->anaesthetist->title }} {{ $invoice->anaesthetist->name }}</p>
                                <p>{{ $invoice->anaesthetist->email }}</p>
                                <p>{{ $invoice->anaesthetist->phone }}</p>
                                <p>{{ $invoice->anaesthetist->specialty }}</p>
                            @else
                                <p class="text-gray-500 italic">No anaesthetist assigned</p>
                            @endif
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <div class="mb-8">
                        <h4 class="text-gray-600 font-semibold mb-4">Invoice Items</h4>
                        <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variation</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Rate (RM)</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total (RM)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($invoice->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ ucfirst(str_replace('_', ' ', $item->service_type)) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->variation ? ucfirst($item->variation) : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                                {{ number_format($item->rate, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                                @if($item->discount_amount > 0)
                                                    {{ number_format($item->discount_amount, 2) }}
                                                    ({{ $item->discount_percent }}%)
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                                {{ number_format($item->rate - $item->discount_amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Invoice Summary -->
                    <div class="flex justify-end mb-8">
                        <div class="w-80">
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">RM {{ number_format($invoice->subtotal, 2) }}</span>
                            </div>
                            @if($invoice->total_discount > 0)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Total Discount:</span>
                                    <span class="font-medium text-red-600">-RM {{ number_format($invoice->total_discount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Tax (10%):</span>
                                <span class="font-medium">RM {{ number_format($invoice->tax, 2) }}</span>
                            </div>
                            @if($invoice->is_foreigner && $invoice->foreigner_surcharge > 0)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Foreigner Surcharge (25%):</span>
                                    <span class="font-medium">RM {{ number_format($invoice->foreigner_surcharge, 2) }}</span>
                                </div>
                            @endif
                            
                            <!-- Fee Breakdown Section -->
                            <div class="mt-3 mb-2 border-t border-b border-gray-200 py-2">
                                <h5 class="font-semibold text-gray-700">Fee Breakdown:</h5>
                            </div>
                            
                            <!-- Surgeon Portion -->
                            <div class="flex justify-between py-2 border-b border-gray-200">
                                <span class="text-gray-600">Surgeon Fee{{ $invoice->anaesthetist_id ? ' (' . number_format(100 - $invoice->anaesthetist_percentage, 2) . '%)' : '' }}:</span>
                                @php
                                    $surgicalItemsTotal = $invoice->items->where('service_type', 'surgical_procedure')
                                        ->sum(function($item) { return $item->rate - $item->discount_amount; });
                                    
                                    // For surgical items, the surgeon gets the portion that isn't allocated to anaesthetist
                                    $surgeonFee = $surgicalItemsTotal;
                                    if ($invoice->anaesthetist_id) {
                                        $anaesthetistFee = $invoice->anaesthetist_fee ?? $invoice->getAnaesthetistFee();
                                        $surgeonFee = $surgicalItemsTotal - $anaesthetistFee;
                                    }
                                    
                                    // Add any non-surgical items fully to the surgeon's fee
                                    $surgeonFee += $invoice->items->where('service_type', '!=', 'surgical_procedure')
                                        ->sum(function($item) { return $item->rate - $item->discount_amount; });
                                @endphp
                                <span class="font-medium">RM {{ number_format($surgeonFee, 2) }}</span>
                            </div>
                            
                            <!-- Anaesthetist Portion -->
                            @if($invoice->anaesthetist_id)
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Anaesthetist Fee ({{ number_format($invoice->anaesthetist_percentage, 2) }}%):</span>
                                    <span class="font-medium">RM {{ number_format($invoice->anaesthetist_fee ?? $invoice->getAnaesthetistFee(), 2) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between py-2 font-bold text-lg">
                                <span>Total:</span>
                                <span>RM {{ number_format($invoice->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($invoice->notes)
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-gray-600 font-semibold mb-2">Notes</h4>
                            <p class="text-sm text-gray-600">{{ $invoice->notes }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-8 flex justify-between items-center">
                        <form class="inline-block" action="{{ route('invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Delete Invoice</button>
                        </form>
                        
                        <div class="flex space-x-2">
                            <a href="#" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                Print Invoice
                            </a>
                            <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Send to Patient
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 