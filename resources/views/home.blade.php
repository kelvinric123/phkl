<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hospital Consultant Invoice System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Hospital Consultant Invoice System</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-indigo-50 p-6 rounded-lg shadow">
                            <h2 class="text-xl font-semibold text-indigo-700">Consultants</h2>
                            <p class="mt-2 text-gray-600">Manage hospital consultants and their specialties.</p>
                            <a href="{{ route('consultants.index') }}" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition inline-block">
                                View Consultants
                            </a>
                        </div>
                        
                        <div class="bg-green-50 p-6 rounded-lg shadow">
                            <h2 class="text-xl font-semibold text-green-700">Patients</h2>
                            <p class="mt-2 text-gray-600">Manage patient records and consultation history.</p>
                            <a href="{{ route('patients.index') }}" class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition inline-block">
                                View Patients
                            </a>
                        </div>
                        
                        <div class="bg-purple-50 p-6 rounded-lg shadow">
                            <h2 class="text-xl font-semibold text-purple-700">Invoices</h2>
                            <p class="mt-2 text-gray-600">Create and manage consultant invoices.</p>
                            <a href="{{ route('invoices.index') }}" class="mt-4 px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition inline-block">
                                Manage Invoices
                            </a>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Invoices</h3>
                        <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Consultant</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">INV-001</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Dr. John Smith</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jane Doe</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$250.00</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ now()->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">INV-002</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Dr. Sarah Johnson</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Mike Brown</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$180.00</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ now()->subDays(2)->format('M d, Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 