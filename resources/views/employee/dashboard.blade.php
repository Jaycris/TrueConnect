@extends('layouts.master')
@section('content')
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Sales</span>
            </li>
        </ul>
        
        <div class="alert-container">
            <div id="sample-data-alert" class="alert bg-yellow-100 border border-yellow-300 text-yellow-900 px-4 py-3 rounded relative" role="alert" style="margin-bottom: 1px;">
                <strong class="font-bold">Notice:</strong>
                <span class="block sm:inline">The data you see in this dashboard is only sample data and not real. We are still developing the system.</span>
                <span id="dismiss-alert" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                    <svg class="fill-current h-6 w-6 text-yellow-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1 1 0 01-1.414 0L10 11.914l-2.934 2.935a1 1 0 01-1.414-1.415l2.935-2.934-2.935-2.934a1 1 0 011.414-1.415L10 8.586l2.934-2.935a1 1 0 111.414 1.415L11.414 10l2.935 2.934a1 1 0 010 1.415z"/>
                    </svg>
                </span>
            </div>
        </div>
        <div class="pt-5">
            <div class="mb-2 grid gap-6 xl:grid-cols-3">
                <div class="panel h-full xl:col-span-2">
                    <div class="mb-5 flex items-center dark:text-white-light">
                        <h5 class="text-lg font-semibold">Consultant Leaderboard</h5>
                    </div>
                    <p style="font-size: 13px; margin-top: -1em;" class="text-muted">As of December 20, 2024</p><br />
                    <!-- Scrollable container -->
                    <div class="space-y-9" style="max-height: 400px; overflow-y: auto;">
                        <div id="scrollable-container" class="space-y-9"
                            style="max-height: 400px; overflow-y: auto; padding-right: 1rem; position: relative;">
                            <div class="flex items-center">
                                <div class="h-9 w-9 ltr:mr-3 rtl:ml-3">
                                    <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3"
                                        src="assets/images/profile-6.jpeg" alt="avatar">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2 flex font-semibold text-primary">
                                        <h6>Leia Hall</h6>
                                        <p class="ltr:ml-auto rtl:mr-auto"><strong>$60,000 / $60,000</strong></p>
                                    </div>
                                    <div class="h-2 w-full rounded-full bg-dark-light shadow dark:bg-[#1b2e4b]">
                                        <div class="h-full w-full rounded-full bg-gradient-to-r from-[#3cba92] to-[#0ba360]"
                                            style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="h-9 w-9 ltr:mr-3 rtl:ml-3">
                                    <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3"
                                        src="assets/images/profile-7.jpeg" alt="avatar">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2 flex font-semibold text-primary">
                                        <h6>Jace Cullen</h6>
                                        <p class="ltr:ml-auto rtl:mr-auto"><strong>$53,000 / $60,000</strong></p>
                                    </div>
                                    <div class="h-2 w-full rounded-full bg-dark-light shadow dark:bg-[#1b2e4b]">
                                        <div class="h-full w-full rounded-full bg-gradient-to-r from-[#3cba92] to-[#0ba360]"
                                            style="width: 84%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="h-9 w-9 ltr:mr-3 rtl:ml-3">
                                    <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3"
                                        src="assets/images/profile-3.jpeg" alt="avatar">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2 flex font-semibold text-primary">
                                        <h6>Mark Johnson</h6>
                                        <p class="ltr:ml-auto rtl:mr-auto"><strong>$49,000 / $60,000</strong></p>
                                    </div>
                                    <div class="h-2 w-full rounded-full bg-dark-light shadow dark:bg-[#1b2e4b]">
                                        <div class="h-full w-full rounded-full bg-gradient-to-r from-[#3cba92] to-[#0ba360]"
                                            style="width: 76%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <div class="h-9 w-9 ltr:mr-3 rtl:ml-3">
                                    <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3"
                                        src="assets/images/profile-8.jpeg" alt="avatar">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2 flex font-semibold text-primary">
                                        <h6>Jane Gomez</h6>
                                        <p class="ltr:ml-auto rtl:mr-auto"><strong>$45,000 / $60,000</strong></p>
                                    </div>
                                    <div class="h-2 w-full rounded-full bg-dark-light shadow dark:bg-[#1b2e4b]">
                                        <div class="h-full w-full rounded-full bg-gradient-to-r from-[#3cba92] to-[#0ba360]"
                                            style="width: 70%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fade Shadow -->
                        <div id="fade-shadow" style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; pointer-events: none; 
                        background: linear-gradient(to top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));">
                        </div>
                    </div>
                </div>

                <div class="panel h-full w-full">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Top-Selling Services</h5>
                    </div>
                    <p style="font-size: 13px; margin-top: -1em; margin-bottom: 1em;" class="text-muted">Based on Cumulative
                        Sales as of December 20, 2024</p>
                    <!-- Scrollable container -->
                    <div class="space-y-9" style="max-height: 400px; overflow-y: auto;">
                        <div id="scrollable-container2" class="space-y-9"
                            style="max-height: 400px; overflow-y: auto; padding-right: 1rem; position: relative;">
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr class="border-b-0">
                                            <th class="ltr:rounded-l-md rtl:rounded-r-md text-primary"><strong>Service</strong>
                                            </th>
                                            <th class="text-primary"><strong>Sold (Qty.)</strong></th>
                                            <th class="ltr:rounded-r-md rtl:rounded-l-md text-primary"><strong>Price</strong>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="group text-primary">
                                            <td><strong>Book Cover Design</strong></td>
                                            <td>75</td>
                                            <td>$1200</td>
                                        </tr>
                                        <tr class="group text-primary">
                                            <td><strong>Content Editing</strong></td>
                                            <td>68</td>
                                            <td>$2500</td>
                                        </tr>
                                        <tr class="group text-primary">
                                            <td><strong>Proofreading</strong></td>
                                            <td>62</td>
                                            <td>$800</td>
                                        </tr>
                                        <tr class="group text-primary">
                                            <td><strong>Manuscript Review</strong></td>
                                            <td>55</td>
                                            <td>$900</td>
                                        </tr>
                                        <tr class="group text-primary">
                                            <td><strong>Marketing Campaign</strong></td>
                                            <td>48</td>
                                            <td>$3000</td>
                                        </tr>
                                        <tr class="group text-primary">
                                            <td><strong>Publisher's Program</strong></td>
                                            <td>45</td>
                                            <td>$1500</td>
                                        </tr>
                                        <tr class="group text-primary">
                                            <td><strong>eBook Formatting</strong></td>
                                            <td>37</td>
                                            <td>$500</td>
                                        </tr>
                                        <tr class="group text-primary">
                                            <td><strong>Social Media Management</strong></td>
                                            <td>32</td>
                                            <td>$2000</td>
                                        </tr>
                                        <tr class="group text-primary">
                                            <td><strong>Movie Book Trailer</strong></td>
                                            <td>29</td>
                                            <td>$3500</td>
                                        </tr>
                                        <tr class="group text-primary">
                                            <td><strong>Press Release Creation</strong></td>
                                            <td>22</td>
                                            <td>$400</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Fade Shadow -->
                        <div id="fade-shadow2" style="position: absolute; bottom: 0; left: 0; right: 0; height: 100px; pointer-events: none; 
                        background: linear-gradient(to top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-5">
    <div class="mb-6 grid gap-6 xl:grid-cols-3">
        <div class="panel h-full xl:col-span-2">
            <div class="mb-5 flex items-center dark:text-white-light">
                <h5 class="text-lg font-semibold">Overall Sales Breakdown</h5>
                <div x-data="dropdown" @click.outside="open = false" class="dropdown ltr:ml-auto rtl:mr-auto">
                    <a href="javascript:;" @click="toggle">
                        <svg class="h-5 w-5 text-black/70 hover:!text-primary dark:text-white/70" viewbox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                            <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5">
                            </circle>
                            <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                        </svg>
                    </a>
                    <ul x-cloak="" x-show="open" x-transition="" x-transition.duration.300ms=""
                        class="ltr:right-0 rtl:left-0">
                        <li><a href="javascript:;" @click="updateChart('daily')">Daily</a></li>
                        <li><a href="javascript:;" @click="updateChart('weekly')">Weekly</a></li>
                        <li><a href="javascript:;" @click="updateChart('monthly')">Monthly</a></li>
                    </ul>
                </div>
            </div>
            <p class="text-lg dark:text-white-light/90">
                Current Total <span id="totalSales" class="ml-2 text-primary">$0</span>
            </p>
            <div class="relative overflow-hidden">
                <div x-ref="revenueChart" class="rounded-lg bg-white dark:bg-black">
                    <div style="margin: auto;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel h-full">
            <div class="mb-8 flex items-center dark:text-white-light">
                <h5 class="text-lg font-semibold">Total Sales Quota</h5>

            </div>
            <div class="space-y-9">
                <p style="font-size: 13px; margin-top: -2em;" class="text-muted">As of December 20, 2024</p>
                <div class="flex items-center">
                    <div class="h-9 w-9 ltr:mr-3 rtl:ml-3">
                        <div
                            class="grid h-9 w-9 place-content-center rounded-full bg-secondary-light text-secondary dark:bg-secondary dark:text-secondary-light">
                            <svg width="30" height="30" viewbox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 6V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                </path>
                                <path
                                    d="M15 9.5C15 8.11929 13.6569 7 12 7C10.3431 7 9 8.11929 9 9.5C9 10.8807 10.3431 12 12 12C13.6569 12 15 13.1193 15 14.5C15 15.8807 13.6569 17 12 17C10.3431 17 9 15.8807 9 14.5"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="mb-2 flex font-semibold text-primary">
                            <h6>Sales</h6>

                            <p class="ltr:ml-auto rtl:mr-auto"><strong>$56,000 / $60,000</strong></p>
                        </div>
                        <div class="h-2 rounded-full bg-dark-light shadow dark:bg-[#1b2e4b]">
                            <div class="h-full w-11/12 rounded-full bg-gradient-to-r from-[#7579ff] to-[#b224ef]"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        // JavaScript to handle dismissing the alert
        document.getElementById("dismiss-alert").addEventListener("click", function () {
            document.getElementById("sample-data-alert").style.display = "none";
        });
    </script>

    <style>
        /* Optional: Styling for alert */
        .alert {
            display: block;
            transition: all 0.3s ease;
        }
        .alert.hidden {
            display: none;
        }
    </style>
@endsection