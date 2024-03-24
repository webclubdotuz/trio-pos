<div class="card">
    <div class="card-body">
        <?php $id = 'pie-chart-' . rand(1000, 9999); ?>
        <div id="{{$id}}"></div>
    </div>
</div>


@push('js')
    <script src="/assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
    <script>
        var options = {
            series: {!! json_encode($data) !!},
            chart: {
                foreColor: '#9ba7b2',
                height: 330,
                type: 'pie',
            },
            colors: ['#00d25b', '#ff8d72', '#ff5b8a', '#00acf0', '#ffaa91'],
            labels: {!! json_encode($labels) !!},
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 360
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var chart = new ApexCharts(document.querySelector("#{{$id}}"), options);
        chart.render();
    </script>
@endpush
