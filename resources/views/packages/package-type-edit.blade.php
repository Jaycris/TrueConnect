@extends('layouts.master')
@section('content')
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('pack-type.index') }}" class="text-primary hover:underline">Package Type</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit Package Type</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Edit Package Type</h5>
            </div>
            <div class="mb-5">
                <form action="{{ route('pack-type.update', $packType->id) }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                    @csrf
                    <h6 class="mb-5 text-lg font-bold">Package Type</h6>
                    <div class="flex flex-col sm:flex-row">
                        <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                            <!-- Input fields here -->
                            <div>
                                <label for="pack_type">Package Type</label>
                                <input id="pack_type" name="pack_type_name" type="text" placeholder="Enter Package Type" class="form-input" value="{{ $packType->pack_type_name }}">
                                @error('name')
                                    <p class="text-danger 500 italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label>Select Packages Sold</label>
                                <div>
                                    @foreach($packSold as $sold)
                                        <div>
                                            <label>
                                                <!-- Check if the package is already associated with the package type -->
                                                <input type="checkbox" name="pack_sold[]" value="{{ $sold->id }}" 
                                                    {{ in_array($sold->id, $packType->packageSold->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                {{ $sold->pack_sold_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('pack_sold')
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
