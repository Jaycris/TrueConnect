@extends('layouts.master')
@section('content')

<div>
<ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('pack-sold.index') }}" class="text-primary hover:underline">Package Sold</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add Package Sold</span>
        </li>
    </ul>
        <div class="pt-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Add Package Sold</h5>
            </div>
            <div class="mb-5">
                <form action="{{ route('pack-sold.store') }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                    @csrf
                    <h6 class="mb-5 text-lg font-bold">Package Information</h6>
                    <div class="flex flex-col sm:flex-row">
                        <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                            <!-- Input fields here -->
                            <div>
                                <label for="package">Package Sold</label>
                                <input id="package" name="pack_sold_name" type="text" placeholder="Enter Package Sold Name" class="form-input" value="{{ old('pack_sold_name') }}">
                                @error('pack_sold_name')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="price" class="block mb-1 font-medium">Base Price</label>
                                <div class="relative flex items-stretch">
                                    <div class="bg-[#eee] flex justify-center items-center px-3 font-semibold border border-[#e0e6ed] dark:border-[#17263c] dark:bg-[#1b2e4b] ltr:rounded-l-md rtl:rounded-r-md">
                                        $
                                    </div>
                                    <input id="price" name="price" type="text" placeholder="Enter Price" class="form-input flex-1 ltr:rounded-r-md rtl:rounded-l-md border-[#e0e6ed] dark:border-[#17263c] dark:bg-[#1b2e4b]" value="{{ old('price') }}">
                                </div>
                                @error('price')
                                    <p class="text-danger 500 italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label>Select Sold Packages</label>
                                <div>
                                    @foreach($event as $events)
                                        <div>
                                            <label>
                                                <input type="checkbox" name="events[]" value="{{ $events->id }}">
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
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection