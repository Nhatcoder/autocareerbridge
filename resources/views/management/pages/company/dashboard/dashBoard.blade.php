@extends('management.layout.main')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-titles">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{ __('label.company.dashboard.home') }}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('label.company.dashboard.statistical') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <style>
                .swiper-wrapper {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 20px;
                    justify-content: space-between;
                }

                .swiper-slide {
                    flex: 1 1 calc(25% - 20px);
                    box-sizing: border-box;
                    margin-bottom: 20px;
                }

                @media (max-width: 1200px) {
                    .swiper-slide {
                        flex: 1 1 calc(33.33% - 20px);/
                    }
                }

                @media (max-width: 768px) {
                    .swiper-slide {
                        flex: 1 1 calc(50% - 20px);
                    }
                }

                @media (max-width: 480px) {
                    .swiper-slide {
                        flex: 1 1 100%;
                    }
                }
            </style>
            <div
                class="swiper mySwiper-counter position-relative overflow-hidden swiper-initialized swiper-horizontal swiper-watch-progress swiper-backface-hidden">
                <div class="swiper-wrapper">
                    <!--swiper-slide-->
                    <div class="swiper-slide">
                        <div class="card counter">
                            <div class="card-body d-flex align-items-center">
                                <div class="card-box-icon">
                                    <i class="bi bi-people" style="font-size: 22px;"></i> <!-- Bootstrap Icon -->
                                </div>
                                <div class="chart-num">
                                    <h2 class="mb-0">{{ $count['countHiring'] }}</h2>
                                    <p class="mb-0">{{ __('label.company.dashboard.total_employees') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card counter">
                            <div class="card-body d-flex align-items-center">
                                <div class="card-box-icon">
                                    <i class="bi bi-buildings" style="font-size: 22px;"></i>
                                    <!-- Bootstrap Icon cho Doanh nghiệp -->
                                </div>
                                <div class="chart-num">
                                    <h2 class="mb-0">{{ $count['countCollaboration'] }}</h2>
                                    <p class="mb-0">{{ __('label.company.dashboard.total_collaborations') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card counter">
                            <div class="card-body d-flex align-items-center">
                                <div class="card-box-icon">
                                    <i class="bi bi-briefcase" style="font-size: 22px;"></i> <!-- Bootstrap Icon cho Job -->
                                </div>
                                <div class="chart-num">
                                    <h2 class="font-w600 mb-0"> {{ $count['countJob'] }}</h2>
                                    <p class="mb-0">{{ __('label.company.dashboard.total_jobs_posted') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card counter">
                            <div class="card-body d-flex align-items-center">
                                <div class="card-box-icon">
                                    <i class="bi bi-building" style="font-size: 22px;"></i>
                                </div>
                                <div class="chart-num">
                                    <h2 class="mb-0">{{ $count['countWorkShop'] }}</h2>
                                    <p class="mb-0">{{ __('label.company.dashboard.total_collaborative_workshops') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>


            <div class="row">
                <div class="col-xl-8 wow fadeInUp" data-wow-delay="1.5s"
                    style="visibility: visible; animation-delay: 1.5s; animation-name: fadeInUp;">
                    <div class="card crypto-chart ">
                        <div class="card-header pb-0 border-0 flex-wrap">
                            <div class="mb-2 mb-sm-0">
                                <div class="chart-title mb-3">
                                    <h2 class="card-title">{{ __('label.company.dashboard.job_statistics') }}</h2>
                                </div>
                                <div class="d-flex align-items-center mb-3 mb-sm-0">
                                    <div class="round weekly" id="dzOldSeries">
                                        <div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-static">
                                <div style=" right: 0 !important;left: auto !important;" class="dropdown custom-dropdown">
                                    <div class="btn sharp btn-primary tp-btn " data-bs-toggle="dropdown">
                                        <svg width="5" height="15" viewBox="0 0 6 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.19995 10.001C5.19995 9.71197 5.14302 9.42576 5.03241 9.15872C4.9218 8.89169 4.75967 8.64905 4.55529 8.44467C4.35091 8.24029 4.10828 8.07816 3.84124 7.96755C3.5742 7.85694 3.28799 7.80001 2.99895 7.80001C2.70991 7.80001 2.4237 7.85694 2.15667 7.96755C1.88963 8.07816 1.64699 8.24029 1.44261 8.44467C1.23823 8.64905 1.0761 8.89169 0.965493 9.15872C0.854882 9.42576 0.797952 9.71197 0.797952 10.001C0.798085 10.5848 1.0301 11.1445 1.44296 11.5572C1.85582 11.9699 2.41571 12.2016 2.99945 12.2015C3.58319 12.2014 4.14297 11.9694 4.55565 11.5565C4.96832 11.1436 5.20008 10.5838 5.19995 10L5.19995 10.001ZM5.19995 3.00101C5.19995 2.71197 5.14302 2.42576 5.03241 2.15872C4.9218 1.89169 4.75967 1.64905 4.55529 1.44467C4.35091 1.24029 4.10828 1.07816 3.84124 0.967552C3.5742 0.856941 3.28799 0.800011 2.99895 0.800011C2.70991 0.800011 2.4237 0.856941 2.15667 0.967552C1.88963 1.07816 1.64699 1.24029 1.44261 1.44467C1.23823 1.64905 1.0761 1.89169 0.965493 2.15872C0.854883 2.42576 0.797953 2.71197 0.797953 3.00101C0.798085 3.58475 1.0301 4.14453 1.44296 4.55721C1.85582 4.96988 2.41571 5.20164 2.99945 5.20151C3.58319 5.20138 4.14297 4.96936 4.55565 4.5565C4.96832 4.14364 5.20008 3.58375 5.19995 3.00001L5.19995 3.00101ZM5.19995 17.001C5.19995 16.712 5.14302 16.4258 5.03241 16.1587C4.9218 15.8917 4.75967 15.6491 4.55529 15.4447C4.35091 15.2403 4.10828 15.0782 3.84124 14.9676C3.5742 14.8569 3.28799 14.8 2.99895 14.8C2.70991 14.8 2.4237 14.8569 2.15666 14.9676C1.88963 15.0782 1.64699 15.2403 1.44261 15.4447C1.23823 15.6491 1.0761 15.8917 0.965493 16.1587C0.854882 16.4258 0.797952 16.712 0.797952 17.001C0.798084 17.5848 1.0301 18.1445 1.44296 18.5572C1.85582 18.9699 2.41571 19.2016 2.99945 19.2015C3.58319 19.2014 4.14297 18.9694 4.55565 18.5565C4.96832 18.1436 5.20008 17.5838 5.19995 17L5.19995 17.001Z"
                                                fill="#01A3FF"></path>
                                        </svg>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-end ">
                                        @php
                                            $total = 0;
                                            $totalYear = 0;
                                        @endphp

                                        @foreach ($count['jobsPerYear'] as $y => $m)
                                            <a class="dropdown-item @if ($y == $currentYear) active @endif"
                                                href="javascript:void(0);"
                                                onclick="changeActiveState(this); updateChart({{ json_encode($m) }})">{{ $y }}</a>
                                            @foreach ($m as $item)
                                                @php
                                                    $total += $item;

                                                    if ($y == $currentYear) {
                                                        $totalYear += $item;
                                                        $data = json_encode($m);
                                                    }
                                                @endphp
                                            @endforeach
                                        @endforeach
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="card-body pt-2 custome-tooltip pb-0">
                            <div id="activity"></div>
                        </div>
                    </div>
                </div>
                <!--column-->
                <div class="col-xl-4 wow fadeInUp" data-wow-delay="1s"
                    style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">
                    <div class="card">
                        <div class="card-header border-0">
                            <h2 class="card-title">{{ __('label.company.dashboard.collaborative_university_workshop') }}
                            </h2>

                        </div>
                        <div class="card-body text-center pt-0 pb-2">
                            <div id="pieChart" class="d-inline-block" style="min-height: 182.8px;">
                                @php
                                    $total = $count['countCollaboration'] + $count['countWorkShop'];
                                    $collaborationPercentage =
                                        $total > 0 ? ($count['countCollaboration'] / $total) * 100 : 0;
                                    $workShopPercentage = $total > 0 ? ($count['countWorkShop'] / $total) * 100 : 0;
                                @endphp
                            </div>
                            <div class="chart-items">
                                <!--row-->
                                <div class="row">
                                    <!--column-->
                                    <div class=" col-xl-12 col-sm-12">
                                        <div class="text-start mt-2">
                                            <h6>Legend</h6>
                                            <div class="color-picker">
                                                <p class="mb-0  text-gray">
                                                    <svg class="me-2" width="14" height="14" viewBox="0 0 14 14"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="14" height="14" rx="4"
                                                            fill="#9568FF"></rect>
                                                    </svg>
                                                    {{ __('label.company.dashboard.university') }}
                                                    ({{ number_format($collaborationPercentage, 2) }}%)
                                                </p>
                                                <h6 class="mb-0">{{ $count['countCollaboration'] }}</h6>
                                            </div>
                                            <div class="color-picker">
                                                <p class="mb-0 text-gray">
                                                    <svg class="me-2" width="14" height="14"
                                                        viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect width="14" height="14" rx="4"
                                                            fill="#000"></rect>
                                                    </svg>
                                                    Workshop ({{ number_format($workShopPercentage, 2) }}%)
                                                </p>
                                                <h6 class="mb-0">{{ $count['countWorkShop'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/column-->
                                </div>
                                <!--/row-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--/column-->
            </div>
            <div class="row">
                <!--column-->
                <div class="col-lg-12 wow fadeInUp" data-wow-delay="1.5s"
                    style="visibility: visible; animation-delay: 1.5s; animation-name: fadeInUp;">
                    <!--card-->
                    <div class="card statistic">
                        <div class="row">
                            <div class="col-xl-9">
                                <div class="card-header border-0 flex-wrap pb-2">
                                    <div class="chart-title mb-2 ">
                                        <h2 class="card-title text-white">{{ __('label.company.dashboard.job_matching_university') }} ({{ \Carbon\Carbon::now()->year }})</h2>
                                    </div>
                                </div>
                                <div class="card-body pt-0 custome-tooltip pe-0 pb-0">
                                    <div id="chartBarRunning"></div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="statistic-content">

                                    <div class="statistic-toggle my-3">
                                        <div class="toggle-btn" id="dzExpenseSeries">
                                            <div>
                                                <input type="checkbox" id="checkbox3" name="toggle-btn" value="Income">
                                                <label for="checkbox3" class="check"></label>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-white">
                                                    {{ __('label.company.dashboard.job_received') }}</p>

                                            </div>
                                        </div>
                                        <div class="toggle-btn expense" id="dzIncomeSeries">
                                            <div>
                                                <input type="checkbox" id="checkbox2" name="toggle-btn" value="Expense">
                                                <label for="checkbox2" class="check"></label>
                                            </div>
                                            <div>
                                                <p class="mb-0 text-yellow">{{ __('label.company.dashboard.vacant_job') }}
                                                </p>


                                            </div>
                                        </div>
                                    </div>
                                    <!--card-->
                                    <div class="card expense mb-3">
                                        <div class="card-body p-3">
                                            <div class="students1 d-flex align-items-center justify-content-between ">
                                                <div class="content">
                                                    <p class="mb-0 text-white">
                                                        {{ __('label.company.dashboard.job_received') }}
                                                    </p>
                                                    <h3 class="text-white">{{ array_sum($getJobStats['received_jobs']) }}
                                                    </h3>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/card-->
                                    <!--card-->
                                    <div class="card expense mb-3 ">
                                        <div class="card-body p-3 ">
                                            <div class="students1 d-flex align-items-center justify-content-between ">
                                                <div class="content">
                                                    <p class="mb-0 text-yellow">
                                                        {{ __('label.company.dashboard.vacant_job') }}
                                                    </p>
                                                    <h3 class="text-yellow">
                                                        {{ array_sum($getJobStats['not_received_jobs']) }}</h3>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/card-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/card-->
                </div>
                <!--/column-->
                <!--column-->


            </div>

<div class="card" style="height: 20cm" >
						<div class="card-header d-fex align-items-center">
							<h4 class="card-title">Basic Bar Chart</h4>
                            <BUtton>sad</BUtton>
						</div>
                        <div>
                            
                        </div>
						<div class="card-body">
							<canvas id="barChart_1"  width="400" height="100"></canvas>
						</div>
					</div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var barChart1 = function(){
		if(jQuery('#barChart_1').length > 0 ){
			const barChart_1 = document.getElementById("barChart_1").getContext('2d');
    
			barChart_1.height = 100;

			new Chart(barChart_1, {
				type: 'bar',
				data: {
					defaultFontFamily: 'Poppins',
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
					datasets: [
						{
							label: "My First dataset",
							data: [65, 59, 80, 81, 56, 55, 40],
                            
							borderColor: 'rgba(1,163,255,1))',
							borderWidth: "0",
							backgroundColor: 'rgba(1,163,255,1)',
							barPercentage: 0.5
						}
                        
					]
				},
				options: {
					plugins:{
						legend: false, 
					},
					scales: {
						y: {
							ticks: {
								beginAtZero: true
							}
						},
						x: {
							// Change here
							barPercentage: 0.5
						}
					}
				}
			});
		}
	}
    jQuery(document).ready(function() {
            barChart1();
        });
        
        let dzchart = null;
        
        var activity = function(data) {
            let month = ["Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ]
            month = month.slice(0, data.length);
            var optionsArea = {
                series: [{
                    name: "Jobs",
                    data: data,
                }, ],
                chart: {
                    height: 300,
                    type: "area",
                    group: "social",
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: [3, 3, 3],
                    colors: ["var(--secondary)", "var(--primary)"],
                    curve: "straight",
                },
                legend: {
                    show: false,
                    tooltipHoverFormatter: function(val, opts) {
                        return (
                            val +
                            " - " +
                            opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
                            ""
                        );
                    },
                    markers: {
                        fillColors: ["var(--secondary)", "var(--primary)"],
                        width: 10,
                        height: 10,
                        strokeWidth: 0,
                        radius: 16,
                    },
                },
                markers: {
                    size: [8, 8],
                    strokeWidth: [4, 4],
                    strokeColors: ["var(--secondary)", "var(--primary)"],
                    border: 2,
                    radius: 2,
                    colors: ["#fff", "#fff", "#fff"],
                    hover: {
                        size: 10,
                    },
                },
                xaxis: {
                    categories: month,
                    labels: {
                        style: {
                            colors: "var(--text)",
                            fontSize: "14px",
                            fontFamily: "Poppins",
                            fontWeight: 100,
                        },
                    },
                    axisBorder: {
                        show: false,
                    },
                },
                yaxis: {
                    labels: {
                        minWidth: 20,
                        offsetX: -16,
                        style: {
                            colors: "var(--text)",
                            fontSize: "14px",
                            fontFamily: "Poppins",
                            fontWeight: 100,
                        },
                    },
                },
                fill: {
                    colors: ["#fff", "#fff"],
                    type: "gradient",
                    opacity: 1,
                    gradient: {
                        shade: "light",
                        shadeIntensity: 1,
                        colorStops: [
                            [{
                                    offset: 0,
                                    color: "#fff",
                                    opacity: 0,
                                },
                                {
                                    offset: 0.6,
                                    color: "#fff",
                                    opacity: 0,
                                },
                                {
                                    offset: 100,
                                    color: "#fff",
                                    opacity: 0,
                                },
                            ],
                            [{
                                    offset: 0,
                                    color: "#fff",
                                    opacity: 0.4,
                                },
                                {
                                    offset: 50,
                                    color: "#fff",
                                    opacity: 0.25,
                                },
                                {
                                    offset: 100,
                                    color: "#fff",
                                    opacity: 0,
                                },
                            ],
                        ],
                    },
                },
                colors: ["#1EA7C5", "#FF9432"],
                grid: {
                    borderColor: "var(--border)",
                    xaxis: {
                        lines: {
                            show: true,
                        },
                    },
                    yaxis: {
                        lines: {
                            show: false,
                        },
                    },
                },

                responsive: [{
                    breakpoint: 1602,
                    options: {
                        markers: {
                            size: [6, 6, 4],
                            hover: {
                                size: 7,
                            },
                        },
                        chart: {
                            height: 230,
                        },
                    },
                }, ],
            };
            if (jQuery("#activity").length > 0) {
                dzchart = new ApexCharts(
                    document.querySelector("#activity"),
                    optionsArea
                );
                dzchart.render();
            }
        };
        var receivedJobsData = @json($getJobStats['received_jobs']);
        var notReceivedJobsData = @json($getJobStats['not_received_jobs']);
        var receivedJobsArray = Object.values(receivedJobsData);
        var notReceivedJobsArray = Object.values(notReceivedJobsData);

        var chartBarRunning = function() {
            var options = {
                series: [{
                        name: "Job đã nhận",
                        data: receivedJobsArray,
                    },
                    {
                        name: "Job còn trống",
                        data: notReceivedJobsArray,
                    },
                ],
                chart: {
                    type: "bar",
                    height: 350,

                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        endingShape: "rounded",
                        columnWidth: "45%",
                        borderRadius: 5,
                    },
                },
                colors: ["#", "#77248B"],
                dataLabels: {
                    enabled: false,
                },
                markers: {
                    shape: "circle",
                },
                legend: {
                    show: false,
                    fontSize: "12px",
                    labels: {
                        colors: "#000000",
                    },
                    markers: {
                        width: 30,
                        height: 30,
                        strokeWidth: 0,
                        strokeColor: "#fff",
                        fillColors: undefined,
                        radius: 35,
                    },
                },
                stroke: {
                    show: true,
                    width: 6,
                    colors: ["transparent"],
                },
                grid: {
                    borderColor: "rgba(252, 252, 252,0.2)",
                },
                xaxis: {
                    categories: [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nav",
                        "Dec",
                    ],
                    labels: {
                        style: {
                            colors: "#ffffff",
                            fontSize: "13px",
                            fontFamily: "poppins",
                            fontWeight: 100,
                            cssClass: "apexcharts-xaxis-label",
                        },
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                        borderType: "solid",
                        color: "#78909C",
                        height: 6,
                        offsetX: 0,
                        offsetY: 0,
                    },
                    crosshairs: {
                        show: false,
                    },
                },
                yaxis: {
                    labels: {
                        offsetX: -16,
                        style: {
                            colors: "#ffffff",
                            fontSize: "13px",
                            fontFamily: "poppins",
                            fontWeight: 100,
                            cssClass: "apexcharts-xaxis-label",
                        },
                    },
                },
                fill: {
                    opacity: 1,
                    colors: ["#ffffff", "#FFD125"],
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val;
                        },
                    },
                },
                responsive: [{
                    breakpoint: 575,
                    options: {
                        plotOptions: {
                            bar: {
                                columnWidth: "1%",
                                borderRadius: -1,
                            },
                        },
                        chart: {
                            height: 250,
                        },
                        series: [{
                                name: "Projects",
                                data: receivedJobsArray,
                            },
                            {
                                name: "Projects",
                                data: notReceivedJobsArray,
                            },
                        ],
                    },
                }, ],
            };

            if (jQuery("#chartBarRunning").length > 0) {
                var chart = new ApexCharts(
                    document.querySelector("#chartBarRunning"),
                    options
                );
                chart.render();

                jQuery("#dzIncomeSeries").on("change", function() {
                    jQuery(this).toggleClass("disabled");
                    chart.toggleSeries("Job đã nhận");
                });

                jQuery("#dzExpenseSeries").on("change", function() {
                    jQuery(this).toggleClass("disabled");
                    chart.toggleSeries("Job còn trống");
                });
            }
        };

        var pieChart = function() {
            var options = {
                series: [{{ $collaborationPercentage }}, {{ $workShopPercentage }}],
                chart: {
                    type: "donut",
                    height: 200,
                    innerRadius: 50,
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 0,
                },
                plotOptions: {
                    pie: {
                        startAngle: 0,
                        endAngle: 360,
                        donut: {
                            size: "80%",
                        },
                    },
                },
                colors: ["#2A353A", "#9568FF"],
                legend: {
                    position: "bottom",
                    show: false,
                },
                responsive: [{
                    breakpoint: 768,
                    options: {
                        chart: {
                            width: 200,
                        },
                    },
                }, ],
            };

            var chart = new ApexCharts(document.querySelector("#pieChart"), options);
            chart.render();
        };

        pieChart()

        chartBarRunning()

        function updateChart(data) {
            if (dzchart !== null) {
                dzchart.destroy(); // This removes the current chart
            }
            data = Object.values(data)


            activity(data)

        }

        updateChart({!! $data !!})


        function changeActiveState(selectedElement) {
            // Find all elements with class "active" and remove the class
            document.querySelectorAll(".dropdown-item.active").forEach((el) => {
                el.classList.remove("active");
            });

            // Add "active" class to the selected element
            selectedElement.classList.add("active");
        }
    </script>
    
@endsection
