@extends('layouts.master')
@section('content')
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('admin.designations') }}" class="text-primary hover:underline">2FA Recipient</a>
            </li>
        </ul>
        <div class="pt-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Update 2fa Recipient</h5>
            </div>
            <div class="mb-5">
                <form action="{{ route('admin.updateAdmin') }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                    @csrf
                    @method('PUT')
                    <h6 class="mb-5 text-lg font-bold">Recipient Information</h6>
                    <div class="flex flex-col sm:flex-row">
                        <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                            <!-- Input fields here -->
                            <div>
                                <label for="admin_email">Admin for 2FA</label>
                                <select id="admin_email" name="admin_email" class="form-select text-white-dark">
                                    <option>Select Admin for 2FA</option>
                                    @if($admins->isEmpty())
                                        <option value="">No Admins Available</option>
                                    @else
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->email }}" {{ old('admin_email', $selectedAdminEmail) == $admin->email ? 'selected' : '' }}>
                                                {{ $admin->email }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('user_status')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                                @if($selectedAdminEmail)
                                    <p class="mt-2">
                                        <strong>Current Admin Email for 2FA:</strong> {{ $selectedAdminEmail }}
                                    </p>
                                @else
                                    <p>
                                        <strong>Current Admin Email for 2FA:</strong> Not set yet.
                                    </p>
                                @endif
                            </div>
                            <!-- Display current admin email -->
                            <div class="mt-3 sm:col-span-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
