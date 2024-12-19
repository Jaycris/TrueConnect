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
        <div class="pt-5">
        <div class="mb-6 grid">
        <div class="panel h-full">
                    <div class="mb-8 flex items-center dark:text-white-light">
                        <p style="font-size: 23px;" class="font-semibold">Total Sales Quota</p>
                        
                    </div>
                    <div class="space-y-9">
                        <div class="flex items-center">
                            <div class="h-9 w-9 ltr:mr-3 rtl:ml-3">
                                <div class="grid h-9 w-9 place-content-center rounded-full bg-secondary-light text-secondary dark:bg-secondary dark:text-secondary-light">
                                <svg width="30" height="30" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 6V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                    <path d="M15 9.5C15 8.11929 13.6569 7 12 7C10.3431 7 9 8.11929 9 9.5C9 10.8807 10.3431 12 12 12C13.6569 12 15 13.1193 15 14.5C15 15.8807 13.6569 17 12 17C10.3431 17 9 15.8807 9 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="mb-2 flex font-semibold text-white-dark">
                                    <h6>Total Sales Quota for the Month of December 2024: <strong>$56,000</strong></h6>
                                    <p class="ltr:ml-auto rtl:mr-auto"><strong>$60,000</strong></p>
                                </div>
                                <div class="h-2 rounded-full bg-dark-light shadow dark:bg-[#1b2e4b]">
                                    <div class="h-full w-11/12 rounded-full bg-gradient-to-r from-[#7579ff] to-[#b224ef]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <div class="mb-6 grid gap-6 xl:grid-cols-3">
                    <div class="panel h-full xl:col-span-2">
                        <div class="mb-5 flex items-center dark:text-white-light">
                            <h5 class="text-lg font-semibold">Overall Sales Breakdown💲</h5>
                            <div x-data="dropdown" @click.outside="open = false" class="dropdown ltr:ml-auto rtl:mr-auto">
                                <a href="javascript:;" @click="toggle">
                                    <svg class="h-5 w-5 text-black/70 hover:!text-primary dark:text-white/70" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                        <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                        <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                    </svg>
                                </a>
                                <ul x-cloak="" x-show="open" x-transition="" x-transition.duration.300ms="" class="ltr:right-0 rtl:left-0">
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
                    <div class="mb-5 flex items-center dark:text-white-light">
                        <h5 class="text-lg font-semibold">🏆 Consultant Leaderboard
                        
                    </div>
                    <div class="space-y-9">
                        
                        
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ltr:rounded-l-md rtl:rounded-r-md">Rank</th>
                                    <th>Consultant</th>
                                    <th class="ltr:rounded-r-md rtl:rounded-l-md">Sale</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- condition here: if rank 1, 2, 3 use emojis 🥇, 🥈, 🥉 instead -->
                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="text-primary">🥇</td>
                                    <td class="min-w-[150px] text-black dark:text-white">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3" src="assets/images/profile-6.jpeg" alt="avatar">
                                            <span class="whitespace-nowrap">Jette Greenfield</span>
                                        </div>
                                    </td>
                                    <td class="text-primary"><strong>$60,000</strong></td>
                                </tr>

                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="text-primary">🥈</td>
                                    <td class="min-w-[150px] text-black dark:text-white">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3" src="assets/images/profile-7.jpeg" alt="avatar">
                                            <span class="whitespace-nowrap">Simon Jenkins</span>
                                        </div>
                                    </td>
                                    <td class="text-primary"><strong>$53,000</strong></td>
                                </tr>

                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="text-primary">🥉</td>
                                    <td class="min-w-[150px] text-black dark:text-white">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3" src="assets/images/profile-3.jpeg" alt="avatar">
                                            <span class="whitespace-nowrap">Clark Franklin</span>
                                        </div>
                                    </td>
                                    <td class="text-primary"><strong>$49,000</strong></td>
                                </tr>

                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="text-primary">4</td>
                                    <td class="min-w-[150px] text-black dark:text-white">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3" src="assets/images/profile-8.jpeg" alt="avatar">
                                            <span class="whitespace-nowrap">Jane Gomez</span>
                                        </div>
                                    </td>
                                    <td class="text-primary"><strong>$45,000</strong></td>
                                </tr>

                                <tr class="group text-white-dark hover:text-black dark:hover:text-white-light/90">
                                    <td class="text-primary">5</td>
                                    <td class="min-w-[150px] text-black dark:text-white">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-md object-cover ltr:mr-3 rtl:ml-3" src="assets/images/profile-9.jpeg" alt="avatar">
                                            <span class="whitespace-nowrap">Donna Fergie</span>
                                        </div>
                                    </td>
                                    <td class="text-primary"><strong>$35,000</strong></td>
                                </tr>
                                
                                
                                
                                
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const totalSalesElement = document.getElementById('totalSales');

        const today = new Date();
        const daysInMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
        const currentMonth = today.toLocaleString('default', { month: 'long' });
        const monthsOfYear = Array.from({ length: 12 }, (_, i) =>
            new Date(0, i).toLocaleString('default', { month: 'short' })
        );

        let chart = new Chart(ctx, {
            type: 'line',
            data: getData('daily'),
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        window.updateChart = function (type) {
            const data = getData(type);
            chart.data = data;
            chart.update();
            updateTotalSales(data.datasets[0].data);
        };

        function getData(type) {
            switch (type) {
                case 'daily':
                    const dailySales = Array.from({ length: daysInMonth }, () => Math.floor(Math.random() * 1000) + 500);
                    return {
                        labels: Array.from({ length: daysInMonth }, (_, i) => i + 1),
                        datasets: [{
                            label: `Daily Sales for ${currentMonth} ${today.getFullYear()} ($)`,
                            data: dailySales,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    };
                case 'weekly':
                    const weeklySales = Array.from({ length: 4 }, () => Math.floor(Math.random() * 5000) + 1000);
                    return {
                        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                        datasets: [{
                            label: `Weekly Sales for ${today.getFullYear()} ($)`,
                            data: weeklySales,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }]
                    };
                case 'monthly':
                    const monthlySales = Array.from({ length: 12 }, () => Math.floor(Math.random() * 20000) + 5000);
                    return {
                        labels: monthsOfYear,
                        datasets: [{
                            label: `Monthly Sales for ${today.getFullYear()} ($)`,
                            data: monthlySales,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }]
                    };
                default:
                    return {};
            }
        }

        function updateTotalSales(data) {
            const totalSales = data.reduce((acc, value) => acc + value, 0);
            totalSalesElement.textContent = `$${totalSales.toLocaleString()}`;
        }

        // Initialize with daily sales
        updateTotalSales(chart.data.datasets[0].data);
    });
</script>

@endsection