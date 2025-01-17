@extends('client.layout.main')

@section('title', 'Danh sách mẫu cv')

@section('content')
    <div class="jp_listing_sidebar_main_wrapper">
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="jp_hiring_slider_main_wrapper">
                        <div class="text-center">
                            <h2>Các mẫu danh sách phổ biến</h2>
                        </div>
                        <br>
                        <br>

                        @php
                            $view = [
                                [
                                    'title' => 'Mẫu tối thiểu',
                                    'image' => 'clients/images/cv/minimal.png',
                                    'name_btn' => 'minimal',
                                ],
                                [
                                    'title' => 'Mẫu thanh lịch',
                                    'image' => 'clients/images/cv/elegant.png',
                                    'name_btn' => 'elegant',
                                ],
                                [
                                    'title' => 'Mẫu hiện đại',
                                    'image' => 'clients/images/cv/modern.png',
                                    'name_btn' => 'modern',
                                ],
                            ];
                        @endphp

                        @foreach ($view as $item)
                            <div class="col-md-4">
                                <div class="card" style="width: 20rem;">
                                    <img style="object-fit: cover;  object-position: top;" src="{{ asset($item['image']) }}"
                                        height="350px" class="card-img-top border-bottom rounded-bottom">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item['title'] }}</h5>
                                        <form action="{{ route('viewPDF') }}" method="post">
                                            @csrf
                                            <button name="{{ $item['name_btn'] }}" class="btn btn-info">Xem
                                                trước</button>
                                            <a class="btn btn-primary">Dùng mẫu</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
@endsection

@section('js')
@endsection
