@extends('client.layout.main')

@section('title', 'Danh sách mẫu CV')

@section('content')
    <div class="jp_listing_sidebar_main_wrapper py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center mb-4">
                        <h2>Các mẫu danh sách phổ biến</h2>
                    </div>

                    @php
                        $view = [
                            [
                                'title' => 'Mẫu cơ bản',
                                'image' => 'clients/images/cv/minimal.png',
                                'name_btn' => 'minimal',
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
                            <div class="col-12 col-sm-6 col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-img-top-wrapper overflow-hidden" style="height: 400px; position: relative;">
                                        <img src="{{ asset($item['image']) }}" class="card-img-top img-fluid zoomable-image" alt="{{ $item['title'] }}" style="height: 100%; width: 100%; object-fit: cover; object-position: top; transition: transform 0.3s ease;">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $item['title'] }}</h5>
                                        <div class="mt-auto">
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#previewModal-{{ $index }}">
                                                Xem trước
                                            </button>
                                            <a href="{{ route('cv.create', ['template' => $item['name_btn']]) }}" class="btn btn-primary">Dùng mẫu</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="previewModal-{{ $index }}" tabindex="-1" aria-labelledby="previewModalLabel-{{ $index }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $item['title'] }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ asset($item['image']) }}" class="img-fluid" alt="Preview">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                        </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const images = document.querySelectorAll('.zoomable-image');
            images.forEach(img => {
                img.addEventListener('mouseenter', function () {
                    img.style.transform = 'scale(1.2)';
                });
                img.addEventListener('mouseleave', function () {
                    img.style.transform = 'scale(1)';
                });
            });
        });
    </script>
@endsection
