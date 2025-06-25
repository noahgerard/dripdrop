@props(['chart_data', 'height' => '300px', 'label' => 'Cups'])

<div class="bg-white rounded-2xl shadow-lg p-2 sm:p-6">
    <canvas id="{{ $attributes['id'] ?? 'coffeeChart' }}" class="w-full" style="max-height: {{ $height }}"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const data = @json($chart_data);
        const chartId = @json($attributes['id'] ?? 'coffeeChart');
        const coffeeChartData = data.slice(data.findIndex(d => d.count > 0));
        const ctx = document.getElementById(chartId).getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: coffeeChartData.map(d => d.date),
                datasets: [{
                    label: @json($label),
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
    });
</script>
