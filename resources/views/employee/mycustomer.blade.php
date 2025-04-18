@extends('layouts.master')
@section('content')
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:void(0);" class="text-primary hover:underline">Leads Management</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>My Leads</span>
         </li>
    </ul>
    <div class="pt-5">
        <div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-3 xl:grid-cols-3">
            <div class="panel lead-info">
                <div class="mb-5 flex items-center justify-between">
                    <h5 class="text-lg font-semibold dark:text-white-light">Lead Information</h5>
                    <a id="edit-button" href="#" class="btn btn-primarycolor rounded-full p-2 ltr:ml-auto rtl:mr-auto">
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
                <button id="update-status-button" class="btn primary-button btn-sm hidden">Update Status</button>
            </div>
            <div class="panel lg:col-span-2 xl:col-span-10">
                <div class="mb-5">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Leads</h5>
                        <!-- <a href="{{ route('sales.create') }}" class="btn primary-button">Endorse Sale</a> -->
                        <a href="#" class="btn primary-button" data-coming-soon>Endorse Sale</a>
                    </div>
                    <div class="table-responsive font-semibold text-[#515365] dark:text-white-light">
                        <table id="my-leads-table" class="whitespace-nowrap">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAllreturn" class="checkAll form-checkbox" /></th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody id="assigned-customers-list" class="dark:text-white-dark">
                            @forelse($assignedCustomers as $customer)
                                <!-- <tr class="customer-row" data-id="{{ $customer->id }}" data-name="{{ $customer->fullName() }}" data-books="{{ $customer->books->toJson() }}" data-contact-numbers="{{ $customer->contactNumbers->toJson() }}" onclick="markAsViewed({{ $customer->id }})"> -->
                                <tr class="customer-row" data-id="{{ $customer->id }}" data-name="{{ $customer->fullName() }}" data-books="{{ $customer->books->toJson() }}" data-contact-numbers="{{ $customer->contactNumbers->toJson() }}">
                                    <td><input type="checkbox" class="form-checkbox select-lead" /></td>  
                                    <td>
                                        {!! \Carbon\Carbon::parse($customer->date_created)->format('d M, Y') ?? 'N/A' !!}
                                    </td>
                                    <td>{{ $customer->fullName() }}
                                        @if (!$customer->is_viewed)
                                            <span class="new-label">New</span>
                                        @endif          
                                    </td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->address }}</td>
                                </tr>
                            @empty
                                <tr id="no-customers-row">
                                    <td colspan="5" class="text-center">No customers assigned</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <hr>
                        <button id="return-leads-btn" class="btn primary-button btn-sm mt-3" data-modal-target="open-return-modal" disabled>Return Leads</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Assign Leads Modal -->
        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" id="open-return-modal">
            <div class="flex items-center justify-center min-h-screen px-4" @click.self="document.getElementById('open-return-modal').classList.add('hidden')">
                <div class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8 animate__animated animate__fadeIn">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg">Return Leads</h5>
                        <button type="button" class="text-white-dark hover:text-dark" @click="document.getElementById('open-return-modal').classList.add('hidden')">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="p-5">
                        <form id="return-leads-form" method="POST" action="{{ route('customers.return') }}">
                            @csrf
                            <!-- This container will hold dynamically created hidden inputs for each selected customer -->
                            <div id="selected-customer-ids"></div>

                            <div class="mb-4">
                                <label for="total-selected-leads" class="block text-sm font-medium text-gray-700">Total Leads Selected</label>
                                <input type="text" id="total-selected-leads" name="total_leads" class="form-input mt-1 block w-full" readonly>
                            </div>

                            <div class="mb-4">
                                <label for="return-reason" class="block text-sm font-medium text-gray-700">Reason for Return</label>
                                <textarea id="return-reason" name="return_reason" class="form-textarea mt-1 block w-full"></textarea>
                            </div>

                            <div class="flex justify-end items-center mt-8">
                                <button type="button" class="btn btn-outline-danger" @click="document.getElementById('open-return-modal').classList.add('hidden')">Cancel</button>
                                <button type="submit" class="btn primary-button ltr:ml-4 rtl:mr-4">Return Leads</button>
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
        // Start polling when the page loads for employee
        window.onload = function() {
            pollForEmployeeAssignedLeads();  // Start polling for assigned leads for employee
        };
    </script>
@endsection