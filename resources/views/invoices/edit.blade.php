<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Invoice') }}: {{ $invoice->invoice_number }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('invoices.show', $invoice) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    View Invoice
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
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('invoices.update', $invoice) }}" method="POST" id="invoiceForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Invoice Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h3 class="text-lg font-medium mb-4">Invoice Information</h3>
                                
                                <div class="mb-4">
                                    <label for="invoice_number" class="block text-sm font-medium text-gray-700">Invoice Number</label>
                                    <input type="text" name="invoice_number" id="invoice_number" value="{{ $invoice->invoice_number }}" readonly
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm text-gray-700">
                                    <p class="text-xs text-gray-500 mt-1">Invoice number cannot be changed</p>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="invoice_date" class="block text-sm font-medium text-gray-700">Invoice Date</label>
                                    <input type="date" name="invoice_date" id="invoice_date" value="{{ $invoice->invoice_date->format('Y-m-d') }}"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                                    <input type="date" name="due_date" id="due_date" value="{{ $invoice->due_date->format('Y-m-d') }}"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="payment_mode" class="block text-sm font-medium text-gray-700">Payment Mode</label>
                                    <select name="payment_mode" id="payment_mode" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="cash" {{ $invoice->payment_mode == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="gl" {{ $invoice->payment_mode == 'gl' ? 'selected' : '' }}>GL</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="patient_type" class="block text-sm font-medium text-gray-700">Patient Type</label>
                                    <select name="patient_type" id="patient_type" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="outpatient" {{ $invoice->patient_type == 'outpatient' ? 'selected' : '' }}>Outpatient</option>
                                        <option value="inpatient" {{ $invoice->patient_type == 'inpatient' ? 'selected' : '' }}>Inpatient</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="draft" {{ $invoice->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="sent" {{ $invoice->status == 'sent' ? 'selected' : '' }}>Sent</option>
                                        <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium mb-4">Additional Information</h3>
                                
                                <div class="mb-4">
                                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                                    <select name="patient_id" id="patient_id" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ $invoice->patient_id == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name }} ({{ $patient->medical_record_number ?? 'No MRN' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="consultant_id" class="block text-sm font-medium text-gray-700">Consultant</label>
                                    <select name="consultant_id" id="consultant_id" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        @foreach($consultants as $consultant)
                                            <option value="{{ $consultant->id }}" {{ $invoice->consultant_id == $consultant->id ? 'selected' : '' }}>
                                                {{ $consultant->title }} {{ $consultant->name }} ({{ $consultant->specialty }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="anaesthetist_id" class="block text-sm font-medium text-gray-700">Anaesthetist</label>
                                    <select name="anaesthetist_id" id="anaesthetist_id" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">-- No Anaesthetist --</option>
                                        @foreach($consultants as $consultant)
                                            <option value="{{ $consultant->id }}" {{ isset($invoice->anaesthetist_id) && $invoice->anaesthetist_id == $consultant->id ? 'selected' : '' }}>
                                                {{ $consultant->title }} {{ $consultant->name }} ({{ $consultant->specialty }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea name="notes" id="notes" rows="4" 
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ $invoice->notes }}</textarea>
                                </div>
                                
                                <div class="mb-4 flex space-x-6">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_foreigner" id="is_foreigner" value="1" 
                                            {{ $invoice->is_foreigner ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="is_foreigner" class="ml-2 block text-sm text-gray-700">Foreigner Patient</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input type="checkbox" name="after_office_hours" id="after_office_hours" value="1" 
                                            {{ $invoice->after_office_hours ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="after_office_hours" class="ml-2 block text-sm text-gray-700">After Office Hours</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Invoice Items -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Invoice Items</h3>
                            
                            <div id="invoice-items" class="space-y-4">
                                @foreach($invoice->items as $index => $item)
                                    <div class="invoice-item border border-gray-200 rounded-md p-4 relative">
                                        <button type="button" class="remove-item absolute top-2 right-2 text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Service Type</label>
                                                <select name="items[{{ $index }}][service_type]" class="service-type mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                                                    <option value="service" {{ $item->service_type == 'service' ? 'selected' : '' }}>Service</option>
                                                    <option value="minor_procedure" {{ $item->service_type == 'minor_procedure' ? 'selected' : '' }}>Minor Procedure</option>
                                                    <option value="surgical_procedure" {{ $item->service_type == 'surgical_procedure' ? 'selected' : '' }}>Surgical Procedure</option>
                                                </select>
                                            </div>
                                            
                                            <div class="variation-field" style="{{ $item->service_type != 'service' ? 'display: none;' : '' }}">
                                                <label class="block text-sm font-medium text-gray-700">Variation</label>
                                                <select name="items[{{ $index }}][variation]" class="variation mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                                                    <option value="new" {{ $item->variation == 'new' ? 'selected' : '' }}>New</option>
                                                    <option value="follow_up" {{ $item->variation == 'follow_up' ? 'selected' : '' }}>Follow Up</option>
                                                </select>
                                            </div>
                                            
                                            <div class="description-field" style="{{ $item->service_type == 'service' ? 'display: none;' : '' }}">
                                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                                <input type="text" name="items[{{ $index }}][description]" value="{{ $item->description }}" 
                                                    class="description mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Rate (RM)</label>
                                                <input type="number" name="items[{{ $index }}][rate]" value="{{ $item->rate }}" step="0.01" min="0" 
                                                    class="rate mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Discount (%)</label>
                                                <input type="number" name="items[{{ $index }}][discount_percent]" value="{{ $item->discount_percent }}" 
                                                    class="discount-percent mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm" 
                                                    step="0.01" min="0" max="100">
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Discount Amount (RM)</label>
                                                <input type="number" name="items[{{ $index }}][discount_amount]" value="{{ $item->discount_amount }}" 
                                                    class="discount-amount mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm" 
                                                    step="0.01" min="0">
                                            </div>
                                            
                                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <button type="button" id="add-item" class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                Add Item
                            </button>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                                Update Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Template for new items -->
    <template id="item-template">
        <div class="invoice-item border border-gray-200 rounded-md p-4 relative">
            <button type="button" class="remove-item absolute top-2 right-2 text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Service Type</label>
                    <select name="items[INDEX][service_type]" class="service-type mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                        <option value="service">Service</option>
                        <option value="minor_procedure">Minor Procedure</option>
                        <option value="surgical_procedure">Surgical Procedure</option>
                    </select>
                </div>
                
                <div class="variation-field">
                    <label class="block text-sm font-medium text-gray-700">Variation</label>
                    <select name="items[INDEX][variation]" class="variation mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                        <option value="new">New</option>
                        <option value="follow_up">Follow Up</option>
                    </select>
                </div>
                
                <div class="description-field" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <input type="text" name="items[INDEX][description]" class="description mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rate (RM)</label>
                    <input type="number" name="items[INDEX][rate]" value="0" step="0.01" min="0" 
                        class="rate mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount (%)</label>
                    <input type="number" name="items[INDEX][discount_percent]" value="0" 
                        class="discount-percent mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm" 
                        step="0.01" min="0" max="100">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Discount Amount (RM)</label>
                    <input type="number" name="items[INDEX][discount_amount]" value="0" 
                        class="discount-amount mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm" 
                        step="0.01" min="0">
                </div>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const invoiceItems = document.getElementById('invoice-items');
            const addItemButton = document.getElementById('add-item');
            const itemTemplate = document.getElementById('item-template');
            
            // Add new item
            addItemButton.addEventListener('click', function() {
                let newIndex = document.querySelectorAll('.invoice-item').length;
                let template = itemTemplate.innerHTML;
                template = template.replace(/INDEX/g, newIndex);
                
                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = template;
                let newItem = tempDiv.firstElementChild;
                
                invoiceItems.appendChild(newItem);
                setupItemEventListeners(newItem);
            });
            
            // Remove item
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-item')) {
                    const item = e.target.closest('.invoice-item');
                    if (item) item.remove();
                }
            });
            
            // Setup existing items' event listeners
            document.querySelectorAll('.invoice-item').forEach(item => {
                setupItemEventListeners(item);
            });
            
            // Function to setup event listeners for an item
            function setupItemEventListeners(item) {
                const serviceType = item.querySelector('.service-type');
                const variationField = item.querySelector('.variation-field');
                const descriptionField = item.querySelector('.description-field');
                const variationSelect = item.querySelector('.variation');
                const rateInput = item.querySelector('.rate');
                const discountPercentInput = item.querySelector('.discount-percent');
                const discountAmountInput = item.querySelector('.discount-amount');
                
                // Toggle fields based on service type
                serviceType.addEventListener('change', function() {
                    if (this.value === 'service') {
                        variationField.style.display = '';
                        descriptionField.style.display = 'none';
                        
                        // Set rate based on variation
                        if (variationSelect.value === 'new') {
                            rateInput.value = '200';
                        } else {
                            rateInput.value = '100';
                        }
                    } else {
                        variationField.style.display = 'none';
                        descriptionField.style.display = '';
                        
                        // Suggested rates
                        if (this.value === 'minor_procedure') {
                            rateInput.value = '500';
                        } else {
                            rateInput.value = '2000';
                        }
                    }
                    
                    // Update discount amount when rate changes
                    updateDiscountAmount(discountPercentInput, rateInput, discountAmountInput);
                });
                
                // Set rate when variation changes
                if (variationSelect) {
                    variationSelect.addEventListener('change', function() {
                        if (serviceType.value === 'service') {
                            if (this.value === 'new') {
                                rateInput.value = '200';
                            } else {
                                rateInput.value = '100';
                            }
                            
                            // Update discount amount
                            updateDiscountAmount(discountPercentInput, rateInput, discountAmountInput);
                        }
                    });
                }
                
                // Calculate discount amount when percentage changes
                discountPercentInput.addEventListener('input', function() {
                    updateDiscountAmount(this, rateInput, discountAmountInput);
                });
                
                // Calculate discount percentage when amount changes
                discountAmountInput.addEventListener('input', function() {
                    const rate = parseFloat(rateInput.value) || 0;
                    if (rate > 0) {
                        const amount = parseFloat(this.value) || 0;
                        const percent = (amount / rate) * 100;
                        discountPercentInput.value = percent.toFixed(2);
                    }
                });
            }
            
            // Helper function to update discount amount
            function updateDiscountAmount(percentInput, rateInput, amountInput) {
                const percent = parseFloat(percentInput.value) || 0;
                const rate = parseFloat(rateInput.value) || 0;
                const amount = (rate * percent) / 100;
                amountInput.value = amount.toFixed(2);
            }
        });
    </script>
</x-app-layout> 