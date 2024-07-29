@extends('admin.layout.layout')

@section('title','Pengguna')

@section('content')
<div class="page">
	<!-- Navbar -->
	@include('admin.partial.navbar')

	<div class="page-wrapper">

	  <!-- Page header -->
	  <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">Akaun Pengguna</h2>
          </div>
        </div>
      </div>
	  </div>

	  <!-- Page body -->
	  <div class="page-body">
		  <div class="container-xl">
        <div class="col-12">
          <div class="card rounded-3 shadow-sm">
            <div class="card-header d-flex flex-column flex-xl-row align-items-start align-items-xl-center">
              <h3 class="card-title">Senarai Pengguna</h3>
              <a href="#" class="btn btn-primary mt-3 mt-xl-0 ms-xl-auto" data-bs-toggle="modal" data-bs-target="#modal-add">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  Tambah pengguna
              </a>
            </div>

            <div class="table-responsive p-3">
              <table class="table table-vcenter card-table" id="dataTableUsers">
                <thead>
                  <tr>
                    <th class="w-1">#</th>
                    <th>Nama</th>
                    <th>E-mel</th>
                    <th>No. Telefon</th>
                    <th class="w-1"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$user->user_name}}</td>
                    <td>{{$user->user_email}}</td>
                    <td>{{$user->user_notel}}</td>
                    <td class="text-end">
                      <button class="btn btn-cyan btn-icon" data-bs-toggle="modal" data-bs-target="#modal-profile-{{$user->user_id}}">
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                      </button>
                    </td>
                  </tr>
                  <!-- Modal Profile User -->
                  <div class="modal modal-blur fade" id="modal-profile-{{$user->user_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-cyan text-light">
                          <h5 class="modal-title">Profil {{$user->user_name}}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="datagrid">
                            <div class="datagrid-item">
                              <div class="datagrid-title">nama penuh</div>
                              <div class="datagrid-content">{{$user->user_name}}</div>
                            </div>
                            <div class="datagrid-item">
                              <div class="datagrid-title">e-mel</div>
                              <div class="datagrid-content">{{$user->user_email}}</div>
                            </div>
                            <div class="datagrid-item">
                              <div class="datagrid-title">no. telefon</div>
                              <div class="datagrid-content">{{$user->user_notel}}</div>
                            </div>
                            <div class="datagrid-item">
                              <div class="datagrid-title">status akaun</div>
                              <div class="datagrid-content">
                                @if($user->user_status == '1')
                                <span class="status status-green">
                                  Aktif
                                </span>
                                @elseif($user->user_status == '2')
                                <span class="status status-red">
                                  Tidak Aktif
                                </span>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <a class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Batal
                          </a>
                          @if($user->user_status == '1')
                          <form action="{{route('deactivate_user', ['id'=>$user->user_id])}}" method="post">
                            @method('put')
                            @csrf
                            <button type="submit" class="btn btn-danger ms-auto">
                              Nyahaktif
                            </button>
                          </form>
                          @elseif($user->user_status == '2')
                          <form action="{{route('activate_user',['id'=>$user->user_id])}}" method="post">
                            @method('put')
                            @csrf
                            <button type="submit" class="btn btn-success ms-auto">
                              Aktifkan
                            </button>
                          </form>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Modal Profile User -->
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Modal Add User -->
        <div class="modal modal-blur fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <form action="{{route('create_user')}}" method="post" autocomplete="off">
                <div class="modal-header bg-primary text-light">
                  <h5 class="modal-title">Pengguna Baharu</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" placeholder="Nama penuh" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">E-mel</label>
                    <input type="email" class="form-control" name="email" placeholder="Alamat e-mel" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <a class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Batal
                  </a>
                  <button type="submit" class="btn btn-primary ms-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Tambah pengguna
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- End Modal Add User -->

        {{-- Alert Modal --}}
        @if(session()->has('message'))
        <div class="modal modal-blur fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-{{session('alert')}}"></div>
                    <div class="modal-body text-center py-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-{{session('alert')}} icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">{!!session('icon')!!}</svg>
                        <h3>{{session('title')}}</h3>
                        <div class="text-secondary">{{session('message')}}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        {{-- End Alert Modal --}}
	    </div>
	  </div>
  <!-- Footer -->
	@include('admin.partial.footer')
  </div>
</div>
@endsection