@extends('user.layout.app')

@section('title' , 'Yuran PIBG')
    
@section('content')
        <!--=====================================-->
        <!--=       Breadcrumb Area Start      =-->
        <!--=====================================-->
        <div class="edu-breadcrumb-area breadcrumb-style-4">
            <div class="container">
                <div class="breadcrumb-inner">
                    <div class="page-title">
                        <span class="pre-title">PIBG</span>
                        <h1 class="title">Yuran PIBG</h1>
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

        <!--=====================================-->
        <!--=        Event Area Start         =-->
        <!--=====================================-->
        <section class="event-details-area edu-section-gap">
            <div class="container">
                <div class="event-details">
                    <div class="row row--30">
                        <div class="col-lg-8">
                            <div class="details-content">
                                <h3>Penerangan Yuran</h3>
                                <p>Pembayaran ................</p>
                            </div>
                        </div>
                        <div class="read-more-btn">
                            <a href="{{route('pay')}}" class="edu-btn">Sumbang<i class="icon-4"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
