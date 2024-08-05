@extends('layouts.master')
@section('content')
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('admin.users') }}" class="text-primary hover:underline">Users</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Add Users</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Add Users</h5>
            </div>
            <div class="mb-5">
                <form action="{{ route('admin.users.post') }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                    @csrf
                    <h6 class="mb-5 text-lg font-bold">User Information</h6>
                    <div class="flex flex-col sm:flex-row">
                        <div class="relative mb-5 w-full sm:w-2/12 ltr:sm:mr-4 rtl:sm:ml-4">
                            <div class="relative mx-auto h-20 w-20 md:h-32 md:w-32">
                                <img id="profileImage" src="{{ asset('assets/images/photo_defaults.png') }}" alt="image" class="rounded-full object-cover w-full h-full">
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 flex items-center justify-center bg-black bg-opacity-50 rounded-full h-8 w-8 cursor-pointer" id="cameraIconOverlay">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M4 5a2 2 0 012-2h1.172a2 2 0 001.414-.586l.828-.828a2 2 0 011.414-.586h3.344a2 2 0 011.414.586l.828.828A2 2 0 0012.828 3H14a2 2 0 012 2v1h1a2 2 0 012 2v7a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h1V5zm3 8a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </div>
                            </div>
                            <input type="file" id="imageUpload" name="avatar" class="hidden imageUpload">
                            @error('avatar')
                                <p class="text-danger 500 italic">{{ $message }}</p>
                            @enderror
                            <div class="text-center mt-4"> <!-- Centering content and adding margin-top -->
                                <label for="eid">Employee ID</label>
                                <span id="eid">{{ $e_id }}</span>
                                <input type="hidden" name="e_id" value="{{ $e_id }}">
                                @error('e_id')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
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
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" class="form-select text-white-dark">
                                    <option>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                @error('gender')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="position">Designation</label>
                                <select id="position" name="position" class="form-select text-white-dark">
                                    <option>Select Designation</option>
                                    @foreach($designations as $key => $designation)
                                    <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                                @error('position')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="department">Department</label>
                                <select id="department" name="department" class="form-select text-white-dark">
                                    <option class="text-white-light">Select Department</option>
                                    @foreach($departments as $key => $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" placeholder="Enter Email Address" class="form-input" value="{{ old('email') }}">
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
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password" placeholder="Enter Password" class="form-input">
                                @error('password')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="confirm_password">Confirm Password</label>
                                <input id="confirm_password" name="password_confirmation" type="password" placeholder="Enter Confirm Password" class="form-input">
                                @error('password_confirmation')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="type">User Type</label>
                                <select id="type" name="user_type" class="form-select text-white-dark">
                                    <option>Select Type</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Employee">Employee</option>
                                </select>
                                @error('user_type')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="status">Status</label>
                                <select id="status" name="user_status" class="form-select text-white-dark">
                                    <option>Select Status</option>
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
<style>
.relative {
    position: relative;
}

#cameraIconOverlay {
    position: absolute;
    bottom: 3%;
    left: 80%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    cursor: pointer;
}

#cameraIconOverlay:hover {
    position: absolute;
    bottom: 3%;
    left: 80%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: #67a3a7;
    border-radius: 50%;
    cursor: pointer;
}

#cameraIconOverlay svg {
    width: 20px;
    height: 20px;
}
</style>
@endsection
