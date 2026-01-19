<div id="widget-{{ $class->model->id }}" class="w-full my-5 px-1">
    <div class="bg-white rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Orders Created by All Users</h3>
        @if(empty($users))
            <p class="text-gray-500">No data available for the selected period.</p>
        @else
            <div id="chart-{{ $class->model->id }}" class="w-full h-64"></div>
        @endif
    </div>
</div>

@if(!empty($users))
<script>
document.addEventListener('DOMContentLoaded', function() {
    var options = {
        series: [{
            data: @json($counts)
        }],
        chart: {
            type: 'bar',
            height: 150,
            horizontal: true
        },
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '90%',
                borderRadius: 6,
                strokeWidth: 0
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: @json($users)
        },
        yaxis: {
            labels: {
                show: true
            }
        },
        tooltip: {
            theme: 'dark',
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function () {
                        return ''
                    }
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart-{{ $class->model->id }}"), options);
    chart.render();
});
</script>
@endif