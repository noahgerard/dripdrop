@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-2xl font-bold">Your Stats</h2>
            <div class="flex flex-wrap gap-6">
                <x-metric-card value="{{ $user_stats['today'] }}" label="Cups of coffee today" />
                <x-metric-card value="{{ $user_stats['this_week'] }}" label="Cups this week" />
                <x-metric-card value="{{ $user_stats['this_month'] }}" label="Cups this month" />
                <x-metric-card value="{{ $user_stats['personal_best'] }}" label="Personal best (day)" />
                <x-metric-card
                    value="{{ $user_stats['last_coffee_time'] ? Carbon::createFromDate($user_stats['last_coffee_time'])->diffForHumans() : 'Never' }}"
                    label="Last coffee time" />
                <x-metric-card value="{{ $user_stats['total'] }}" label="All-Time" />
                <x-metric-card value="{{ $user_stats['avg_cups_per_day'] }}" label="Avg. Cups/Day" />
                <x-metric-card value="{{ $user_stats['rank'] }}" label="Rank" />
            </div>
            <h2 class="text-2xl font-bold mt-8">Your Department Stats ({{ Auth::user()->department->name }})</h2>

            <div class="flex flex-wrap gap-6 justify-center">
                <x-metric-card value="{{ $dep_stats['today'] }}" label="Cups today" />
                <x-metric-card value="{{ $dep_stats['cpp'] }}" label="Today's Cups/Member" />
                <x-metric-card value="{{ $dep_stats['this_month'] }}" label="Cups this month" />
                <x-metric-card value="{{ $dep_stats['members'] }}" label="Members" />
                <x-metric-card value="{{ $dep_stats['rank'] }}" label="Department rank" />
            </div>

            <h2 class="text-2xl font-bold mt-8">Coffee Chart</h2>
            <div class="bg-white rounded-2xl shadow-lg p-2 sm:p-6">
                <canvas id="coffeeChart" class="w-full max-h-[300px]"></canvas>
            </div>


            <div class="flex justify-between items-end mt-8">
                <h2 id="timeline" class="text-2xl font-bold">Your Coffees</h2>
            </div>
            <div class="flex flex-col gap-4 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
                @forelse ($user_stats['last_n_coffees'] as $coffee)
                    @if (!$coffee['is_custom'])
                        <form method="POST" action="{{ route(name: 'coffee.delete') }}"
                            class="flex gap-2 h-fit group relative">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $coffee->id }}" />
                            <div
                                class="flex w-full items-center gap-4 p-3 rounded-lg bg-gray-50 shadow-sm hover:bg-yellow-50 transition-all">
                                <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>
                                <span class="font-semibold text-gray-800 local-coffee-date"
                                    data-iso="{{ $coffee->consumed_at }}"></span>
                                <span class="text-gray-500 text-sm ml-auto local-coffee-time"
                                    data-iso="{{ $coffee->consumed_at }}"></span>
                                <button type="submit"
                                    class="relative flex items-center justify-center w-6 opacity-100 transition-all duration-300 ease-in-out overflow-hidden text-slate-400 hover:text-red-400 ml-2">
                                    <x-lucide-trash class="w-6" />
                                </button>
                            </div>
                        </form>
                    @else
                        <form method="POST" action="{{ route(name: 'coffee.delete') }}"
                            class="flex gap-2 h-fit group relative">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $coffee->id }}" />
                            <div
                                class="flex flex-col w-full gap-4 p-3 rounded-lg bg-yellow-50 shadow-sm hover:bg-yellow-100 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-yellow-400"></span>
                                    <span class="font-semibold text-gray-800 local-coffee-date"
                                        data-iso="{{ $coffee->consumed_at }}"></span>
                                    <span class="text-gray-500 text-sm ml-auto local-coffee-time"
                                        data-iso="{{ $coffee->consumed_at }}"></span>
                                    <button type="submit"
                                        class="relative flex items-center justify-center w-6 opacity-100 transition-all duration-300 ease-in-out overflow-hidden text-slate-400 hover:text-red-400 ml-2">
                                        <x-lucide-trash class="w-6" />
                                    </button>
                                </div>

                                <div class="flex flex-col gap-2 w-full">

                                    <div class="font-bold text-lg text-yellow-900 flex gap-2 items-center">
                                        {{ $coffee->title }}
                                        <span
                                            class="inline-block px-2 py-0.5 text-xs rounded-md bg-yellow-600 text-white font-bold">{{ $coffee->type }}</span>
                                    </div>
                                    <div class="text-gray-700 text-sm">{{ $coffee->desc }}</div>
                                </div>
                                @if (!empty($coffee->img_url))
                                    <div
                                        class="flex-shrink-0 w-32 h-32 rounded-md overflow-hidden border border-yellow-200 bg-white flex items-center justify-center">
                                        <img src="{{ $coffee->img_url }}" alt="Coffee image"
                                            class="object-contain w-full h-full" />
                                    </div>
                                @endif


                            </div>
                        </form>
                    @endif
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $user_stats['last_n_coffees']->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const data = @json($coffee_chart_data);

        const coffeeChartData = data.slice(data.findIndex(d => d.count > 0));

        const ctx = document.getElementById('coffeeChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: coffeeChartData.map(d => d.date),
                datasets: [{
                    label: 'Cups',
                    data: coffeeChartData.map(d => d.count),
                    fill: true,
                    tension: 0.4,
                    borderColor: 'rgba(59, 130, 246, 1)', // Tailwind blue-500
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointHoverRadius: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6B7280',
                            maxTicksLimit: 3,
                            autoSkip: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#E5E7EB'
                        },
                        ticks: {
                            color: '#6B7280',
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#374151', // gray-700
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleColor: '#F9FAFB',
                        bodyColor: '#F3F4F6',
                        cornerRadius: 6,
                        padding: 10
                    }
                }
            }
        });
    </script>


</x-app-layout>
