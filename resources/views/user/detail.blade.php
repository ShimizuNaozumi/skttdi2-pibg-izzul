@extends('user.layout.app')

@section('title' , 'Tabung')
    
@section('content')
        <!--=====================================-->
        <!--=       Breadcrumb Area Start      =-->
        <!--=====================================-->


        <div class="edu-breadcrumb-area breadcrumb-style-4">
            <div class="container">
                <div class="breadcrumb-inner">
                    <div class="page-title">
                        <span class="pre-title">Tabung</span>
                        <h1 class="title">{{$details->fund_name}}</h1>
                    </div>
                </div>
            </div>
            <ul class="shape-group">
                <li class="shape-1">
                    <span></span>
                </li>
                <li class="shape-2 scene"><img data-depth="2" src="../../assets/images/about/shape-13.png" alt="shape"></li>
                <li class="shape-3 scene"><img data-depth="-2" src="../../assets/images/about/shape-15.png" alt="shape"></li>
                <li class="shape-4">
                    <span></span>
                </li>
                <li class="shape-5 scene"><img data-depth="2" src="../../assets/images/about/shape-07.png" alt="shape"></li>
            </ul>
        </div>

        <!--=====================================-->
        <!--=     Courses Details Area Start    =-->
        <!--=====================================-->
        <section class="edu-section-gap course-details-area">
            <div class="container">
                <div class="row row--30">
                    <div class="col-lg-8 order-lg-1 order-2">
                        <div class="course-details-content course-details-3">
                            <div class="entry-content">
                                <div class="main-thumbnail" style="overflow: hidden; height: 420px;">
                                    <img style="width: 720px; height: 420px; object-fit: cover; object-position: center;" src="{{asset($details->fund_image_path)}}" alt="Event">
                                </div>
                            </div>

                            <div class="nav-tab-wrap">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                        <div class="course-tab-content">
                                            <div class="course-overview">
                                                <h3 class="heading-title">Penerangan Tabung</h3>
                                                <p>{!!$details->fund_description!!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 order-lg-2 order-1 mb-3">
                        <div class="course-sidebar-3">
                            <div class="edu-course-widget widget-course-summery">
                                <div class="inner">
                                    <div class="content">
                                        <h4 class="widget-title">Info Tabung</h4>
                                        <ul class="course-item">
                                            <li>
                                                <span class="label"><i class="icon-60"></i>Dana Terkumpul:</span>
                                                <span class="value price">RM {{number_format($donations, 2)}}</span>
                                            </li>
                                            <li>
                                                <span class="label"><i class="icon-70"></i>Bilangan Penyumbang:</span>
                                                <span class="value">{{$donors}}</span>
                                            </li>
                                        </ul>
                                        <div class="read-more-btn">
                                            <p>Klik butang di bawah untuk melakukan sumbangan.</p>
                                            <a href="{{route('sumbang',['id'=>encrypt_string($details->fund_id)])}}" class="edu-btn">Lanjut<i class="icon-4"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
