<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Invoice') }}
        </h2>
    </x-slot>

    <style>
        select option:checked {
            background-color: #9f7aea !important;
            color: white !important;
        }
        
        select[name="patient_id"] {
            font-weight: 500;
        }
        
        /* Improved dropdown styling */
        select {
            font-weight: 500;
            color: #4a5568;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        
        /* Custom range slider styling */
        input[type="range"] {
            -webkit-appearance: none;
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            background-image: linear-gradient(#9f7aea, #9f7aea);
            background-repeat: no-repeat;
        }
        
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: #9f7aea;
            cursor: pointer;
            box-shadow: 0 0 2px 0 #555;
            transition: background .3s ease-in-out;
        }
        
        input[type="range"]::-webkit-slider-runnable-track {
            -webkit-appearance: none;
            box-shadow: none;
            border: none;
            background: transparent;
        }
        
        input[type="range"]::-webkit-slider-thumb:hover {
            background: #805ad5;
        }
        
        /* Firefox styles */
        input[type="range"]::-moz-range-track {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
        }
        
        input[type="range"]::-moz-range-thumb {
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: #9f7aea;
            cursor: pointer;
            box-shadow: 0 0 2px 0 #555;
            border: none;
            transition: background .3s ease-in-out;
        }
        
        input[type="range"]::-moz-range-thumb:hover {
            background: #805ad5;
        }
        
        #anaesthetist_percentage_display {
            min-width: 45px;
            text-align: right;
        }
        
        select[name^="items"][name$="[consultant_id]"] {
            border: 2px solid #9f7aea; 
            font-weight: 600;
            color: #4a5568;
            background-color: #f8f6ff;
        }
        
        select[name^="items"][name$="[consultant_id]"]:focus {
            box-shadow: 0 0 0 3px rgba(159, 122, 234, 0.3);
        }
        
        select[name^="items"][name$="[consultant_id]"] option {
            font-weight: 600;
            color: #4a5568;
            padding: 8px;
        }
        
        .invoice-item {
            padding: 12px;
            border-radius: 8px;
            background-color: #f9fafb;
            margin-bottom: 10px;
            border: 1px solid #e5e7eb;
        }
        
        /* Add a nice focus effect for clarity */
        input:focus, select:focus {
            border-color: #9f7aea;
            box-shadow: 0 0 0 3px rgba(159, 122, 234, 0.3);
        }
        
        .procedure-description-container {
            position: relative;
        }
        
        .procedure-suggestions {
            max-height: 200px;
            overflow-y: auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 50;
            position: absolute;
            width: 100%;
            background-color: white;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
        }
        
        .procedure-suggestions div {
            padding: 8px 12px;
            cursor: pointer;
        }
        
        .procedure-suggestions div:hover {
            background-color: rgba(159, 122, 234, 0.1);
        }
        
        /* Highlight description field when in procedure search mode */
        .service-type-procedure .procedure-description-input {
            border-color: #9f7aea;
            background-color: #fcfaff;
        }
        
        .service-type-procedure .procedure-description-input:focus {
            box-shadow: 0 0 0 3px rgba(159, 122, 234, 0.3);
            border-color: #805ad5;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-md p-4">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="mb-4">
                            <label for="patient_mrn" class="block text-sm font-medium text-gray-700">Patient MRN</label>
                            <input type="text" id="patient_mrn" name="patient_mrn" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Enter Patient MRN">
                            <p id="patient_mrn_feedback" class="mt-1 text-xs hidden"></p>
                            <input type="hidden" id="patient_id" name="patient_id" value="">
                        </div>
                        
                        <div class="mb-4">
                            <label for="invoice_number" class="block text-sm font-medium text-gray-700">Session Number</label>
                            <input type="text" name="invoice_number" id="invoice_number" value="PHKL250P01020456" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="mt-1 text-xs text-gray-500">Example format: PHKL250P01020456</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="payment_mode" class="block text-sm font-medium text-gray-700">Payment Mode</label>
                            <select name="payment_mode" id="payment_mode" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                                <option value="">-- Select Payment Mode --</option>
                                <option value="cash">Cash</option>
                                <option value="gl">GL</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="patient_type" class="block text-sm font-medium text-gray-700">Patient Type</label>
                            <select name="patient_type" id="patient_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                                <option value="">-- Select Patient Type --</option>
                                <option value="outpatient">Outpatient</option>
                                <option value="inpatient">Inpatient</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="hidden" name="is_foreigner" value="0">
                                <input type="checkbox" name="is_foreigner" id="is_foreigner" value="1" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="is_foreigner" class="ml-2 block text-sm font-medium text-gray-700">Is a Foreigner (adds 25% to total)</label>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="hidden" name="after_office_hours" value="0">
                                <input type="checkbox" name="after_office_hours" id="after_office_hours" value="1" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                <label for="after_office_hours" class="ml-2 block text-sm font-medium text-gray-700">After Office Hours (adds 50% to consultation rates)</label>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="invoice_date" class="block text-sm font-medium text-gray-700">Invoice Date</label>
                            <input type="date" name="invoice_date" id="invoice_date" value="{{ date('Y-m-d') }}" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        
                        <div class="mb-4">
                            <label for="consultant_id" class="block text-sm font-medium text-gray-700">Consultant</label>
                            <select name="consultant_id" id="consultant_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md" required>
                                <option value="">Select Consultant</option>
                                @foreach($consultants as $consultant)
                                    <option value="{{ $consultant->id }}">{{ $consultant->title }} {{ $consultant->name }} ({{ $consultant->specialty }})</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Invoice Items</h3>
                            
                            <!-- Column headings -->
                            <div class="grid grid-cols-7 gap-4 px-4 py-2 bg-gray-100 rounded-t-md font-semibold text-gray-700 text-sm">
                                <div>Service Type</div>
                                <div>Variation</div>
                                <div class="col-span-2">Description</div>
                                <div>Amount</div>
                                <div>Discount</div>
                                <div></div>
                            </div>
                            
                            <div id="invoice-items">
                                <div class="invoice-item grid grid-cols-7 gap-4 mb-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Service Type</label>
                                        <select name="items[0][service_type]" class="service-type-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                                            <option value="">-- Type --</option>
                                            <option value="service">Service</option>
                                            <option value="minor_procedure">Minor Proc.</option>
                                            <option value="surgical_procedure">Surgical Proc.</option>
                                        </select>
                                    </div>
                                    <div class="variation-field" style="display: none;">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Variation</label>
                                        <select name="items[0][variation]" class="variation-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                                            <option value="">-- Variation --</option>
                                            <option value="new">New</option>
                                            <option value="follow_up">Follow Up</option>
                                        </select>
                                    </div>
                                    <div class="col-span-2 procedure-description-container">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Description</label>
                                        <input type="text" name="items[0][description]" placeholder="Description" class="procedure-description-input block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <div class="procedure-suggestions mt-1 bg-white shadow-lg rounded-md py-1 text-base hidden">
                                            <!-- Suggestions will be inserted here by JavaScript -->
                                        </div>
                                        <input type="hidden" name="items[0][procedure_id]" class="procedure-id-input">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Amount</label>
                                        <input type="number" name="items[0][rate]" placeholder="Amount" min="0" step="0.01" class="rate-input block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <p class="mt-1 text-xs text-gray-500 rate-note" style="display: none;"></p>
                                        <div class="fee-split-info mt-1 text-xs text-gray-500" style="display: none;">
                                            <span class="surgeon-fee"></span><br>
                                            <span class="anaesthetist-fee"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Discount %</label>
                                        <div class="flex items-center">
                                            <input type="range" name="items[0][discount_percent]" min="0" max="100" value="0" class="discount-slider block w-2/3 mr-2">
                                            <span class="discount-value text-sm">0%</span>
                                            <input type="hidden" name="items[0][discount_amount]" value="0" class="discount-amount">
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500 original-amount"></p>
                                    </div>
                                    <div class="flex items-center pt-6">
                                        <button type="button" class="remove-item text-red-600 hover:text-red-900" style="display: none;">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-item" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Add Item
                            </button>
                        </div>
                        
                        <div id="anaesthetist_container" class="mb-4" style="display: none;">
                            <div class="col-span-6 sm:col-span-3 lg:col-span-3">
                                <label for="anaesthetist_id" class="block text-sm font-medium text-gray-700">Anaesthetist (Optional)</label>
                                <select name="anaesthetist_id" id="anaesthetist_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                                    <option value="">No Anaesthetist</option>
                                    @foreach($consultants as $consultant)
                                        <option value="{{ $consultant->id }}">{{ $consultant->title }} {{ $consultant->name }} ({{ $consultant->specialty }})</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div id="anaesthetist_fee_section" class="col-span-6 sm:col-span-3 lg:col-span-3 mt-4" style="display: none;">
                                <label for="anaesthetist_percentage" class="block text-sm font-medium text-gray-700">Anaesthetist Percentage (%)</label>
                                <div class="flex items-center mt-1">
                                    <input type="range" id="anaesthetist_percentage_slider" min="0" max="100" value="40" step="0.01" class="w-2/3 mr-2 accent-purple-600">
                                    <div class="w-1/3 flex space-x-2 items-center">
                                        <input type="number" name="anaesthetist_percentage" id="anaesthetist_percentage" value="40" min="0" max="100" step="0.01" class="block w-full py-1 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                                        <span class="text-sm font-medium" id="anaesthetist_percentage_display">40%</span>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Percentage of the final amount after modifiers (foreigner surcharge and discounts)</p>
                            </div>
                        </div>
                        
                        <!-- Invoice Total Section -->
                        <div class="mb-6 border-t border-gray-200 pt-4">
                            <div class="flex justify-end">
                                <div class="w-1/3">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-700">Subtotal:</span>
                                        <span id="subtotal" class="text-sm font-medium text-gray-900">RM 0.00</span>
                                    </div>
                                    <div id="discount-row" class="flex justify-between mb-2" style="display: none;">
                                        <span class="text-sm font-medium text-gray-700">Total Discounts:</span>
                                        <span id="discount-amount" class="text-sm font-medium text-red-600">RM 0.00</span>
                                    </div>
                                    <div id="foreigner-surcharge-row" class="flex justify-between mb-2" style="display: none;">
                                        <span class="text-sm font-medium text-gray-700">Foreigner Surcharge (25%):</span>
                                        <span id="foreigner-surcharge" class="text-sm font-medium text-purple-600">RM 0.00</span>
                                    </div>
                                    <div class="flex justify-between border-t border-gray-200 pt-2 font-bold">
                                        <span class="text-gray-900">Total:</span>
                                        <span id="total" class="text-gray-900">RM 0.00</span>
                                    </div>
                                    <div id="fee-split-total-row" class="border-t border-gray-200 mt-2 pt-2" style="display: none;">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Fee Distribution:</p>
                                        <div class="flex justify-between text-sm text-gray-600">
                                            <span>Surgeon:</span>
                                            <span id="surgeon-total">RM 0.00</span>
                                        </div>
                                        <div class="flex justify-between text-sm text-gray-600">
                                            <span>Anaesthetist:</span>
                                            <span id="anaesthetist-total">RM 0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 focus:ring-purple-500 focus:border-purple-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <a href="{{ route('invoices.index') }}" class="mr-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Save Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // This will print the route to the console to verify it's correct
        console.log("Search route:", "{{ route('surgical-procedures.search') }}");
        
        document.addEventListener('DOMContentLoaded', function() {
            let itemCount = 1;
            let searchTimeout;
            
            // Patient MRN to patient selection functionality
            const patientMrnInput = document.getElementById('patient_mrn');
            const patientMrnFeedback = document.getElementById('patient_mrn_feedback');
            const patientIdInput = document.getElementById('patient_id');
            
            // Elements for anaesthetist visibility control
            const anaesthetistContainer = document.getElementById('anaesthetist_container');
            const anaesthetistSelect = document.getElementById('anaesthetist_id');
            const anaesthetistFeeSection = document.getElementById('anaesthetist_fee_section');
            
            // Initialize service type variation fields
            initializeServiceTypeHandlers();
            initializeDiscountSliders();
            initializeProcedureAutocomplete();
            
            // Function to add a new invoice item
            function addNewItem() {
                // If there's already an item with no values, don't add another one
                const existingItems = document.querySelectorAll('.invoice-item');
                if (existingItems.length > 0) {
                    // Check if the last item is empty
                    const lastItem = existingItems[existingItems.length - 1];
                    const serviceType = lastItem.querySelector('.service-type-select').value;
                    const rate = lastItem.querySelector('.rate-input').value;
                    
                    // If the last item has values, add a new one by clicking the add button
                    if (serviceType || rate) {
                        document.getElementById('add-item').click();
                    }
                } else {
                    // No items exist, simulate a click on the add button
                    document.getElementById('add-item').click();
                }
            }
            
            // Add initial item if needed
            if (document.querySelectorAll('.invoice-item').length === 0) {
                addNewItem();
            }
            
            // Initialize MRN search functionality (replaces undefined initPatientSearch call)
            patientMrnInput.addEventListener('input', function() {
                const mrnValue = this.value.trim();
                
                // Clear any previous timeout
                clearTimeout(searchTimeout);
                
                if (mrnValue.length > 0) {
                    patientMrnFeedback.textContent = "Searching...";
                    patientMrnFeedback.classList.remove('hidden', 'text-green-500', 'text-red-500');
                    patientMrnFeedback.classList.add('text-gray-500', 'block');
                    
                    // Add debounce - wait 300ms before making the API call
                    searchTimeout = setTimeout(() => {
                        // Make AJAX call to search for patient by MRN
                        fetch(`/patients/search/mrn/${mrnValue}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Store the patient ID in the hidden field
                                    patientIdInput.value = data.patient.id;
                                    
                                    // Show success message
                                    patientMrnFeedback.textContent = `Patient found: ${data.patient.name}`;
                                    patientMrnFeedback.classList.remove('text-gray-500', 'text-red-500', 'hidden');
                                    patientMrnFeedback.classList.add('text-green-500', 'block');
                                } else {
                                    // Clear the patient ID
                                    patientIdInput.value = '';
                                    
                                    // Show error message
                                    patientMrnFeedback.textContent = "Patient not found with this MRN";
                                    patientMrnFeedback.classList.remove('text-gray-500', 'text-green-500', 'hidden');
                                    patientMrnFeedback.classList.add('text-red-500', 'block');
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching patient data:', error);
                                
                                // Clear the patient ID
                                patientIdInput.value = '';
                                
                                // Show error message
                                patientMrnFeedback.textContent = "Error searching for patient";
                                patientMrnFeedback.classList.remove('text-gray-500', 'text-green-500', 'hidden');
                                patientMrnFeedback.classList.add('text-red-500', 'block');
                            });
                    }, 300);
                } else {
                    patientMrnFeedback.classList.add('hidden');
                    patientIdInput.value = '';
                }
            });
            
            // Toggle anaesthetist percentage field visibility based on anaesthetist selection
            anaesthetistSelect.addEventListener('change', function() {
                anaesthetistFeeSection.style.display = this.value ? 'block' : 'none';
                calculateTotals(); // Recalculate totals when anaesthetist changes
            });
            
            // Link the anaesthetist percentage slider with the number input
            const anaesthetistPercentageSlider = document.getElementById('anaesthetist_percentage_slider');
            const anaesthetistPercentageInput = document.getElementById('anaesthetist_percentage');
            const anaesthetistPercentageDisplay = document.getElementById('anaesthetist_percentage_display');
            
            // Update number input when slider changes
            anaesthetistPercentageSlider.addEventListener('input', function() {
                const value = parseFloat(this.value);
                anaesthetistPercentageInput.value = value;
                anaesthetistPercentageDisplay.textContent = value.toFixed(2) + '%';
                
                // Update slider fill
                const percent = value + '%';
                this.style.backgroundSize = `${percent} 100%`;
                
                calculateTotals();
                updateAllFeeSplits();
            });
            
            // Update slider when number input changes
            anaesthetistPercentageInput.addEventListener('input', function() {
                const value = parseFloat(this.value) || 0;
                if (value >= 0 && value <= 100) {
                    anaesthetistPercentageSlider.value = value;
                    anaesthetistPercentageDisplay.textContent = value.toFixed(2) + '%';
                    
                    // Update slider fill
                    const percent = value + '%';
                    anaesthetistPercentageSlider.style.backgroundSize = `${percent} 100%`;
                }
                calculateTotals();
                updateAllFeeSplits();
            });
            
            // Set initial slider fill
            anaesthetistPercentageSlider.style.backgroundSize = '40% 100%';
            
            // Initial check for surgical procedures
            checkForSurgicalProcedures();
            
            // Document-wide click handler for closing suggestion dropdowns 
            document.addEventListener('click', function(e) {
                const suggestions = document.querySelectorAll('.procedure-suggestions');
                suggestions.forEach(container => {
                    // Only process visible suggestion containers
                    if (!container.classList.contains('hidden')) {
                        const descInput = container.closest('.procedure-description-container').querySelector('.procedure-description-input');
                        
                        // If click is outside the input and outside the suggestions container
                        if (!descInput.contains(e.target) && !container.contains(e.target)) {
                            container.classList.add('hidden');
                        }
                    }
                });
            });
            
            // Function to check if any invoice item is a surgical procedure
            function checkForSurgicalProcedures() {
                const hasSurgicalProcedure = Array.from(document.querySelectorAll('.service-type-select')).some(
                    select => select.value === 'surgical_procedure'
                );
                
                // Show or hide anaesthetist container based on whether there are surgical procedures
                anaesthetistContainer.style.display = hasSurgicalProcedure ? 'block' : 'none';
                
                // If we're hiding the anaesthetist container, also clear any selected anaesthetist
                if (!hasSurgicalProcedure && anaesthetistSelect.value) {
                    anaesthetistSelect.value = '';
                    anaesthetistFeeSection.style.display = 'none';
                    calculateTotals(); // Recalculate totals when anaesthetist is removed
                }
                
                return hasSurgicalProcedure;
            }
            
            function initializeServiceTypeHandlers() {
                // Get all service type selects on the page
                document.querySelectorAll('.service-type-select').forEach(select => {
                    // Remove any existing event listeners (important for cloned elements)
                    select.removeEventListener('change', handleServiceTypeChange);
                    // Add event listener
                    select.addEventListener('change', handleServiceTypeChange);
                    // Initialize current state (in case of page reload)
                    handleServiceTypeChange.call(select);
                    
                    // Add listener for checking if we need to show anaesthetist fields
                    select.addEventListener('change', checkForSurgicalProcedures);
                });
            }
            
            function initializeDiscountSliders() {
                document.querySelectorAll('.discount-slider').forEach(slider => {
                    // Remove existing listeners to prevent duplicates
                    slider.removeEventListener('input', handleDiscountChange);
                    // Add listener
                    slider.addEventListener('input', handleDiscountChange);
                });
            }
            
            function handleDiscountChange() {
                const discountPercent = parseInt(this.value);
                const item = this.closest('.invoice-item');
                
                // Update the display value
                item.querySelector('.discount-value').textContent = `${discountPercent}%`;
                
                // Recalculate the item amount with discount
                updateItemWithDiscount(item);
                
                // Update totals
                calculateTotals();
            }
            
            function updateItemWithDiscount(item) {
                const rate = parseFloat(item.querySelector('input[name$="[rate]"]').value) || 0;
                const discountPercent = parseInt(item.querySelector('.discount-slider').value) || 0;
                
                const originalAmount = rate;
                const discountAmount = originalAmount * (discountPercent / 100);
                
                // Store the discount amount in the hidden input
                item.querySelector('.discount-amount').value = discountAmount.toFixed(2);
                
                // Show the original amount if there's a discount
                const originalAmountDisplay = item.querySelector('.original-amount');
                if (discountPercent > 0 && originalAmount > 0) {
                    originalAmountDisplay.textContent = `Original: RM ${originalAmount.toFixed(2)}`;
                    originalAmountDisplay.style.display = 'block';
                } else {
                    originalAmountDisplay.style.display = 'none';
                }
            }
            
            function handleServiceTypeChange() {
                const serviceType = this.value;
                const invoiceItem = this.closest('.invoice-item');
                const variationField = invoiceItem.querySelector('.variation-field');
                const descriptionInput = invoiceItem.querySelector('.procedure-description-input');
                const procedureIdInput = invoiceItem.querySelector('.procedure-id-input');
                const suggestionsContainer = invoiceItem.querySelector('.procedure-suggestions');
                const feeSplitInfo = invoiceItem.querySelector('.fee-split-info');
                
                // Remove any existing service type classes
                invoiceItem.classList.remove('service-type-service', 'service-type-procedure');
                
                // Reset procedure specific fields
                if (descriptionInput) {
                    descriptionInput.value = '';
                    // Make description required only for procedures
                    if (serviceType === 'minor_procedure' || serviceType === 'surgical_procedure') {
                        invoiceItem.classList.add('service-type-procedure');
                        descriptionInput.setAttribute('required', 'required');
                        descriptionInput.placeholder = 'Start typing to search for procedures...';
                        
                        // Make sure the autocomplete attribute is set to off
                        descriptionInput.setAttribute('autocomplete', 'off');
                    } else {
                        descriptionInput.removeAttribute('required');
                        descriptionInput.placeholder = 'Description';
                        
                        if (serviceType === 'service') {
                            invoiceItem.classList.add('service-type-service');
                        }
                    }
                }
                
                if (procedureIdInput) {
                    procedureIdInput.value = '';
                }
                
                // Clear any existing suggestions
                if (suggestionsContainer) {
                    suggestionsContainer.innerHTML = '';
                    suggestionsContainer.classList.add('hidden');
                }
                
                // Hide the fee split information when changing service type
                if (feeSplitInfo) {
                    feeSplitInfo.style.display = 'none';
                }
                
                if (serviceType === 'service') {
                    variationField.style.display = 'block';
                    // Make sure variation is required
                    const variationSelect = variationField.querySelector('select');
                    variationSelect.setAttribute('required', 'required');
                    
                    // Add event listener for variation change
                    variationSelect.removeEventListener('change', updateRateBasedOnVariation);
                    variationSelect.addEventListener('change', updateRateBasedOnVariation);
                } else {
                    variationField.style.display = 'none';
                    // Make variation not required
                    variationField.querySelector('select').removeAttribute('required');
                    // Reset variation value when service type is not 'service'
                    variationField.querySelector('select').value = '';
                    
                    // Reset the rate input field
                    const rateInput = invoiceItem.querySelector('input[name$="[rate]"]');
                    rateInput.value = '';
                    rateInput.readOnly = false;
                    
                    // Hide rate note
                    invoiceItem.querySelector('.rate-note').style.display = 'none';
                }
            }
            
            // Function to update rate based on variation
            function updateRateBasedOnVariation() {
                const variation = this.value;
                const invoiceItem = this.closest('.invoice-item');
                const rateInput = invoiceItem.querySelector('input[name$="[rate]"]');
                const rateNote = invoiceItem.querySelector('.rate-note');
                const isAfterHours = document.getElementById('after_office_hours').checked;
                
                if (variation) {
                    // Set rates based on variation and after hours status
                    let rate = 0;
                    let rateText = '';
                    
                    if (variation === 'new') {
                        rate = isAfterHours ? 352.50 : 235.00;
                        rateText = isAfterHours ? 'New Consultation (After Hours)' : 'New Consultation';
                    } else if (variation === 'follow_up') {
                        rate = isAfterHours ? 157.50 : 105.00;
                        rateText = isAfterHours ? 'Follow-up (After Hours)' : 'Follow-up Consultation';
                    }
                    
                    rateInput.value = rate.toFixed(2);
                    rateInput.readOnly = true;
                    rateNote.textContent = `${rateText}: RM ${rate.toFixed(2)}`;
                    rateNote.style.display = 'block';
                    
                    // Update item with discount
                    updateItemWithDiscount(invoiceItem);
                    
                    // Trigger calculation of totals
                    calculateTotals();
                } else {
                    rateInput.value = '';
                    rateInput.readOnly = false;
                    rateNote.style.display = 'none';
                }
            }
            
            // Add event listener for after hours checkbox
            document.getElementById('after_office_hours').addEventListener('change', function() {
                // Update all rates
                document.querySelectorAll('.variation-select').forEach(select => {
                    if (select.value) {
                        updateRateBasedOnVariation.call(select);
                    }
                });
            });
            
            // Add a new invoice item
            document.getElementById('add-item').addEventListener('click', function() {
                // Get the template from the first item
                const template = document.querySelector('.invoice-item').cloneNode(true);
                
                // Update the indices in the name attributes
                const inputs = template.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.name) {
                        input.name = input.name.replace(/\[\d+\]/, `[${itemCount}]`);
                    }
                });
                
                // Clear the values
                template.querySelectorAll('input[type="text"], input[type="number"], input[type="hidden"]').forEach(input => {
                    input.value = '';
                });
                template.querySelectorAll('select').forEach(select => {
                    select.selectedIndex = 0;
                });
                template.querySelectorAll('.discount-slider').forEach(slider => {
                    slider.value = 0;
                });
                template.querySelectorAll('.discount-value').forEach(value => {
                    value.textContent = '0%';
                });
                template.querySelectorAll('.original-amount').forEach(orig => {
                    orig.textContent = '';
                    orig.style.display = 'none';
                });
                template.querySelectorAll('.rate-note').forEach(note => {
                    note.textContent = '';
                    note.style.display = 'none';
                });
                template.querySelectorAll('.fee-split-info').forEach(info => {
                    info.style.display = 'none';
                });
                template.querySelectorAll('.procedure-suggestions').forEach(suggestions => {
                    suggestions.innerHTML = '';
                    suggestions.classList.add('hidden');
                });
                
                // Show the remove button
                const removeButton = template.querySelector('.remove-item');
                if (removeButton) {
                    removeButton.style.display = 'block';
                }
                
                // Add event listener to remove button
                removeButton.addEventListener('click', function() {
                    template.remove();
                    calculateTotals();
                    checkForSurgicalProcedures(); // Check if we still have surgical procedures
                });
                
                // Add to the invoice items container
                const itemsContainer = document.getElementById('invoice-items');
                itemsContainer.appendChild(template);
                
                // Increment item count
                itemCount++;
                
                // Initialize service type handlers for the new item
                initializeServiceTypeHandlers();
                
                // Initialize discount sliders for the new item
                initializeDiscountSliders();
                
                // Initialize procedure autocomplete for the new item
                initializeProcedureAutocomplete();
                
                // Setup procedure selection for the new item
                setupProcedureSelection(template);
                
                // Update the totals
                calculateTotals();
                
                // Check if we need to show anaesthetist fields
                checkForSurgicalProcedures();
            });
            
            // Handle the first remove button click
            document.querySelector('.remove-item').addEventListener('click', function() {
                if (document.querySelectorAll('.invoice-item').length > 1) {
                    this.closest('.invoice-item').remove();
                    calculateTotals();
                    checkForSurgicalProcedures(); // Check if we still have surgical procedures
                }
            });
            
            // Calculate invoice totals
            function calculateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;
                let surgeonTotal = 0;
                let anaesthetistTotal = 0;
                let hasSurgicalProcedure = false;
                
                // Get the user-defined anaesthetist percentage
                const hasAnaesthetist = document.getElementById('anaesthetist_id').value !== '';
                const anaesthetistPercentage = hasAnaesthetist ? (parseFloat(document.getElementById('anaesthetist_percentage').value) || 40) : 0;
                const surgeonPercentage = 100 - anaesthetistPercentage;
                
                // Calculate from each invoice item
                document.querySelectorAll('.invoice-item').forEach(item => {
                    const rate = parseFloat(item.querySelector('input[name$="[rate]"]').value) || 0;
                    const discountAmount = parseFloat(item.querySelector('.discount-amount').value) || 0;
                    const serviceType = item.querySelector('.service-type-select').value;
                    
                    subtotal += rate - discountAmount;
                    totalDiscount += discountAmount;
                    
                    // Calculate surgeon and anaesthetist split for surgical procedures
                    if (serviceType === 'surgical_procedure' && hasAnaesthetist) {
                        hasSurgicalProcedure = true;
                        
                        // Calculate actual amounts after discount
                        const itemAmount = rate - discountAmount;
                        surgeonTotal += itemAmount * surgeonPercentage / 100;
                        anaesthetistTotal += itemAmount * anaesthetistPercentage / 100;
                        
                        // Update the fee-split info display for this item
                        updateFeeSplit(item);
                    } else {
                        // Non-surgical items go entirely to the surgeon
                        surgeonTotal += rate - discountAmount;
                    }
                });
                
                // Update the subtotal display
                document.getElementById('subtotal').textContent = 'RM ' + subtotal.toFixed(2);
                
                // Add discount row to the summary if there are discounts
                const discountRow = document.getElementById('discount-row');
                if (totalDiscount > 0) {
                    discountRow.style.display = 'flex';
                    document.getElementById('discount-amount').textContent = 'RM ' + totalDiscount.toFixed(2);
                } else {
                    discountRow.style.display = 'none';
                }
                
                // Check if foreigner
                const isForeigner = document.getElementById('is_foreigner').checked;
                const foreignerSurchargeRow = document.getElementById('foreigner-surcharge-row');
                
                let total = subtotal;
                
                if (isForeigner) {
                    // Calculate 25% surcharge
                    const surcharge = subtotal * 0.25;
                    document.getElementById('foreigner-surcharge').textContent = 'RM ' + surcharge.toFixed(2);
                    foreignerSurchargeRow.style.display = 'flex';
                    
                    // Add to total
                    total += surcharge;
                    
                    // Apply surcharge to surgeon and anaesthetist totals proportionally
                    if (hasSurgicalProcedure) {
                        surgeonTotal += surgeonTotal * 0.25;
                        anaesthetistTotal += anaesthetistTotal * 0.25;
                    }
                } else {
                    foreignerSurchargeRow.style.display = 'none';
                }
                
                // Update total
                document.getElementById('total').textContent = 'RM ' + total.toFixed(2);
                
                // Update surgeon and anaesthetist totals if there are surgical procedures
                const feeSplitTotalRow = document.getElementById('fee-split-total-row');
                if (hasSurgicalProcedure && hasAnaesthetist) {
                    document.getElementById('surgeon-total').textContent = 'RM ' + surgeonTotal.toFixed(2);
                    document.getElementById('anaesthetist-total').textContent = 'RM ' + anaesthetistTotal.toFixed(2);
                    feeSplitTotalRow.style.display = 'block';
                } else {
                    feeSplitTotalRow.style.display = 'none';
                }
                
                // Store the total in a hidden field for form submission
                if (!document.getElementById('invoice_total')) {
                    const hiddenTotal = document.createElement('input');
                    hiddenTotal.type = 'hidden';
                    hiddenTotal.id = 'invoice_total';
                    hiddenTotal.name = 'total_amount';
                    hiddenTotal.value = total.toFixed(2);
                    document.querySelector('form').appendChild(hiddenTotal);
                } else {
                    document.getElementById('invoice_total').value = total.toFixed(2);
                }
            }
            
            // Add event listeners for total calculation
            document.getElementById('is_foreigner').addEventListener('change', calculateTotals);
            
            // Add event listeners for rate inputs
            document.addEventListener('input', function(e) {
                if (e.target.matches('input[name$="[rate]"]')) {
                    // Update discount calculation for the item
                    const item = e.target.closest('.invoice-item');
                    if (item) {
                        updateItemWithDiscount(item);
                    }
                    calculateTotals();
                }
            });
            
            // Initial calculation
            calculateTotals();
            
            // Function to initialize procedure autocomplete for each item
            function initializeProcedureAutocomplete() {
                document.querySelectorAll('.invoice-item').forEach(item => {
                    const serviceTypeSelect = item.querySelector('.service-type-select');
                    let descriptionInput = item.querySelector('.procedure-description-input');
                    const suggestionsContainer = item.querySelector('.procedure-suggestions');
                    const procedureIdInput = item.querySelector('.procedure-id-input');
                    const rateInput = item.querySelector('.rate-input');
                    
                    // Skip if any element is missing
                    if (!serviceTypeSelect || !descriptionInput || !suggestionsContainer || !procedureIdInput || !rateInput) {
                        console.error('Missing element for autocomplete', serviceTypeSelect, descriptionInput, suggestionsContainer, procedureIdInput, rateInput);
                        return;
                    }
                    
                    // Set autocomplete attribute to off to prevent browser's built-in autocomplete
                    descriptionInput.setAttribute('autocomplete', 'off');
                    
                    // Add a focus event to help with user interaction
                    descriptionInput.addEventListener('focus', function() {
                        const serviceType = serviceTypeSelect.value;
                        if (serviceType === 'minor_procedure' || serviceType === 'surgical_procedure') {
                            // If there's already some text, trigger the search when field gets focus
                            if (this.value.trim().length >= 2) {
                                // Create and dispatch an input event to trigger the search
                                const inputEvent = new Event('input', { bubbles: true });
                                this.dispatchEvent(inputEvent);
                            }
                        }
                    });
                    
                    // Debounce function to limit API calls
                    let debounceTimer;
                    
                    // Clear existing listeners to prevent duplicates
                    const newDescriptionInput = descriptionInput.cloneNode(true);
                    descriptionInput.parentNode.replaceChild(newDescriptionInput, descriptionInput);
                    descriptionInput = newDescriptionInput;
                    
                    // Re-add the focus event listener after cloning
                    descriptionInput.addEventListener('focus', function() {
                        const serviceType = serviceTypeSelect.value;
                        if (serviceType === 'minor_procedure' || serviceType === 'surgical_procedure') {
                            // If there's already some text, trigger the search when field gets focus
                            if (this.value.trim().length >= 2) {
                                // Create and dispatch an input event to trigger the search
                                const inputEvent = new Event('input', { bubbles: true });
                                this.dispatchEvent(inputEvent);
                            }
                        }
                    });
                    
                    descriptionInput.addEventListener('input', function() {
                        const serviceType = serviceTypeSelect.value;
                        
                        // Only search if service type is minor_procedure or surgical_procedure
                        if (serviceType !== 'minor_procedure' && serviceType !== 'surgical_procedure') {
                            return;
                        }
                        
                        console.log("Description input event triggered for", serviceType);
                        
                        const query = this.value.trim();
                        
                        // Clear existing timer
                        clearTimeout(debounceTimer);
                        
                        // Clear any existing suggestions
                        suggestionsContainer.innerHTML = '';
                        suggestionsContainer.classList.add('hidden');
                        
                        // Set new timer
                        debounceTimer = setTimeout(() => {
                            if (query.length < 2) {
                                return;
                            }
                            
                            console.log("Fetching procedures with query:", query);
                            
                            // Get the procedure type based on service type - must match exactly what's in the database
                            const procedureType = serviceType === 'surgical_procedure' ? 'Surgical' : 'Minor';
                            
                            console.log("Searching for type:", procedureType);
                            
                            // Show loading indicator
                            suggestionsContainer.innerHTML = '<div class="py-2 px-3 text-sm text-gray-700">Searching...</div>';
                            suggestionsContainer.classList.remove('hidden');
                            
                            // Make API call to get suggestions with type filter
                            fetch(`/surgical-procedures/search?query=${encodeURIComponent(query)}&type=${procedureType}`)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log("Received data:", data);
                                    
                                    // Debug the first procedure's charge property if available
                                    if (data.length > 0) {
                                        console.log("First procedure charge:", data[0].charge);
                                        console.log("Charge type:", typeof data[0].charge);
                                    }
                                    
                                    suggestionsContainer.innerHTML = '';
                                    
                                    if (data.length === 0) {
                                        // Show a "no results" message
                                        const noResults = document.createElement('div');
                                        noResults.className = 'py-2 px-3 text-sm text-gray-700 italic';
                                        noResults.textContent = `No ${procedureType} procedures found matching "${query}"`;
                                        suggestionsContainer.appendChild(noResults);
                                        suggestionsContainer.classList.remove('hidden');
                                        return;
                                    }
                                    
                                    // Since we're filtering by type in the API call, we don't need to filter again
                                    console.log(`Found ${data.length} procedures of type ${procedureType}`);
                                    
                                    // Create suggestion items
                                    data.forEach(procedure => {
                                        const div = document.createElement('div');
                                        div.className = 'cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100';
                                        
                                        const nameDiv = document.createElement('div');
                                        nameDiv.className = 'flex items-center';
                                        nameDiv.innerHTML = `<span class="font-medium">${procedure.name}</span>`;
                                        
                                        const codeDiv = document.createElement('div');
                                        codeDiv.className = 'text-xs text-gray-500';
                                        
                                        // Safely handle the charge value - ensure it's a number before using toFixed
                                        let chargeDisplay = 'N/A';
                                        if (procedure.charge !== null && procedure.charge !== undefined) {
                                            // Convert to number if it's a string
                                            const chargeValue = typeof procedure.charge === 'string' 
                                                ? parseFloat(procedure.charge) 
                                                : procedure.charge;
                                                
                                            // Check if it's a valid number before using toFixed
                                            if (!isNaN(chargeValue)) {
                                                chargeDisplay = `RM ${chargeValue.toFixed(2)}`;
                                            }
                                        }
                                        
                                        codeDiv.innerHTML = `Code: ${procedure.code || 'N/A'} | Charge: ${chargeDisplay}`;
                                        
                                        // Add anaesthetist percentage info for surgical procedures
                                        if (procedure.type === 'Surgical' && procedure.anaesthetist_percentage !== undefined) {
                                            const surgeonPercentage = 100 - procedure.anaesthetist_percentage;
                                            codeDiv.innerHTML += ` | Split: ${surgeonPercentage}% / ${procedure.anaesthetist_percentage}%`;
                                        }
                                        
                                        div.appendChild(nameDiv);
                                        div.appendChild(codeDiv);
                                        
                                        div.addEventListener('click', () => {
                                            // Fill the form with selected procedure
                                            descriptionInput.value = procedure.name;
                                            procedureIdInput.value = procedure.id;
                                            
                                            // Safely convert charge to number before using it
                                            if (procedure.charge !== null && procedure.charge !== undefined) {
                                                // Convert to number if it's a string
                                                const chargeValue = typeof procedure.charge === 'string' 
                                                    ? parseFloat(procedure.charge) 
                                                    : procedure.charge;
                                                    
                                                // Only set if it's a valid number
                                                if (!isNaN(chargeValue)) {
                                                    rateInput.value = chargeValue.toFixed(2);
                                                }
                                            }
                                            
                                            // Show fee split info for surgical procedures
                                            const feeSplitInfo = item.querySelector('.fee-split-info');
                                            const surgeonFeeElement = item.querySelector('.surgeon-fee');
                                            const anaesthetistFeeElement = item.querySelector('.anaesthetist-fee');
                                            
                                            if (procedure.type === 'Surgical' && procedure.anaesthetist_percentage !== undefined) {
                                                const anaesthetistPercentage = parseFloat(procedure.anaesthetist_percentage);
                                                const surgeonPercentage = 100 - anaesthetistPercentage;
                                                
                                                // Store the anaesthetist percentage as a data attribute for later use
                                                item.dataset.anaesthetistPercentage = anaesthetistPercentage;
                                                
                                                // Calculate actual amounts
                                                const chargeValue = parseFloat(rateInput.value) || 0;
                                                const surgeonAmount = (chargeValue * surgeonPercentage / 100).toFixed(2);
                                                const anaesthetistAmount = (chargeValue * anaesthetistPercentage / 100).toFixed(2);
                                                
                                                // Display the split info
                                                surgeonFeeElement.textContent = `Surgeon (${surgeonPercentage.toFixed(2)}%): RM ${surgeonAmount}`;
                                                anaesthetistFeeElement.textContent = `Anaesthetist (${anaesthetistPercentage.toFixed(2)}%): RM ${anaesthetistAmount}`;
                                                feeSplitInfo.style.display = 'block';
                                            } else {
                                                feeSplitInfo.style.display = 'none';
                                            }
                                            
                                            // Update calculation
                                            updateItemWithDiscount(item);
                                            calculateTotals();
                                            
                                            // Hide suggestions
                                            suggestionsContainer.classList.add('hidden');
                                        });
                                        
                                        suggestionsContainer.appendChild(div);
                                    });
                                    
                                    // Show suggestions
                                    suggestionsContainer.classList.remove('hidden');
                                })
                                .catch(error => {
                                    console.error('Error fetching procedure suggestions:', error);
                                });
                        }, 300);
                    });
                });
            }

            // Handle procedure selection for each item
            function setupProcedureSelection(item) {
                const serviceTypeSelect = item.querySelector('.service-type-select');
                const variationField = item.querySelector('.variation-field');
                const descriptionInput = item.querySelector('.procedure-description-input');
                const suggestionsContainer = item.querySelector('.procedure-suggestions');
                const rateInput = item.querySelector('.rate-input');
                
                // Add event listener for rate changes to update fee split info
                rateInput.addEventListener('input', function() {
                    updateFeeSplitInfo(item);
                });
                
                // Toggle variation field based on service type
                serviceTypeSelect.addEventListener('change', function() {
                    const serviceType = this.value;
                    
                    // Remove any existing service type classes
                    item.classList.remove('service-type-service', 'service-type-procedure');
                    
                    if (serviceType === 'service') {
                        item.classList.add('service-type-service');
                        variationField.style.display = 'block';
                        descriptionInput.placeholder = 'Description';
                    } else {
                        variationField.style.display = 'none';
                        item.querySelector('.variation-select').value = '';
                        
                        if (serviceType === 'minor_procedure' || serviceType === 'surgical_procedure') {
                            item.classList.add('service-type-procedure');
                            descriptionInput.placeholder = 'Start typing to search for procedures...';
                            
                            // Make sure the autocomplete attribute is set to off
                            descriptionInput.setAttribute('autocomplete', 'off');
                            
                            // Clear any existing suggestions
                            suggestionsContainer.innerHTML = '';
                            suggestionsContainer.classList.add('hidden');
                        } else {
                            descriptionInput.placeholder = 'Description';
                        }
                    }
                });
                
                // Initialize the service type class based on current selection
                const currentServiceType = serviceTypeSelect.value;
                if (currentServiceType === 'service') {
                    item.classList.add('service-type-service');
                } else if (currentServiceType === 'minor_procedure' || currentServiceType === 'surgical_procedure') {
                    item.classList.add('service-type-procedure');
                }
            }
            
            // Setup procedure selection for the default first item
            setupProcedureSelection(document.querySelector('.invoice-item'));

            // Function to update fee split information based on rate
            function updateFeeSplitInfo(item) {
                const serviceTypeSelect = item.querySelector('.service-type-select');
                const procedureIdInput = item.querySelector('.procedure-id-input');
                const rateInput = item.querySelector('.rate-input');
                const feeSplitInfo = item.querySelector('.fee-split-info');
                const surgeonFeeElement = item.querySelector('.surgeon-fee');
                const anaesthetistFeeElement = item.querySelector('.anaesthetist-fee');
                
                // Only proceed if this is a surgical procedure with a valid procedure ID
                if (serviceTypeSelect.value !== 'surgical_procedure' || !procedureIdInput.value) {
                    feeSplitInfo.style.display = 'none';
                    return;
                }
                
                // Get the anaesthetist percentage from the data attribute we set when selecting a procedure
                const anaesthetistPercentage = parseFloat(item.dataset.anaesthetistPercentage || 40);
                const surgeonPercentage = 100 - anaesthetistPercentage;
                
                // Calculate the actual amounts
                const chargeValue = parseFloat(rateInput.value) || 0;
                if (chargeValue <= 0) {
                    feeSplitInfo.style.display = 'none';
                    return;
                }
                
                const surgeonAmount = (chargeValue * surgeonPercentage / 100).toFixed(2);
                const anaesthetistAmount = (chargeValue * anaesthetistPercentage / 100).toFixed(2);
                
                // Update the display
                surgeonFeeElement.textContent = `Surgeon (${surgeonPercentage.toFixed(2)}%): RM ${surgeonAmount}`;
                anaesthetistFeeElement.textContent = `Anaesthetist (${anaesthetistPercentage.toFixed(2)}%): RM ${anaesthetistAmount}`;
                feeSplitInfo.style.display = 'block';
            }
        });
        
        // Function to update all fee splits for surgical procedures
        function updateAllFeeSplits() {
            const items = document.querySelectorAll('.invoice-item');
            items.forEach(item => {
                const serviceType = item.querySelector('.service-type-select').value;
                if (serviceType === 'surgical_procedure') {
                    updateFeeSplit(item);
                }
            });
        }
        
        // Function to update fee split display for a single item
        function updateFeeSplit(item) {
            const feeSplitInfo = item.querySelector('.fee-split-info');
            const surgeonFeeElement = item.querySelector('.surgeon-fee');
            const anaesthetistFeeElement = item.querySelector('.anaesthetist-fee');
            const rateInput = item.querySelector('.rate-input');
            const discountSlider = item.querySelector('.discount-slider');
            
            // Only show fee split for surgical procedures when an anaesthetist is selected
            const anaesthetistSelected = document.getElementById('anaesthetist_id').value !== '';
            
            if (anaesthetistSelected) {
                // Get the user-defined anaesthetist percentage from our form
                const anaesthetistPercentage = parseFloat(document.getElementById('anaesthetist_percentage').value) || 40;
                const surgeonPercentage = 100 - anaesthetistPercentage;
                
                // Calculate amounts based on rate minus discount
                const rate = parseFloat(rateInput.value) || 0;
                const discountPercent = parseFloat(discountSlider.value) || 0;
                const discountAmount = (rate * discountPercent / 100);
                const netAmount = rate - discountAmount;
                
                const surgeonAmount = (netAmount * surgeonPercentage / 100).toFixed(2);
                const anaesthetistAmount = (netAmount * anaesthetistPercentage / 100).toFixed(2);
                
                // Display the split info
                surgeonFeeElement.textContent = `Surgeon (${surgeonPercentage.toFixed(2)}%): RM ${surgeonAmount}`;
                anaesthetistFeeElement.textContent = `Anaesthetist (${anaesthetistPercentage.toFixed(2)}%): RM ${anaesthetistAmount}`;
                feeSplitInfo.style.display = 'block';
            } else {
                feeSplitInfo.style.display = 'none';
            }
        }
    </script>
</x-app-layout>