<x-app-layout>
    <div class="py-12 mt-[5%]">
        <div class="flex flex-col gap-4 max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="text-2xl font-bold">{{ $department->name }} Department</h2>

            <x-department-stats :dep_stats="$dep_stats" />

            <h2 class="text-2xl font-bold mt-8">Coffee Chart</h2>
            <div class="bg-white rounded-2xl shadow-lg p-2 sm:p-6">
                <canvas id="coffeeChart" class="w-full max-h-[300px]"></canvas>
            </div>

            <h2 class="text-2xl font-bold mt-8">Members</h2>
            <x-user-list :users="$department->users" />

            <h2 class="text-2xl font-bold mt-8">Recent Coffees</h2>
            <div class="flex flex-col gap-4 bg-white rounded-2xl shadow-lg p-2 sm:p-4">
                @forelse ($recent_coffees as $coffee)
                    <x-coffee-entry :coffee="$coffee" :showUser="true" />
                @empty
                    <div class="text-gray-400 text-center py-4">No coffee entries yet.</div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $recent_coffees->links() }}
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
                    borderColor: 'rgba(59, 130, 246, 1)',
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
                            color: '#374151',
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
