 @extends('layout.admin')

 @section('body')

  <!-- Data Partiipants-->
  <div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
           <h3><i data-feather="user-plus"></i> Participants</h3>
          </div>
          <div class="col-sm-6">
            <!-- Bookmark Start-->
            <div class="bookmark">
              <ul>
                <li>
                  <a href="include-admin/export-participant.php" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Icons">
                    <i data-feather="download"></i>Télécharger les données<i data-feather="download"></i>
                  </a></li>
                </li>
              </ul>
            </div>
            <!-- Bookmark Ends-->
          </div>
        </div>
      </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">

            <div class="card-body">
              <div class="dt-ext table-responsive">
                <table class="display" id="responsive">
                  <thead>
                    <tr>
                      <th>Nom Complet</th>
                      <th>Telephone</th>
                      <th>E-mail</th>
                      <th>Age</th>
                      <th>Ville</th>
                      <th>Métier</th>
                      <th>Nom de projet</th>
                      <th>idée de projet</th>
                      <th>Genre</th>
                      <th>Programme</th>
                      <th>Action</th>

                    </tr>

                  </thead>
                  <tbody>
                      @foreach($participants as $acc)
                          <tr class='data'>
                              <div style='display: none;'>" . ({{$acc['_id'] ?? ''}}) . "</div>
                              <td>{{$acc['fullName'] ?? ''}}</td>
                              <td>
                                  {{ $acc['tel'] }}
                                  {{--                                          <a href='tel:" . ($acc['tel'] ?? '') . "'>" . ($acc['tel'] ?? '') . "</a>--}}
                              </td>
                              <td>{{$acc['email'] ?? ''}}</td>
                              <td>{{$acc['age'] ?? ''}}</td>
                              <td>{{$acc['city'] ?? ''}}</td>
                              <td>{{$acc['job'] ?? ''}}</td>
                              <td>{{$acc['nameproject'] ?? ''}}</td>
                              <td>{{$acc['ideaproject'] ?? ''}}</td>
                              <td>{{$acc['gender'] ?? ''}}</td>
                              <td>{{$acc['alfia'] ?? ''}}</td>
                              <td>
                                  <a id='btn-addformation' class='btn btn-light'>Valider</a>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
  </div>

  <script>
    $('#btn-addformation').click(function(){
    //   var id_participant = $($result['fullname']).val();

    //   $.ajax({
    //     url : 'add-formation.php' ,
    //     data : 'id=' + id_participant,
    //   })
    })
  </script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

 @endsection

