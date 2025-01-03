@extends('layouts.master')
@section('content')
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('sales.index') }}" class="text-primary hover:underline">Sales</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Sales Endorsement</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Create Endorsement</h5>
            </div>
            <div class="flex items-center justify-between mt-5" id="progress-bar">
                <!-- Step 1 -->
                <div class="flex flex-col items-center">
                    <div id="step-1" class="h-6 w-6 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">
                        1
                    </div>
                    <span class="text-xs mt-2">Step 1</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300 mx-2">
                    <div id="connector-1" class="h-1 bg-primary" style="width: 0%;"></div>
                </div>
                <!-- Step 2 -->
                <div class="flex flex-col items-center">
                    <div id="step-2" class="h-6 w-6 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center text-sm font-bold">
                        2
                    </div>
                    <span class="text-xs mt-2">Step 2</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300 mx-2">
                    <div id="connector-2" class="h-1 bg-gray-300"></div>
                </div>
                <!-- Step 3 -->
                <div class="flex flex-col items-center">
                    <div id="step-3" class="h-6 w-6 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center text-sm font-bold">
                        3
                    </div>
                    <span class="text-xs mt-2">Step 3</span>
                </div>
            </div>
        </div>
        <div class="mt-6"></div> <!-- space -->
            <div class="mb-5">
                <form id="multi-step-form" action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                    @csrf
                    <h6 class="mb-5 text-lg font-bold">Sales Information</h6>
                    <div id="step-content-1" class="step-content">
                        <div class="flex flex-col sm:flex-row">
                            <label for="transaction_ID" class="mt-2">Transaction ID:</label>
                            <h1 class="mb-5 text-2xl font-normal px-2">{{ $s_id }}</h1>
                        </div>    
                        <div class="flex flex-col sm:flex-row">
                            <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                                <!-- Input fields here -->
                                <div>
                                    <label for="date_sold">Date Sold <span class="text-danger">*</span></label>
                                    <input id="date_sold" name="date_sold" type="text" class="form-input" data-date-format="Y-m-d" placeholder="Enter Sold Date"  value="{{ request('date') }}" required>
                                    <p class="text-red-500 text-sm hidden">Select sold date.</p> <!-- Hidden by default -->
                                    @error('date_sold')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="consultantName">Consultant Name <span class="text-danger">*</span></label>
                                    <input id="consultantname" name="consultant_name" type="text" placeholder="Enter Consultant Name" class="form-input" value="{{ $fullName }}" readonly required>
                                    <p class="text-red-500 text-sm hidden">This field is required.</p> <!-- Hidden by default -->
                                    @error('consultant_name')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div style="position: relative;">
                                    <label for="authorsName">Author's Name <span class="text-danger">*</span></label>
                                    <input id="authorsName" name="authors_name" type="text" list="authorsList" placeholder="Enter Author's Name" class="form-input" value="{{ old('authors_name') }}" required>
                                    <p class="text-red-500 text-sm hidden">This field is required.</p> <!-- Hidden by default -->
                                    <div id="authorsSuggestions" class="suggestions-dropdown">
                                        <div id="loadingSpinner" class="loading-spinner"></div>
                                    </div>
                                    @error('authors_name')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select id="gender" name="gender" class="form-select text-dark" required>
                                        <option value="" disabled selected>Select Gender...</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <p class="text-red-500 text-sm hidden">Please select a gender.</p> <!-- Hidden by default -->
                                    @error('gender')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div style="position: relative;">
                                    <label for="BookTitle">Book Title <span class="text-danger">*</span></label>
                                    <input id="BookTitle" name="book_title" type="text" placeholder="Enter Book Title" class="form-input" autocomplete="off" required>
                                    <p class="text-red-500 text-sm hidden">Please select a book</p> <!-- Hidden by default -->
                                    <div id="bookSuggestions" class="suggestions-dropdown">
                                        <div id="loadingSpinner" class="loading-spinner" style="display: none;"></div>
                                    </div>
                                    @error('book_title')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="contactNumber">Contact Number <span class="text-danger">*</span></label>
                                    <input id="contact" name="contact_number" type="contact_number" placeholder="Enter Contact Number" class="form-input" value="{{ old('contact_number') }}" required>
                                    <p class="text-red-500 text-sm hidden">This field is required</p> <!-- Hidden by default -->
                                    @error('contact_number')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input id="email" name="email" type="email" placeholder="Enter Email Address" class="form-input" value="{{ old('email') }}" required>
                                    <p class="text-red-500 text-sm hidden">This field is required</p> <!-- Hidden by default -->
                                    @error('email')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="address">Mailing Address <span class="text-danger">*</span></label>
                                    <input id="address" name="mailing_address" type="text" placeholder="Enter Mailing Address" class="form-input" value="{{ old('website') }}" required>
                                    <p class="text-red-500 text-sm hidden">This field is required</p> <!-- Hidden by default -->
                                    @error('mailing_address')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="step-content-2" class="step-content hidden">
                        <div class="flex flex-col sm:flex-row">
                            <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                                <!-- Package Type Dropdown -->
                                <div>
                                    <label for="packageType">Package Type <span class="text-danger">*</span></label>
                                    <select id="packageType" name="package_type" class="form-select text-white-dark" required>
                                        <option value="" disabled selected>Select Type of Package</option>
                                        @foreach($packageTypes as $packageType)
                                            <option value="{{ $packageType->id }}">{{ $packageType->pack_type_name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-red-500 text-sm hidden">Please select a Type of Package.</p>
                                    @error('package_type')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Package Sold Dropdown -->
                                <div>
                                    <label for="packageSold">Package Sold <span class="text-danger">*</span></label>
                                    <select id="packageSold" name="package_sold" class="form-select text-white-dark" required>
                                        <option value="" disabled selected>Select Sold Package</option>
                                    </select>
                                    <p class="text-red-500 text-sm hidden">Please select a Sold Package.</p>
                                    @error('package_sold')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Event Dropdown -->
                                <div>
                                    <label for="eventLocation">Event Location <span class="text-danger">*</span></label>
                                    <select id="eventLocation" name="event_location[]" class="form-select text-white-dark" multiple required>
                                        <option value="" disabled>Select Event(s)</option>
                                    </select>
                                    @error('event_location')
                                        <p class="text-danger 500 italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 sm:col-span-2 flex button-flex">
                        <button type="button" id="prev-button" class="btn btn-primary" disabled>Previous</button>
                        <button type="button" id="next-button" class="btn btn-primary">Next</button>
                        <button type="submit" id="submit-button" class="btn btn-primary hidden">Endorse</button>
                    </div>
                    <!-- <div class="mt-3 sm:col-span-2">
                        <button type="submit" class="btn btn-primary">Endorse</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div>

    @section('script')
    {{-- date filter js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('#date_sold', {
                dateFormat: "Y-m-d", // Format for yyyy-mm-dd
            });
        });

        $(document).ready(function () {
            // When Package Type changes
            $('#packageType').change(function () {
                const packageTypeId = $(this).val();
                $('#packageSold').html('<option value="" disabled selected>Loading...</option>');

                $.ajax({
                    url: '{{ route("getPackageSoldByType") }}',
                    type: 'POST',
                    data: {
                        pack_type_id: packageTypeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#packageSold').html('<option value="" disabled selected>Select Sold Package</option>');
                        response.forEach(function (item) {
                            $('#packageSold').append(`<option value="${item.id}">${item.pack_sold_name}</option>`);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching package sold data:", error);
                        alert("Failed to fetch package sold data. Please try again.");
                    }
                });
            });

            // When Package Sold changes
            $('#packageSold').change(function () {
                const packageSoldId = $(this).val();            
                $('#eventLocation').html('<option value="" disabled selected>Loading...</option>');

                $.ajax({
                    url: '{{ route("getEventsByPackageSold") }}',
                    type: 'POST',
                    data: {
                        pack_sold_id: packageSoldId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#eventLocation').html('<option value="" disabled>Select Event(s)</option>');
                        response.forEach(function (item) {
                            $('#eventLocation').append(`<option value="${item.id}">${item.event_name}</option>`);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching event data:", error);
                        alert("Failed to fetch events. Please try again.");
                    }
                });
            });
        });
    </script>
    @endsection
@endsection
