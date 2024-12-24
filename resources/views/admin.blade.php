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
    <!-- Container-fluid starts-->
    <div class="container-fluid general-widget">
      <div class="row">
        <div class="col-sm-6 col-xl-3 col-lg-6">
          <div class="card o-hidden border-0">
            <div class="bg-primary b-r-4 card-body">
              <div class="media static-top-widget">
                <div class="align-self-center text-center"><i data-feather="user-plus"></i></div>
                <div class="media-body"><span class="m-0">Participants</span>
                  <h4 class="mb-0 counter">
                      {{ $participantsCount }}
                  </h4><i class="icon-bg" data-feather="user-plus"></i>
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
                <div class="media-body"><span class="m-0">Formation</span>
                  <h4 class="mb-0 counter">
                      {{ $formationsCount }}
                  </h4><i class="icon-bg" data-feather="file-text"></i>
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
                <div class="media-body"><span class="m-0">Accompagnement</span>

                  <h4 class="mb-0 counter">
                      {{ $accompagnementCount }}
                  </h4><i class="icon-bg" data-feather="user-check"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
    <select id="yearSelect" >
      @foreach($years as $year)
        <option value="{{$year}}" @if($loop->first) selected @endif>{{$year}}</option>
      @endforeach
    </select>
     <canvas style="margin-left: 15px;max-width: 1190px;max-height: 580px" id="myChart"></canvas>
  </div>

  
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    const initialYear = document.getElementById('yearSelect').value; // Get the default selected year
    var ctx = document.getElementById('myChart').getContext('2d');
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
            fill: false
          },
          {
            label: 'Participants',
            data: getDataChartByMonths(participantsData, initialYear), // Default year from the dropdown
            borderColor: 'rgba(153, 102, 255, 1)',
            tension: 0.1,
            fill: false
          },
          {
            label: 'Accompagnement',
            data: getDataChartByMonths(accompagnementData, initialYear), // Default year from the dropdown
            borderColor: 'rgba(255, 159, 64, 1)',
            tension: 0.1,
            fill: false
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  
    // Event listener for changing year
    document.getElementById('yearSelect').addEventListener('change', function() {
      var selectedYear = this.value;
  
      // Update the chart with the selected year's data
      myChart.data.datasets[0].data = getDataChartByMonths(formationsData, selectedYear);
      myChart.data.datasets[1].data = getDataChartByMonths(participantsData, selectedYear);
      myChart.data.datasets[2].data = getDataChartByMonths(accompagnementData, selectedYear);
  
      // Update the chart
      myChart.update();
    });
  </script>




@endsection
