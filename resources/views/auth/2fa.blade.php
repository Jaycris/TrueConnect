@extends('layouts.app')
@section('content')
<div class="relative flex min-h-screen items-center justify-center bg-cover bg-center bg-no-repeat px-6 py-10 dark:bg-[#060818] sm:px-16">
    <div class="relative w-full max-w-[870px] rounded-md bg-[linear-gradient(45deg,#fff9f9_0%,rgba(255,255,255,0)_25%,rgba(255,255,255,0)_75%,_#fff9f9_100%)] p-2 dark:bg-[linear-gradient(52.22deg,#0E1726_0%,rgba(14,23,38,0)_18.66%,rgba(14,23,38,0)_51.04%,rgba(14,23,38,0)_80.07%,#0E1726_100%)]">
        <div class="relative flex flex-col justify-center items-center rounded-md bg-white/60 backdrop-blur-lg dark:bg-black/50 px-6 lg:min-h-[758px] py-20">
            <img src="{{ asset('assets/images/page-chronicles-logo.png') }}" alt="image" class="login-logo h-auto mb-1">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold uppercase !leading-snug primary-text md:text-4xl">Two Factor Authentication</h1>
                <p class="text-base font-bold leading-normal text-white-dark">Enter the code sent to your email</p>
            </div>
            <div class="mx-auto w-full max-w-[440px]">
                <form method="POST" action="{{ route('verify.2fa') }}" class="space-y-5 dark:text-white">
                    @csrf
                    <div>
                        <label for="code">Authentication Code</label>
                        <div class="relative text-white-dark">
                            <input id="code" type="text" name="two_factor_code" required autofocus placeholder="Enter Authentication Code" class="form-input ps-10 placeholder:text-white-dark">
                            <span class="absolute start-4 top-1/2 -translate-y-1/2">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path opacity="0.5" d="M10.65 2.25H7.35C4.23873 2.25 2.6831 2.25 1.71655 3.23851C0.75 4.22703 0.75 5.81802 0.75 9C0.75 12.182 0.75 13.773 1.71655 14.7615C2.6831 15.75 4.23873 15.75 7.35 15.75H10.65C13.7613 15.75 15.3169 15.75 16.2835 14.7615C17.25 13.773 17.25 12.182 17.25 9C17.25 5.81802 17.25 4.22703 16.2835 3.23851C15.3169 2.25 13.7613 2.25 10.65 2.25Z" fill="currentColor"></path>
                                    <path d="M14.3465 6.02574C14.609 5.80698 14.6445 5.41681 14.4257 5.15429C14.207 4.89177 13.8168 4.8563 13.5543 5.07507L11.7732 6.55931C11.0035 7.20072 10.4691 7.6446 10.018 7.93476C9.58125 8.21564 9.28509 8.30993 9.00041 8.30993C8.71572 8.30993 8.41956 8.21564 7.98284 7.93476C7.53168 7.6446 6.9973 7.20072 6.22761 6.55931L4.44652 5.07507C4.184 4.8563 3.79384 4.89177 3.57507 5.15429C3.3563 5.41681 3.39177 5.80698 3.65429 6.02574L5.4664 7.53583C6.19764 8.14522 6.79033 8.63914 7.31343 8.97558C7.85834 9.32604 8.38902 9.54743 9.00041 9.54743C9.6118 9.54743 10.1425 9.32604 10.6874 8.97558C11.2105 8.63914 11.8032 8.14522 12.5344 7.53582L14.3465 6.02574Z" fill="currentColor"></path>
                                </svg>
                            </span>
                        </div>
                        <p id="resend-message" class="text-sm text-gray-500 mt-2 font-bold">
                            You can resend the code after <span id="countdown">60</span> seconds.
                        </p>

                        <a id="resend-link" href="#" onclick="resendCode()" class="text-blue-500 hover:underline hidden font-bold mt-2">
                            Resend Code
                        </a>
                        @error('two_factor_code')
                            <span class="text-danger-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn secondary-button w-full">Verify</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let countdown = 60; // Countdown time
        const countdownElement = document.getElementById("countdown");
        const resendMessage = document.getElementById("resend-message");
        const resendLink = document.getElementById("resend-link");

        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(timer);
                resendMessage.classList.add("hidden"); // Hide the countdown message
                resendLink.classList.remove("hidden"); // Show the "Resend Code" link
            }
        }, 1000);
    });

    function resendCode() {
        fetch("{{ route('resend.2fa') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json()) // Convert response to JSON
        .then(data => {
            console.log("API Response:", data); // Debug response

            if (data.success) {
                alert("A new code has been sent to your email.");
                location.reload(); // Reload to update UI
            } else {
                console.error("Error resending code:", data.message);
                document.getElementById("resend-message").innerHTML = data.message;
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            alert("Error contacting server.");
        });
    }
</script>
@endsection