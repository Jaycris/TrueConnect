@extends('layouts.master')
@section('content')
    <div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('events.index') }}" class="text-primary hover:underline">Sales</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit Sales</span>
        </li>
    </ul>
        <div class="pt-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Edit Sales Information</h5>
            </div>
            <div class="mb-5">
                <form action="" method="POST" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                    @csrf
                    <div class="mb-5"></div>
                    <div class="flex flex-col sm:flex-row">
                        <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                            <!-- Input fields here -->
                            <div>
                                <label for="firstname">First Name</label>
                                <input id="firstname" name="first_name" type="text" placeholder="Enter First Name" class="form-input" value="{{ old('first_name') }}">
                                @error('first_name')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="middlename">Middle Name</label>
                                <input id="middlename" name="middle_name" type="text" placeholder="Enter Middle Name" class="form-input" value="{{ old('middle_name') }}">
                                @error('middle_name')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="lastname">Last Name</label>
                                <input id="lastname" name="last_name" type="text" placeholder="Enter Last Name" class="form-input" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" placeholder="Enter Email" class="form-input" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="username">Username</label>
                                <input id="username" name="username" type="text" placeholder="Enter Username" class="form-input" value="{{ old('username') }}">
                                @error('username')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="user_type">User Type</label>
                                <select id="user_type" name="user_type" class="form-select text-white-dark">
                                    <option>Select User Type...</option>
                                    <option value="User">User</option>
                                    <option value="Management">Management</option>
                                </select>
                                @error('user_type')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password">Change Password</label>
                                <input id="new_password" name="new_password" type="new_password" placeholder="Enter New Password" class="form-input">
                                @error('new_password')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="confirm_new_password">Confirm New Password</label>
                                <input id="confirm_new_password" name="confirm_new_password" type="password" placeholder="Enter Password" class="form-input">
                                @error('confirm_new_password')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="status">Status</label>
                                <select id="status" name="user_status" class="form-select text-white-dark">
                                    <option>Select Status...</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                @error('user_status')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
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

@section('styles')
@endsection