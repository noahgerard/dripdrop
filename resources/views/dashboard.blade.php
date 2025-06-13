<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <a class="text-2xl font-bold">
                @if (isset($viewing_user))
                    {{ $viewing_user->name }}'s Stats
                @else
                    Your Stats
                @endif
                </h2>
            </a>
            <x-user-stats :user_stats="$user_stats" />

            @if (isset($viewing_user))
                <a href="{{ route('department.show', parameters: ['id' => $viewing_user->department->id]) }}"
                    class="text-2xl font-bold mt-8">
                    {{ $viewing_user->department->name ?? 'Department' }}'s Stats
                </a>
            @else
                <a href="{{ route('department.show', parameters: ['id' => Auth::user()->department->id]) }}"
                    class="text-2xl font-bold mt-8">
                    Your Department Stats ({{ Auth::user()->department->name }})
                </a>
            @endif
            <x-department-stats :dep_stats="$dep_stats" />

            <h2 class="text-2xl font-bold mt-8">Coffee Chart</h2>
            <div class="bg-white rounded-2xl shadow-lg p-2 sm:p-6">
                <canvas id="coffeeChart" class="w-full max-h-[300px]"></canvas>
            </div>


            <div class="flex justify-between items-end mt-8">
                <h2 id="timeline" class="text-2xl font-bold">
                    @if (isset($viewing_user))
                        {{ $viewing_user->name }}'s Coffees
                    @else
                        Your Coffees
                    @endif
                </h2>
            </div>
            <div class="flex flex-col gap-4">
                @forelse ($user_stats['last_n_coffees'] as $coffee)
                    <x-coffee-entry :coffee="$coffee" :showUser="false" />
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
