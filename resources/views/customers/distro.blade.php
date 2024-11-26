@extends('layouts.master')
@section('content')
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <span>Leads</span>
        </li>
    </ul>
    <div class="pt-5">
        <div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-3 xl:grid-cols-3">
            <div class="panel lead-info">
                <div class="mb-5 flex items-center justify-between">
                    <h5 class="text-lg font-semibold dark:text-white-light">Leads Information</h5>
                    <a id="edit-button" href="#" class="btn btn-primarycolor rounded-full p-2">
                        <svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                            <path opacity="0.5" d="M4 22H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M14.6296 2.92142L13.8881 3.66293L7.07106 10.4799C6.60933 10.9416 6.37846 11.1725 6.17992 11.4271C5.94571 11.7273 5.74491 12.0522 5.58107 12.396C5.44219 12.6874 5.33894 12.9972 5.13245 13.6167L4.25745 16.2417L4.04356 16.8833C3.94194 17.1882 4.02128 17.5243 4.2485 17.7515C4.47573 17.9787 4.81182 18.0581 5.11667 17.9564L5.75834 17.7426L8.38334 16.8675L8.3834 16.8675C9.00284 16.6611 9.31256 16.5578 9.60398 16.4189C9.94775 16.2551 10.2727 16.0543 10.5729 15.8201C10.8275 15.6215 11.0583 15.3907 11.5201 14.929L11.5201 14.9289L18.3371 8.11195L19.0786 7.37044C20.3071 6.14188 20.3071 4.14999 19.0786 2.92142C17.85 1.69286 15.8581 1.69286 14.6296 2.92142Z" stroke="currentColor" stroke-width="1.5"></path>
                            <path opacity="0.5" d="M13.8879 3.66406C13.8879 3.66406 13.9806 5.23976 15.3709 6.63008C16.7613 8.0204 18.337 8.11308 18.337 8.11308M5.75821 17.7437L4.25732 16.2428" stroke="currentColor" stroke-width="1.5"></path>
                        </svg>
                    </a>
                </div>
                <div class="details-container mb-5">
                    <ul class="mt-5 flex max-w-[160px] flex-col space-y-4 font-semibold text-white-dark">
                        <li>No data selected</li>
                    </ul>
                </div>
                <button id="update-status-button" class="btn btn-primarycolor btn-sm hidden">Update Status</button>
            </div>
            <div class="panel lg:col-span-2 xl:col-span-10 ">
                <div class="mb-5">
                    <ul class="flex border-b">
                        <li>
                            <a href="#assigned" class="tab-link py-2 px-4 block text-center dark:text-white-light tab-row">Assigned</a>
                        </li>
                        <li>
                            <a href="#unassigned" class="tab-link py-2 px-4 block text-center dark:text-white-light tab-row">Unassigned</a>
                        </li>
                    </ul>
                </div>
                <div id="assigned" class="tab-content">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Assigned Leads</h5>
                        <!-- <a href="{{ route('customers.create') }}" class="btn btn-primarycolor">Add Leads</a> -->
                    </div>
                    <div class="mb-5">
                        <div class="table-responsive font-semibold text-[#515365] dark:text-white-light">
                            <table id="assign-leads-table" class="whitespace-nowrap">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAllAssign" class="checkAll form-checkbox" /></th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody id="assigned-leads-body" class="dark:text-white-dark">
                                @forelse($assignedCustomers as $customer)
                                    <tr class="customer-row" data-id="{{ $customer->id }}" data-name="{{ $customer->fullName() }}" data-books="{{ $customer->books->toJson() }}" data-contact-numbers="{{ $customer->contactNumbers->toJson() }}" data-employee-id="{{ $customer->assign_to }}" onclick="markAsViewed({{ $customer->id }})">  <!-- Add employee ID here -->                                        
                                        <td>
                                            <input type="checkbox" class="form-checkbox select-lead" /></td> 
                                        <td>
                                        {!! \Carbon\Carbon::parse($customer->date_created)->format('d M, Y') ?? 'N/A' !!}
                                        </td>
                                        <td>{{ $customer->fullName() }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->address }}</td>
                                    </tr>
                                    @empty
                                        <tr id="no-returned-leads">
                                            <td colspan="5">No leads return</td>
                                        </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <hr>
                            <button id="unassign-leads-btn" class="btn btn-primarycolor btn-sm mt-3" data-modal-target="unassign-leads-modal" disabled>Unassign Leads</button>
                        </div>
                    </div>
                </div>

                <div id="unassigned" class="tab-content hidden">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Unassigned Leads</h5>
                    </div>
                    <div class="mb-5">
                        <div class="table-responsive font-semibold text-[#515365] dark:text-white-light">
                            <table id="verified-leads-table" class="whitespace-nowrap">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAllVerified" class="checkAll form-checkbox" /></th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody class="dark:text-white-dark">
                                @forelse($unassignedLeads as $customer)
                                    <tr class="customer-row" data-id="{{ $customer->id }}" data-name="{{ $customer->fullName() }}" data-books="{{ $customer->books->toJson() }}" data-contact-numbers="{{ $customer->contactNumbers->toJson() }}" onclick="markAsViewed({{ $customer->id }})">
                                        <td><input type="checkbox" class="form-checkbox select-lead" /></td> 
                                        <td>
                                        {!! \Carbon\Carbon::parse($customer->date_created)->format('d M, Y') ?? 'N/A' !!}
                                        </td>
                                        <td>{{ $customer->fullName() }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->address }}</td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No leads available</td>
                                        </tr>
                                @endforelse
                            </table>
                            <hr>
                            <button id="assign-leads-btn" class="btn btn-primarycolor btn-sm mt-3" data-modal-target="open-assign-modal" disabled>Assign Leads</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" id="open-status-modal">
            <div class="flex items-center justify-center min-h-screen px-4" @click.self="document.getElementById('open-status-modal').classList.add('hidden')">
                <div class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8 animate__animated animate__fadeIn">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg">Update Contact Status</h5>
                        <button type="button" class="text-white-dark hover:text-dark" @click="document.getElementById('open-status-modal').classList.add('hidden')">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">    
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>                            
                        </button>
                    </div>
                    <div class="p-5">
                        <form id="status-update-form" method="POST" action="{{ route('update.status') }}">
                            @csrf
                            <input type="hidden" id="customer-id" name="customer_id">
                            
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" id="name" name="name" class="form-input mt-1 block w-full" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="books" class="block text-sm font-medium text-gray-700">Books</label>
                                <textarea id="books" name="books" class="form-textarea mt-1 block w-full" readonly></textarea>
                            </div>

                            <div class="form-group">
                                <label for="contact_numbers_container" class="block text-sm font-medium text-gray-700">Contact Numbers</label>
                                <div id="contact_numbers_container">
                                    <!-- Contact numbers will be appended here -->
                                </div>
                            </div>

                            <div class="flex justify-end items-center mt-8">
                                <button type="button" class="btn btn-outline-danger" @click="document.getElementById('open-status-modal').classList.add('hidden')">Cancel</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assign Leads Modal -->
        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" id="open-assign-modal">
            <div class="flex items-center justify-center min-h-screen px-4" @click.self="document.getElementById('open-assign-modal').classList.add('hidden')">
                <div class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8 animate__animated animate__fadeIn">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg">Assign Leads</h5>
                        <button type="button" class="text-white-dark hover:text-dark" @click="document.getElementById('open-assign-modal').classList.add('hidden')">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="p-5">
                        <form id="assign-leads-form" method="POST" action="{{ route('customers.assignEmployees') }}">
                            @csrf
                            <input type="hidden" id="selected-customer-ids" name="customers[]">

                            <div class="mb-4">
                                <label for="total-selected-leads" class="block text-sm font-medium text-gray-700">Total Leads Selected</label>
                                <input type="text" id="total-selected-leads" name="total_leads" class="form-input mt-1 block w-full" readonly>
                            </div>
                            
                            <div class="mb-4">
                                <label for="employee-select" class="block text-sm font-medium text-gray-700">Assign to</label>
                                <select id="employee-select" name="employees[]" class="form-select text-white-dark">
                                    <option class="text-white-light">Select Branding Specialist</option>
                                    @foreach($brandingSpecialists as $specialist)
                                        @if($specialist->profile)
                                        <option value="{{ $specialist->id }}">{{ $specialist->profile->fullName() }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex justify-end items-center mt-8">
                                <button type="button" class="btn btn-outline-danger" @click="document.getElementById('open-assign-modal').classList.add('hidden')">Cancel</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Assign Leads</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

         <!-- Assign Leads Modal -->
         <!-- <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" id="open-assign-modal">
            <div class="flex items-center justify-center min-h-screen px-4" @click.self="document.getElementById('open-assign-modal').classList.add('hidden')">
                <div class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8 animate__animated animate__fadeIn">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg">Assign Leads</h5>
                        <button type="button" class="text-white-dark hover:text-dark" @click="document.getElementById('open-assign-modal').classList.add('hidden')">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="p-5">
                        <form id="assign-leads-form" method="POST" action="{{ route('customers.assignEmployees') }}">
                            @csrf
                            <input type="hidden" id="selected-customer-ids" name="customers[]">

                            <div class="mb-4">
                                <label for="total-selected-leads" class="block text-sm font-medium text-gray-700">Total Leads Selected</label>
                                <input type="text" id="total-selected-leads" name="total_leads" class="form-input mt-1 block w-full" readonly>
                            </div>
                            
                            <div class="mb-4">
                                <label for="employee-select" class="block text-sm font-medium text-gray-700">Assign to</label>
                                <select id="employee-select" name="employees[]" class="form-select text-white-dark">
                                    <option class="text-white-light">Select Branding Specialist</option>
                                    @foreach($brandingSpecialists as $specialist)
                                        @if($specialist->profile)
                                        <option value="{{ $specialist->id }}">{{ $specialist->profile->fullName() }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex justify-end items-center mt-8">
                                <button type="button" class="btn btn-outline-danger" @click="document.getElementById('open-assign-modal').classList.add('hidden')">Cancel</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Assign Leads</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> -->

        <!--Unassign Modal-->
        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" id="unassign-leads-modal">
            <div class="flex items-center justify-center min-h-screen px-4" 
                @click.self="document.getElementById('unassign-leads-modal').classList.add('hidden')">
                <div class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8 animate__animated animate__fadeIn">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg" id="modalTitle">Confirm Unassign</h5>
                        <button type="button" class="text-white-dark hover:text-dark" 
                                @click="document.getElementById('unassign-leads-modal').classList.add('hidden')">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" 
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" 
                                stroke-linejoin="round">    
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>                            
                        </button>
                    </div>
                    <div class="p-5">
                        <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
                            <p>Are you sure you want to unassign the selected leads?</p>
                        </div>
                        <div class="flex justify-end items-center mt-8">
                            <button type="button" id="cancelButton" class="btn btn-outline-danger" 
                                    @click="document.getElementById('unassign-leads-modal').classList.add('hidden')">
                                Cancel
                            </button>
                            <form id="unassign-leads-form" method="POST" action="{{ route('customers.unassignLeads') }}" class="ltr:ml-4 rtl:mr-4">
                                @csrf
                                <input type="hidden" name="customers[]" id="confirmButton">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reassign Leads Modal -->
        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" id="open-reassign-modal">
            <div class="flex items-center justify-center min-h-screen px-4" @click.self="document.getElementById('open-reassign-modal').classList.add('hidden')">
                <div class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8 animate__animated animate__fadeIn">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg">Reassign Leads</h5>
                        <button type="button" class="text-white-dark hover:text-dark" @click="document.getElementById('open-reassign-modal').classList.add('hidden')">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="p-5">
                    <form id="reassign-leads-form" method="POST" action="{{ route('customers.reassign') }}">
                        @csrf
                        <input type="hidden" id="selected-customer-ids" name="customers[]">
                        
                        <label id="reassign-modal-text">
                            Reassigning <span id="total-selected-leads">0</span> lead(s) to their respective Branding Specialist(s).
                        </label>

                        <div class="flex justify-end items-center mt-8">
                            <button type="button" class="btn btn-outline-danger" @click="document.getElementById('open-reassign-modal').classList.add('hidden')">Cancel</button>
                            <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Assign Leads</button>    
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/polling.js') }}"></script>
    <script>
        // Start polling when the page loads
        window.onload = function() {
            pollForAssignedLeads();  // Start polling for assigned leads for admin
            pollForReturnedLeads();  // Start polling for returned leads for admin
        };
    </script>
@endsection