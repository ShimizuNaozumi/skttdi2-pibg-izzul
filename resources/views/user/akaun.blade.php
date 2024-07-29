@extends('user.layout.app')

@section('title' , 'Akaun Saya')
    
@section('content')
        <!--=====================================-->
        <!--=       Breadcrumb Area Start      =-->
        <!--=====================================-->

        <div class="edu-breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-inner">
                    <div class="page-title">
                        <h1 class="title">Akaun Saya</h1>
                    </div>
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-1">
                    <span></span>
                </li>
                <li class="shape-2 scene"><img data-depth="2" src="assets/images/about/shape-13.png" alt="shape"></li>
                <li class="shape-3 scene"><img data-depth="-2" src="assets/images/about/shape-15.png" alt="shape"></li>
                <li class="shape-4">
                    <span></span>
                </li>
                <li class="shape-5 scene"><img data-depth="2" src="assets/images/about/shape-07.png" alt="shape"></li>
            </ul>
        </div>

        <div class="edu-product-description gap-bottom-equal">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="product-description-nav nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab" aria-controls="desc" aria-selected="true">Maklumat Akaun</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">Pengurusan Keluarga</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review1" type="button" role="tab" aria-controls="review" aria-selected="false">Pengurusan Anak</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="product-description-content tab-pane fade show active" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                                <div class="edu-team-details-area section-gap-equal">
                                    <div class="container">
                                            <div class="row row--40">
                                                <div class="col-lg-4">
                                                    <form action="{{route('gambar',['id'=>$acc->user_id])}}" method="post" enctype="multipart/form-data"> 
                                                        <div class="team-details-thumb">
                                                            @csrf
                                                            <input type="text" name="id" id="id" value="{{$acc->user_id}}" hidden>
                                                            <div class="thumbnail">
                                                                <label for="user_photo" id="imageLabel">
                                                                    <img id="oldImage" src="{{$acc->user_photo}}" alt="Tekan ini   " style="cursor: pointer;">
                                                                </label>
                                                                <br>
                                                                <img id="newImage" src="{{$acc->user_photo}}" alt="New Photo" style="display: none;">
                                                                <br>
                                                                <input type="file" id="user_photo" name="user_photo" style="display: none;" onchange="previewPhotos(event)">
                                                                <small>Klik gambar untuk mengemas kini gambar profil anda</small>
                                                            </div>
                                                            <button type="submit" class="edu-btn btn-medium">Kemas Kini Gambar<i class="icon-45"></i></button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-lg-8">
                                                    <form method="POST" action="{{route('update',['id'=>$acc->user_id])}}" >
                                                        <div class="team-details-content">
                                                            <div class="login-form-box registration-form">
                                                                @csrf
                                                                <input type="text" name="id" id="id" value="{{$acc->user_id}}" hidden>
                                                                <h2>Maklumat Pengguna</h2>
                                                                <div class="form-group">
                                                                    <h4 for="guardian_name">Nama Penuh</h4>
                                                                    <input type="text" class="form-control" name="name" id="name" value="{{$acc->user_name}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <h4 for="guardian_email">E-mel</h4>
                                                                    <input type="email" class="form-control" name="email" id="email" value="{{$acc->user_email}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <h4 for="guardian_notel">Nombor Telefon</h4>
                                                                    <input type="text" class="form-control" name="notel" id="notel" value="{{$acc->user_notel}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <button type="submit" class="edu-btn btn-medium">Kemas Kini<i class="icon-45"></i></button>
                                                                </div>
                                                            </div>    
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-description-content tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                <div class="container position-relative">
                                    <div class="row g-5 justify-content-center">
                                        <div class="col-lg-5">
                                            <div class="login-form-box registration-form">
                                                <h3 class="title">Tambah Penjaga</h3>
                                                <form method="POST" action="{{route ('addG')}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="guardian_name">Nama Penuh</label>
                                                        <input type="text" name="guardian_name" id="guardian_name" placeholder="Nama penuh">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="guardian_email">E-mel</label>
                                                        <input type="email" name="guardian_email" id="guardian_email" placeholder="E-mel">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="guardian_notel">Nombor Telefon</label>
                                                        <input type="text" name="guardian_notel" id="guardian_notel" placeholder="Nombor Telefon">
                                                    </div>
                                                    {{-- <div class="form-group">
                                                        <label for="guardian_gaji">Gaji Bulanan</label>
                                                        <input type="text" name="guardian_gaji" id="guardian_gaji" placeholder="000.00 ">
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <label for="guardian_role">Peranan Dalam Keluarga</label>
                                                        <select name="guardian_role" id="guardian_role">
                                                            <option selected>Pilih peranan</option>
                                                            <option value="1">Bapa</option>
                                                            <option value="2">Ibu</option>
                                                            <option value="3">Penjaga</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="edu-btn btn-medium">Tambah Penjaga<i class="icon-30"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="login-form-box registration-form">
                                                <h3 class="title">Senarai Penjaga</h3>
                                                <table class="table cart-table wishlist-table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="product-title">Nama</th>
                                                            <th scope="col" class="product-price">E-mel</th>
                                                            <th scope="col" class="product-status">Peranan</th>
                                                            <th scope="col" class="product-add-cart"></th>
                                                        </tr>
                                                    </thead>
                                                    @foreach ($guardians as $g)
                                                    <tbody>
                                                        <tr>
                                                            <td class="product-title" data-title="Nama">
                                                                {{$g->guardian_name}}
                                                            </td>
                                                            <td class="product-price" data-title="E-mel">
                                                                {{$g->guardian_email}}
                                                            </td>
                                                            <td class="product-status" data-title="Peranan">
                                                                @if ($g->guardian_role==1)
                                                                    Bapa
                                                                @elseif($g->guardian_role==2)
                                                                    Ibu
                                                                @elseif($g->guardian_role==3)
                                                                    Penjaga
                                                                @endif
                                                            </td>
                                                            <td class="product-add-cart">
                                                                <a href="#" class="btn btn-lg btn-danger text-white"><span class="icon-42"></span></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>   
                                                    @endforeach
                                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-description-content tab-pane fade" id="review1" role="tabpanel" aria-labelledby="review-tab">
                                <div class="container position-relative">
                                    <div class="row g-5 justify-content-center">
                                        <div class="col-lg-5">
                                            <div class="login-form-box registration-form">
                                                <h3 class="title">Tambah Anak</h3>
                                                <form method="POST" action="{{route ('addS')}}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="reg-name">Nama Penuh</label>
                                                        <input type="text" name="student_name" id="student_name" placeholder="Nama penuh">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="log-name">No. Kad Pengenalan</label>
                                                        <input type="text" name="student_ic" id="student_ic"  placeholder="tanpa (-)">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="reg-name">Kelas</label>
                                                        <input type="text" name="student_class" id="student_class" placeholder="Kelas">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="edu-btn btn-medium">Tambah Anak<i class="icon-30"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="login-form-box registration-form">
                                                <h3 class="title">Senarai Anak</h3>
                                                <table class="table cart-table wishlist-table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="product-title">Nama</th>
                                                            <th scope="col" class="product-price">No. Kad</th>
                                                            <th scope="col" class="product-status">Kelas</th>
                                                            <th scope="col" class="product-add-cart"></th>
                                                        </tr>
                                                    </thead>
                                                    @foreach ($students as $s)
                                                    <tbody>
                                                        <tr>
                                                            <td class="product-title">
                                                                {{$s->student_name}}
                                                            </td>
                                                            <td class="product-price" data-title="Price">
                                                                {{$s->student_ic}}
                                                            </td>
                                                            <td class="product-status" data-title="Stock">
                                                                {{$s->student_class}}
                                                            </td>
                                                            <td class="product-add-cart">
                                                                <a href="" class="edu-btn btn-medium text-white"><span class="icon-42"></span></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>   
                                                    @endforeach
                                                    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=====================================-->
        <!--=     script for imgage profile     =-->
        <!--=====================================-->
        
        <script>
            function previewPhotos(event) {
                var input = event.target;
                var reader = new FileReader();
                
                reader.onload = function(){
                    var dataURL = reader.result;
                    var newImage = document.getElementById('newImage');
                    newImage.src = dataURL;

                    var oldImage = document.getElementById('oldImage');
                    oldImage.style.display = 'block'; // Show the old image

                    // Display the name of the new image below the old image
                    var imageName = input.files[0].name;
                    var imageLabel = document.createElement('p');
                    imageLabel.textContent = "New Image: " + imageName;
                    oldImage.parentNode.insertBefore(imageLabel, oldImage.nextSibling);
                };

                if (input.files && input.files[0]) {
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
new DataTable('#dataTableReport');
new DataTable('#dataTablePendingReport');
new DataTable('#dataTableApproved');
</script>
@endsection


    