@extends('layouts.master')
@section('content')
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('admin.users') }}" class="text-primary hover:underline">Users</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>View Profile</span>
            </li>
        </ul>
        <div class="pt-5">
        <div class="panel mt-6 pb-24 ">
                    <h6 class="mb-5 text-lg font-bold text-left w-full">Profile</h6>
                        <div class="flex flex-col sm:flex-row justify-center items-center w-full">
                            <div class="relative mb-5 w-full sm:w-2/12 ltr:sm:mr-2 rtl:sm:ml-2 flex justify-center">
                                <div class="relative mx-auto h-20 w-20 md:h-32 md:w-32">
                    <img id="profileImage" src="{{ asset($user->profile->avatar ? 'storage/' . $user->profile->avatar : '') }}" alt="image" class="rounded-full object-cover w-full h-full">
                </div>
            </div>
            <div class="w-full sm:w-1/2 flex flex-col items-center">
                <div class="text-left w-full">
                    <p class="text-sm text-gray-500">{{ $user->profile->e_id }}</p>
                    <h2 class="text-3xl font-bold">{{ $user->profile->fullname() }}</h2>
                    <p class="text-sm text-gray-500"><span>@</span>{{ $user->username }}</p>
                </div>
                <hr class="my-4 w-full">
                <div class="flex flex-col sm:flex-row w-full justify-between items-center">
                    <div class="w-full sm:w-1/2 px-1">
                        <ul class="space-y-4">
                            <li class="flex items-center gap-2">
                                <span class="font-medium text-gray-600">Gender:</span>
                                <span class="text-gray-800">{{ $user->profile->gender }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="font-medium text-gray-600">Designation:</span>
                                <span class="text-gray-800">{{ $user->profile->designation->name }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="font-medium text-gray-600">Department:</span>
                                <span class="text-gray-800">{{ $user->profile->department->name }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="w-full sm:w-1/2 px-4">
                        <ul class="space-y-4">
                            <li class="flex items-center gap-2">
                                <span class="font-medium text-gray-600">Email:</span>
                                <span class="text-gray-800">{{ $user->email }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="font-medium text-gray-600">Type:</span>
                                <span class="text-gray-800">{{ $user->user_type }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="font-medium text-gray-600">Status:</span>
                                <span class="text-gray-800">{{ $user->user_status }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            
    </div>
    <!-- end main content section -->

@endsection