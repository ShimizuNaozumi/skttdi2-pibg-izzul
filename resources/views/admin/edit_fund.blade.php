@extends('admin.layout.layout')

@section('title','Butiran Tabung')

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
              <h2 class="page-title">Butiran Tabung</h2>
            </div>
          </div>
        </div>
	  </div>

	  <!-- Page body -->
	  <div class="page-body">
		  <div class="container-xl">
        <div class="row">
          <div class="col-lg-12">
            <form class="card rounded-3 shadow-sm" action="{{route('update_fund',['id'=>$fund->fund_id])}}" method="post" enctype="multipart/form-data">
              @method('put')
              @csrf
              <div class="card-header">
                <h3 class="card-title">Maklumat Tabung</h3>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6 p-3">
                        <div class="mb-3">
                            <label class="form-label">Gambar Tabung</label>
                            <img src="{{ asset($fund->fund_image_path) }}" alt="Gambar tabung" class="img-fluid rounded-3 shadow-sm mb-3">
                            <div>
                              <input type="file" name="image" class="form-control">
                              <small class="form-hint">
                                Maksimum: 20MB
                              </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 p-3">
                        <div class="mb-3">
                            <label class="form-label">Nama Tabung</label>
                            <div>
                              <input type="text" class="form-control" name="name" placeholder="Masukkan nama tabung" value="{{$fund->fund_name}}" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Penerangan</label>
                            <div>
                              <textarea id="tinymce-mytextarea" name="description">{{$fund->fund_description}}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Sasaran</label>
                            <div class="input-group">
                              <span class="input-group-text">
                                RM
                              </span>
                              <input type="number" class="form-control" name="target" placeholder="00.00" step="0.01" min="0" value="{{$fund->fund_target}}" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Kemaskini</button>
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