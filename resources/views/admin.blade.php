@extends('layout.admin')

@section('body')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>Statistiques</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container-fluid Starts-->
        <div class="container-fluid general-widget">
            <div class="row">
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden border-0">
                        <div class="bg-primary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="user-plus"></i></div>
                                <div class="media-body">
                                    <span class="m-0">Participants</span>
                                    <h4 class="mb-0 counter">{{ $participantsCount }}</h4>
                                    <i class="icon-bg" data-feather="user-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden border-0">
                        <div class="bg-secondary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="file-text"></i></div>
                                <div class="media-body">
                                    <span class="m-0">Formation</span>
                                    <h4 class="mb-0 counter">{{ $formationsCount }}</h4>
                                    <i class="icon-bg" data-feather="file-text"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden border-0">
                        <div class="bg-secondary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><i data-feather="user-check"></i></div>
                                <div class="media-body">
                                    <span class="m-0">Accompagnement</span>
                                    <h4 class="mb-0 counter">{{ $accompagnementCount }}</h4>
                                    <i class="icon-bg" data-feather="user-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->

        <!-- Chart Section -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 20px; padding: 20px; height: 70vh; box-sizing: border-box;">

            <!-- Chart 1 Container -->
            <div style="flex: 1 1 calc(50% - 20px); max-width: 48%; min-width: 300px; height: 100%; box-sizing: border-box; display: flex; flex-direction: column;">
                <select id="yearSelect1" style="margin-bottom: 10px; width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                    @foreach($years as $year)
                        <option value="{{$year}}" @if($loop->first) selected @endif>{{$year}}</option>
                    @endforeach
                </select>
                <canvas id="myChart1" style="flex-grow: 1; width: 100%; height: 100%;"></canvas>
            </div>

            <!-- Chart 2 Container -->
            <div style="flex: 1 1 calc(50% - 20px); max-width: 48%; min-width: 300px; height: 100%; box-sizing: border-box; display: flex; flex-direction: column;">
                <select id="yearSelect2" style="margin-bottom: 10px; width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                    @foreach($years as $year)
                        <option value="{{$year}}" @if($loop->first) selected @endif>{{$year}}</option>
                    @endforeach
                </select>
                <canvas id="myChart2" style="flex-grow: 1; width: 100%; height: 100%;"></canvas>
            </div>

        </div>

    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{--  chart 1  --}}
    <script>
        const participantsData = {!! json_encode($participantsChart) !!};
        const formationsData = {!! json_encode($formationsChart) !!};
        const accompagnementData = {!! json_encode($accompagnementChart) !!};
        const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

        // Function to extract the month data for a given year
        function getDataChartByMonths(data, year) {
            let result = [];
            if (data[year]) {
                Object.keys(data[year].months).forEach((month) => {
                    result.push(data[year].months[month]);
                });
            } else {
                console.log(`Data for year ${year} not found.`);
            }
            return result;
        }

        // Initial chart setup with default year (use the selected year from the dropdown)
        const initialYear = document.getElementById('yearSelect1').value; // Get the default selected year
        var ctx = document.getElementById('myChart1').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Formations',
                        data: getDataChartByMonths(formationsData, initialYear), // Default year from the dropdown
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1,
                        fill: false,
                        pointRadius: 3, // Reduce point radius
                        hitRadius: 10, // Set hit area for tooltips
                    },
                    {
                        label: 'Participants',
                        data: getDataChartByMonths(participantsData, initialYear), // Default year from the dropdown
                        borderColor: 'rgba(153, 102, 255, 1)',
                        tension: 0.1,
                        fill: false,
                        pointRadius: 3, // Reduce point radius
                        hitRadius: 10, // Set hit area for tooltips
                    },
                    {
                        label: 'Accompagnement',
                        data: getDataChartByMonths(accompagnementData, initialYear), // Default year from the dropdown
                        borderColor: 'rgba(255, 159, 64, 1)',
                        tension: 0.1,
                        fill: false,
                        pointRadius: 3, // Reduce point radius
                        hitRadius: 10, // Set hit area for tooltips
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: false,
                    },
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    tooltip: {
                        enabled: true, // Enable tooltips
                        mode: 'nearest', // Make tooltips show nearest data point
                        intersect: false, // Only show tooltip when hovering directly over a point
                    },
                },
                elements: {
                    line: {
                        borderWidth: 2, // Reduce the line width for better performance
                    },
                    point: {
                        radius: 3, // Reduce the point size
                    }
                }
            }
        });

        // Event listener for changing year
        document.getElementById('yearSelect1').addEventListener('change', function() {
            var selectedYear = this.value;

            // Update the chart with the selected year's data
            myChart.data.datasets[0].data = getDataChartByMonths(formationsData, selectedYear);
            myChart.data.datasets[1].data = getDataChartByMonths(participantsData, selectedYear);
            myChart.data.datasets[2].data = getDataChartByMonths(accompagnementData, selectedYear);

            // Update the chart
            myChart.update();
        });
    </script>


    <script>


        // Participants data from the server
        const participantsGenderData = {!! json_encode($particpantsGenderData) !!};

        // Variables for the data
        let womenData = [];
        let menData = [];

        // Function to extract gender data for a specific year
        function getGenderDataForYear(year) {
            const yearData = participantsGenderData[year] || { months: {} };

            // Reset data arrays
            womenData = [];
            menData = [];

            // Populate data for all months
            months.forEach(month => {
                const monthData = yearData.months[month] || { male: 0, female: 0 };
                womenData.push(monthData.female);
                menData.push(monthData.male);
            });
        }

        // Initialize the chart
        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const chart = new Chart(ctx2, {
            type: "bar",
            data: {
                labels: months,
                datasets: [
                    {
                        label: "Women",
                        backgroundColor: "#b91d47",
                        data: womenData
                    },
                    {
                        label: "Men",
                        backgroundColor: "#00aba9",
                        data: menData
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: "Comparison of Women and Men by Month"
                },
                responsive: true,
                scales: {
                    x: {
                        stacked: false
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Load data and update chart for the first selected year
        const yearSelect = document.getElementById("yearSelect2");
        getGenderDataForYear(yearSelect.value);
        chart.data.datasets[0].data = womenData;
        chart.data.datasets[1].data = menData;
        chart.update();

        // Update chart when the selected year changes
        yearSelect.addEventListener("change", function () {
            getGenderDataForYear(this.value);
            chart.data.datasets[0].data = womenData;
            chart.data.datasets[1].data = menData;
            chart.update();
        });
    </script>


@endsection
