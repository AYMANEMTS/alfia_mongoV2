@extends('layout.admin')

@section('body')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>Ajouter des utilisateurs</h3>
          </div>
        </div>
      </div>
    </div>
    @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
    @endif
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            
            <div class="card-body">
              <div> </div>
              <form method="post" action="{{ route('add-user') }}">
                @csrf
                <div class="row g-3">
            
                    <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Nom complet</label>
                        <input class="form-control" id="validationCustom01" type="text" required="" name="full_name">
                        <div class="valid-feedback"> </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label" for="validationf">Fonction</label>
                        <input class="form-control" id="validationf" type="text" required="" name="job">
                        <div class="valid-feedback"></div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label" for="validationCustomUsername">Email</label>
                        <div class="input-group">
                            <input class="form-control" id="validationCustomUsername" type="email" placeholder="Email" aria-describedby="inputGroupPrepend" required="" name="email">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
            
                    <div class="col-md-6">
                        <label class="form-label" for="validationCustom02">Mot de passe</label>
                        <input class="form-control" id="validationCustom02" type="password" required="" name="password">
                        <div class="valid-feedback"></div>
                    </div>
            
                    <label class="form-label" for="validationFormCheck2">User Access</label>
                    <div class="form-check">
                        <input class="form-check-input" id="validationFormCheck2" type="radio" name="role" value="utilisateur" required="" >
                        <label class="form-check-label" for="validationFormCheck2">Utilisateur</label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" id="validationFormCheck3" type="radio" name="role" value="admin" required="">
                        <label class="form-check-label" for="validationFormCheck3">Admin</label>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                
                <button class="btn btn-primary" type="submit" name="submit">Valider</button>
            </form>
            
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->

    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3><i data-feather="user-plus"></i> Utilisateurs</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-data-user starts-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            
            <div class="card-body">
              <div class="dt-ext table-responsive">
                <table class="display" id="responsive">
                  <thead>
                    <tr>
                      <th  style='display: none;'> id</th>
                      <th>Nom Complet</th>
                      <th>Email</th>
                      <th>Type </th>
                      <th>Action </th>
                      
                    </tr>

                  </thead>
                  <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user['username'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['role'] }}</td>
                            <td>
                                <a class="btn btn-danger" href="">Delete</a>
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
    <!-- Container-data-user Ends-->
  </div>

@endsection