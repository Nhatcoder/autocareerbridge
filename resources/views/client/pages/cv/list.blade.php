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

                        <div class="row">
                            @foreach ($view as $index => $item)
                                <div class="col-md-4">
                                    <div class="card" style="width: 20rem;">
                                        <img style="object-fit: cover; object-position: top;"
                                            src="{{ asset($item['image']) }}" height="350px"
                                            class="card-img-top border-bottom rounded-bottom">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item['title'] }}</h5>
                                            <!-- Nút mở modal -->
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#previewModal-{{ $index }}"
                                                data-template="{{ $item['name_btn'] }}">
                                                Xem trước
                                            </button>
                                            <a href="{{ route('cv.create', ['template' => $item['name_btn']]) }}" class="btn btn-primary">Dùng mẫu</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal riêng cho từng mẫu -->
                                <div class="modal fade" id="previewModal-{{ $index }}" tabindex="-1"
                                    aria-labelledby="previewModalLabel-{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="previewModalLabel-{{ $index }}">
                                                    {{ $item['title'] }}
                                                </h5>
                                                <button type="button" class="btn-close" data-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center" id="cvModalContent">
                                                <img src="{{ asset($item['image']) }}" alt="Preview"
                                                    style="width: 100%; max-height: 500px; object-fit: contain;">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal -->
                            @endforeach
                        </div>

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
