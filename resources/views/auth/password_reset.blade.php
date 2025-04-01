@extends('layouts.app')
@section('content')
<div class="relative flex min-h-screen items-center justify-center bg-cover bg-center bg-no-repeat px-6 py-10 dark:bg-[#060818] sm:px-16">
    <div class="relative w-full max-w-[870px] rounded-md bg-[linear-gradient(45deg,#fff9f9_0%,rgba(255,255,255,0)_25%,rgba(255,255,255,0)_75%,_#fff9f9_100%)] p-2 dark:bg-[linear-gradient(52.22deg,#0E1726_0%,rgba(14,23,38,0)_18.66%,rgba(14,23,38,0)_51.04%,rgba(14,23,38,0)_80.07%,#0E1726_100%)]">
        <div class="relative flex flex-col justify-center items-center rounded-md bg-white/60 backdrop-blur-lg dark:bg-black/50 px-6 lg:min-h-[758px] py-20">
        <img src="{{ asset('assets/images/page-chronicles-logo.png') }}" alt="image" class="login-logo h-auto mb-1"> <!-- Adjusted size -->            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold uppercase !leading-snug primary-text md:text-4xl">Welcome to TrueConnect</h1>
                <h1 class="text-1xl font-bold !leading-snug primary-text md:text-2xl">Page Chronicles CRM Portal!</h1>
                <p class="text-base font-bold leading-normal text-dark mt-2">Update your Password</p>
            </div>
            <div class="mx-auto w-full max-w-[440px]">
                <form method="POST" action="{{ route('password.reset.handle') }}" class="space-y-5 dark:text-white">
                    @csrf
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
                                
                    <button type="submit" class="btn secondary-button w-full">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection