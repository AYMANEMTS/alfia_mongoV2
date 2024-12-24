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
     <canvas style="margin-left: 15px;max-width: 1190px;max-height: 580px" id="myChart"></canvas>
  </div>
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <script>
         // Convert PHP data to JavaScript
         const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

         // Ensure the PHP data is properly encoded to JavaScript arrays
         const participantsData = {!! json_encode($participantsData) !!};
         const formationsData = {!! json_encode($formationsData) !!};
         const accompagnementData = {!! json_encode($accompagnementData) !!};


         // Render the chart
         var ctx = document.getElementById('myChart').getContext('2d');
         var myChart = new Chart(ctx, {
             type: 'line',
             data: {
                 labels: days, // French labels for the week
                 datasets: [
                     {
                         label: 'Participants',
                         data: participantsData,
                         borderColor: 'rgba(75, 192, 192, 1)',
                         borderWidth: 1,
                         fill: false
                     },
                     {
                         label: 'Formations',
                         data: formationsData,
                         borderColor: 'rgba(153, 102, 255, 1)',
                         borderWidth: 1,
                         fill: false
                     },
                     {
                         label: 'Accompagnement',
                         data: accompagnementData,
                         borderColor: 'rgba(255, 159, 64, 1)',
                         borderWidth: 1,
                         fill: false
                     }
                 ]
             },
             options: {
                 scales: {
                     y: {
                         beginAtZero: true
                     }
                 }
             }
         });
     </script>





@endsection
