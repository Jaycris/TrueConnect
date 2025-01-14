@extends('layouts.master')
@section('content')
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('events.index') }}" class="text-primary hover:underline">Sales</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>View Sale</span>
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
                        <h2 class="text-3xl font-bold">Sale Information</h2>
                    </div>
                    <hr class="my-4 w-full">
                    <div class="flex flex-col sm:flex-row w-full justify-between items-center">
                        <div class="w-full sm:w-1/2 px-1">
                            <ul class="space-y-4">
                                <li class="flex items-center gap-2">
                                    <p><strong>Transaction ID:</strong> {{ $sale->s_id }}</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Date Sold:</strong> {!! \Carbon\Carbon::parse($sale->date_created)->format('M d, Y') ?? 'N/A' !!}</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Consultant Name:</strong> {{ $sale->consultant }}</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Author Name:</strong> {{ $sale->author_name }}</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Email:</strong> {{ $sale->email }}</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Book Title:</strong> {{ $sale->book_title }}</p>
                                </li>
                                <li class="flex items-center gap-2">
                                    <p><strong>Total Price:</strong> ${{ $sale->total_price }}</p>
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