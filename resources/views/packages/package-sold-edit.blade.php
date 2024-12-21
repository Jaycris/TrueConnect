@extends('layouts.master')
@section('content')
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('pack-sold.index') }}" class="text-primary hover:underline">Edit Package Sold</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit Package Sold</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Edit Package Sold</h5>
            </div>
            <div class="mb-5">
                <form action="{{ route('pack-sold.update', $packSold->id) }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                    @csrf
                    <h6 class="mb-5 text-lg font-bold">Package Sold</h6>
                    <div class="flex flex-col sm:flex-row">
                        <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                            <!-- Input fields here -->
                            <div>
                                <label for="pack_sold_name">Package Sold Name</label>
                                <input id="pack_sold_name" name="pack_sold_name" type="text" placeholder="Enter Package Sold Name" class="form-input" value="{{ $packSold->pack_sold_name }}">
                                @error('name')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label>Select Packages Sold</label>
                                <div>
                                    @foreach($event as $events)
                                        <div>
                                            <label>
                                                <!-- Check if the package is already associated with the package type -->
                                                <input type="checkbox" name="events[]" value="{{ $events->id }}" 
                                                    {{ in_array($events->id, $packSold->event->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                {{ $events->event_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('events')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
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
