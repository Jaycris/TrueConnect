@extends('layouts.master')
@section('content')
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('customers.index') }}" class="text-primary hover:underline">Leads</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit Leads</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Edit Leads</h5>
            </div>
            <div class="mb-5">
                <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                    @csrf
                    <h6 class="mb-5 text-lg font-bold">Leads Information</h6>
                    <div class="flex flex-col sm:flex-row">
                        <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                            <!-- Input fields here -->
                            <div>
                                <label for="firstname">First Name</label>
                                <input id="firstname" name="first_name" type="text" placeholder="Enter First Name" class="form-input" value="{{ $customer->first_name }}">
                                @error('first_name')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="middlename">Middle Name</label>
                                <input id="middlename" name="middle_name" type="text" placeholder="Enter Middle Name" class="form-input" value="{{ $customer->middle_name }}">
                                @error('middle_name')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="lastname">Last Name</label>
                                <input id="lastname" name="last_name" type="text" placeholder="Enter Last Name" class="form-input" value="{{ $customer->last_name }}">
                                @error('last_name')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" placeholder="Enter Email Address" class="form-input" value="{{ $customer->email }}">
                                @error('email')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="website">Website</label>
                                <input id="website" name="website" type="text" placeholder="Enter Website domain" class="form-input" value="{{ $customer->website }}">
                                @error('website')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="address">Address</label>
                                <input id="address" name="address" type="text" placeholder="Enter Address" class="form-input" value="{{ $customer->address }}">
                                @error('address')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="books">Books</label>
                                <div id="books_container">
                                    @foreach($customer->books as $index => $book)
                                    <div class="book-input-group">
                                        <input type="text" name="books[0][title]" class="form-input" placeholder="Enter Book Title" required value="{{ $book->title }}">
                                        <input type="url"  name="books[0][link]" class="form-input" placeholder="Enter Book Link (optional)" value="{{ $book->link }}">
                                    </div>
                                    @endforeach
                                    @error('books.*')
                                        <p class="text-danger italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="button-container-books">
                                    <button type="button" class="btn btn-outline-secondary remove-book" style="display: none;">-</button>
                                    <button type="button" class="btn btn-outline-secondary" id="add_book">+</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact_numbers">Contact Numbers</label>
                                <div id="contact_numbers_container">
                                    @foreach($customer->contactNumbers as $index => $contact)
                                        <div class="contact-input-group flex items-center space-x-2 mb-3">
                                            <input type="text" name="contact_numbers[{{ $index }}][contact_number]" class="form-input flex-1" placeholder="Enter Contact Number" value="{{ $contact->contact_number }}">
                                            <select name="contact_numbers[{{ $index }}][status]" class="form-select text-white-dark w-1/3">
                                                <option value="">Select Status</option>
                                                @foreach ($statuss as $status)
                                                    <option value="{{ $status }}" {{ $contact->status === $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>        
                                        </div>
                                    @endforeach
                                    @error('contact_numbers.*')
                                        <p class="text-danger italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="button-container">
                                    <button type="button" class="btn btn-outline-secondary remove-contact-number" style="display: none;">-</button>
                                    <button type="button" class="btn btn-outline-secondary" id="add_contact_number">+</button>
                                </div>
                            </div>
                            <div class="mt-3 sm:col-span-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
