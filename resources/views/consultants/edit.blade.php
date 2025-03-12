<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Consultant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('consultants.update', $consultant) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <select id="title" name="title" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">-- Select a title --</option>
                                <option value="Dr." {{ $consultant->title == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                <option value="Prof." {{ $consultant->title == 'Prof.' ? 'selected' : '' }}>Prof.</option>
                                <option value="Mr." {{ $consultant->title == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                <option value="Mrs." {{ $consultant->title == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                <option value="Ms." {{ $consultant->title == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ $consultant->name }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="text-xs text-gray-500 mt-1">Example: Ahmad bin Abdullah, Nurul binti Hassan, Wong Mei Lin, Rajesh a/l Kumar</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="specialty_id" class="block text-sm font-medium text-gray-700">Specialty</label>
                            <select id="specialty_id" name="specialty_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">-- Select a specialty --</option>
                                @foreach($specialties as $specialty)
                                    <option value="{{ $specialty->id }}" {{ $consultant->specialty_id == $specialty->id ? 'selected' : '' }}>{{ $specialty->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ $consultant->email }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ $consultant->phone }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="text-xs text-gray-500 mt-1">Example: +60 12-345 6789</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="hourly_rate" class="block text-sm font-medium text-gray-700">Hourly Rate (RM)</label>
                            <input type="number" name="hourly_rate" id="hourly_rate" step="0.01" min="0" value="{{ $consultant->hourly_rate }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $consultant->notes }}</textarea>
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <a href="{{ route('consultants.index') }}" class="mr-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Consultant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 