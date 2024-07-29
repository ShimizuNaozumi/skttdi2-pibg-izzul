@extends('admin.layout.layout')

@section('title','Tabung')

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
              <h2 class="page-title">Tambah Tabung</h2>
            </div>
          </div>
        </div>
	  </div>

	  <!-- Page body -->
	  <div class="page-body">
		  <div class="container-xl">
        <div class="row">
          <div class="col-lg-12">
            <form class="card rounded-3 shadow-sm" action="{{route('create_fund')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-header">
                <h3 class="card-title">Maklumat Tabung</h3>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">Nama Tabung</label>
                  <div>
                    <input type="hidden" name="admin_id" value="{{$acc->admin_id}}">
                    <input type="text" class="form-control" name="name" placeholder="Masukkan nama tabung" autocomplete="off" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Penerangan</label>
                  <div>
                    <textarea id="tinymce-mytextarea" name="description"></textarea>
                  </div>
                </div>
                <div class="mb-3">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Jumlah Sasaran</label>
                      <div class="input-group">
                        <span class="input-group-text">
                          RM
                        </span>
                        <input type="number" class="form-control" name="target" placeholder="00.00" step="0.01" min="0" autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Gambar</label>
                      <div>
                        <input type="file" name="image" class="form-control" required>
                        <small class="form-hint">
                          Gambar ini akan dipaparkan pada katalog tabung.
                          <span class="text-danger">Maksimum: 20MB.</span>
                        </small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Tambah</button>
              </div>
            </form>
          </div>
        </div>
	    </div>
	  </div>

    <!-- Footer -->
	@include('admin.partial.footer')
  </div>
</div>



@endsection