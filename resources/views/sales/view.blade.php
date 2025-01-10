@extends('layouts.master')
@section('content')
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('events.index') }}" class="text-primary hover:underline">Sales</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>View Sales</span>
        </li>
    </ul>
    <div class="pt-5">
        <div class="panel mt-6 pb-24 ">
            <h6 class="mb-5 text-lg font-bold text-left w-full">&nbsp;</h6>
            <div class="flex flex-col sm:flex-row justify-center items-center w-full">
                <div class="relative mb-5 w-full sm:w-2/12 ltr:sm:mr-2 rtl:sm:ml-2 flex justify-center">
                    <div class="relative mx-auto h-20 w-20 md:h-32 md:w-32">
                    </div>
                </div>
                <div class="w-full sm:w-1/2 flex flex-col items-center">
                    <div class="text-left w-full">
                        <h2 class="text-3xl font-bold">Sales Information</h2>
                    </div>
                    <hr class="my-4 w-full">
                    <div class="flex flex-col sm:flex-row w-full justify-between items-center">
                        <div class="w-full sm:w-1/2 px-1">
                            <ul class="space-y-4">
                                <li class="flex items-center gap-2">
                                    <p><strong>Name:</strong> Jette</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Email:</strong> email@gmail.com</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Username:</strong> @jette</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>User Type:</strong> User</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Status:</strong>&nbsp;&nbsp;<span class="badge badge-outline-success whitespace-nowrap bg-success-light">Active</span></p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Date added:</strong> Dec 18, 2024</p>
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