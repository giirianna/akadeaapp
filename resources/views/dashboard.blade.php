@extends('layouts.app')

@section('content')
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>{{ __('app.dashboard') }}</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('app.home') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->

    <!-- ========== stats cards start ========== -->
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon purple">
                    <i class="lni lni-cart-full"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Total Orders</h6>
                    <h3 class="text-bold mb-10">34,567</h3>
                    <p class="text-sm text-success">
                        <i class="lni lni-arrow-up"></i> +2.00%
                        <span class="text-gray">(30 days)</span>
                    </p>
                </div>
            </div>
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon success">
                    <i class="lni lni-dollar"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Total Income</h6>
                    <h3 class="text-bold mb-10">$74,567</h3>
                    <p class="text-sm text-success">
                        <i class="lni lni-arrow-up"></i> +5.45%
                        <span class="text-gray">Increased</span>
                    </p>
                </div>
            </div>
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon primary">
                    <i class="lni lni-credit-cards"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Total Expense</h6>
                    <h3 class="text-bold mb-10">$24,567</h3>
                    <p class="text-sm text-danger">
                        <i class="lni lni-arrow-down"></i> -2.00%
                        <span class="text-gray">Expense</span>
                    </p>
                </div>
            </div>
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon orange">
                    <i class="lni lni-user"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Total Users</h6>
                    <h3 class="text-bold mb-10">2,345</h3>
                    <p class="text-sm text-success">
                        <i class="lni lni-arrow-up"></i> +12.50%
                        <span class="text-gray">Growth</span>
                    </p>
                </div>
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- ========== stats cards end ========== -->

    <!-- ========== charts row start ========== -->
    <div class="row">
        <div class="col-lg-7">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap justify-content-between">
                    <div class="left">
                        <h6 class="text-medium mb-10">Yearly Stats</h6>
                        <h3 class="text-bold">$245,479</h3>
                    </div>
                    <div class="right">
                        <div class="select-style-1">
                            <div class="select-position select-sm">
                                <select class="light-bg">
                                    <option value="">Yearly</option>
                                    <option value="">Monthly</option>
                                    <option value="">Weekly</option>
                                </select>
                            </div>
                        </div>
                        <!-- end select -->
                    </div>
                </div>
                <!-- End Title -->
                <div class="chart">
                    <canvas id="Chart1" style="width: 100%; height: 400px; margin-left: -35px;"></canvas>
                </div>
                <!-- End Chart -->
            </div>
        </div>
        <!-- End Col -->
        <div class="col-lg-5">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between">
                    <div class="left">
                        <h6 class="text-medium mb-30">Sales/Revenue</h6>
                    </div>
                    <div class="right">
                        <div class="select-style-1">
                            <div class="select-position select-sm">
                                <select class="light-bg">
                                    <option value="">Yearly</option>
                                    <option value="">Monthly</option>
                                    <option value="">Weekly</option>
                                </select>
                            </div>
                        </div>
                        <!-- end select -->
                    </div>
                </div>
                <!-- End Title -->
                <div class="chart">
                    <canvas id="Chart2" style="width: 100%; height: 400px; margin-left: -45px;"></canvas>
                </div>
                <!-- End Chart -->
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- ========== charts row end ========== -->

    <!-- ========== map and products table row start ========== -->
    <div class="row">
        <div class="col-lg-5">
            <div class="card-style mb-30">
                <div class="title d-flex justify-content-between align-items-center">
                    <div class="left">
                        <h6 class="text-medium mb-30">Geographic Sales</h6>
                    </div>
                </div>
                <!-- End Title -->
                <div id="map" style="width: 100%; height: 400px; overflow: hidden;"></div>
                <p>Last updated: 7 days ago</p>
            </div>
        </div>
        <!-- End Col -->
        <div class="col-lg-7">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap justify-content-between align-items-center">
                    <div class="left">
                        <h6 class="text-medium mb-30">Top Products</h6>
                    </div>
                    <div class="right">
                        <div class="select-style-1">
                            <div class="select-position select-sm">
                                <select class="light-bg">
                                    <option value="">Yearly</option>
                                    <option value="">Monthly</option>
                                    <option value="">Weekly</option>
                                </select>
                            </div>
                        </div>
                        <!-- end select -->
                    </div>
                </div>
                <!-- End Title -->
                <div class="table-responsive">
                    <table class="table top-selling-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <h6 class="text-sm text-medium">Products</h6>
                                </th>
                                <th class="min-width">
                                    <h6 class="text-sm text-medium">Category</h6>
                                </th>
                                <th class="min-width">
                                    <h6 class="text-sm text-medium">Price</h6>
                                </th>
                                <th class="min-width">
                                    <h6 class="text-sm text-medium">Sold</h6>
                                </th>
                                <th class="min-width">
                                    <h6 class="text-sm text-medium">Profit</h6>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="check-input-primary">
                                        <input class="form-check-input" type="checkbox" id="checkbox-1" />
                                    </div>
                                </td>
                                <td>
                                    <div class="product">
                                        <div class="image">
                                            <img src="{{ asset('assets/images/products/product-mini-1.jpg') }}" alt="" />
                                        </div>
                                        <p class="text-sm">Arm Chair</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm">Interior</p>
                                </td>
                                <td>
                                    <p class="text-sm">$345</p>
                                </td>
                                <td>
                                    <p class="text-sm">43</p>
                                </td>
                                <td>
                                    <p class="text-sm">$45</p>
                                </td>
                                <td>
                                    <div class="action justify-content-end">
                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="lni lni-more-alt"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Remove</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="check-input-primary">
                                        <input class="form-check-input" type="checkbox" id="checkbox-2" />
                                    </div>
                                </td>
                                <td>
                                    <div class="product">
                                        <div class="image">
                                            <img src="{{ asset('assets/images/products/product-mini-2.jpg') }}" alt="" />
                                        </div>
                                        <p class="text-sm">Sofa</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm">Interior</p>
                                </td>
                                <td>
                                    <p class="text-sm">$145</p>
                                </td>
                                <td>
                                    <p class="text-sm">13</p>
                                </td>
                                <td>
                                    <p class="text-sm">$15</p>
                                </td>
                                <td>
                                    <div class="action justify-content-end">
                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction2"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="lni lni-more-alt"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction2">
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Remove</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="check-input-primary">
                                        <input class="form-check-input" type="checkbox" id="checkbox-3" />
                                    </div>
                                </td>
                                <td>
                                    <div class="product">
                                        <div class="image">
                                            <img src="{{ asset('assets/images/products/product-mini-3.jpg') }}" alt="" />
                                        </div>
                                        <p class="text-sm">Dining Table</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm">Interior</p>
                                </td>
                                <td>
                                    <p class="text-sm">$95</p>
                                </td>
                                <td>
                                    <p class="text-sm">32</p>
                                </td>
                                <td>
                                    <p class="text-sm">$215</p>
                                </td>
                                <td>
                                    <div class="action justify-content-end">
                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction3"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="lni lni-more-alt"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction3">
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Remove</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="check-input-primary">
                                        <input class="form-check-input" type="checkbox" id="checkbox-4" />
                                    </div>
                                </td>
                                <td>
                                    <div class="product">
                                        <div class="image">
                                            <img src="{{ asset('assets/images/products/product-mini-4.jpg') }}" alt="" />
                                        </div>
                                        <p class="text-sm">Office Chair</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm">Interior</p>
                                </td>
                                <td>
                                    <p class="text-sm">$105</p>
                                </td>
                                <td>
                                    <p class="text-sm">23</p>
                                </td>
                                <td>
                                    <p class="text-sm">$345</p>
                                </td>
                                <td>
                                    <div class="action justify-content-end">
                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction4"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="lni lni-more-alt"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction4">
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Remove</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="#0" class="text-gray">Edit</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- End Table -->
                </div>
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- ========== map and products table row end ========== -->

    <!-- ========== forecast and traffic row start ========== -->
    <div class="row">
        <div class="col-lg-7">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between">
                    <div class="left">
                        <h6 class="text-medium mb-2">Sales Forecast</h6>
                    </div>
                    <div class="right">
                        <div class="select-style-1 mb-2">
                            <div class="select-position select-sm">
                                <select class="light-bg">
                                    <option value="">Last Month</option>
                                    <option value="">Last 3 Months</option>
                                    <option value="">Last Year</option>
                                </select>
                            </div>
                        </div>
                        <!-- end select -->
                    </div>
                </div>
                <!-- End Title -->
                <div class="chart">
                    <div id="legend3">
                        <ul class="legend3 d-flex flex-wrap align-items-center mb-30">
                            <li>
                                <div class="d-flex">
                                    <span class="bg-color primary-bg"> </span>
                                    <div class="text">
                                        <p class="text-sm text-success">
                                            <span class="text-dark">Revenue</span> +25.55%
                                            <i class="lni lni-arrow-up"></i>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <span class="bg-color purple-bg"></span>
                                    <div class="text">
                                        <p class="text-sm text-success">
                                            <span class="text-dark">Net Profit</span> +45.55%
                                            <i class="lni lni-arrow-up"></i>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <span class="bg-color orange-bg"></span>
                                    <div class="text">
                                        <p class="text-sm text-danger">
                                            <span class="text-dark">Orders</span> -4.2%
                                            <i class="lni lni-arrow-down"></i>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <canvas id="Chart3" style="width: 100%; height: 450px; margin-left: -35px;"></canvas>
                </div>
            </div>
        </div>
        <!-- End Col -->
        <div class="col-lg-5">
            <div class="card-style mb-30">
                <div class="title d-flex flex-wrap align-items-center justify-content-between">
                    <div class="left">
                        <h6 class="text-medium mb-2">Traffic Overview</h6>
                    </div>
                    <div class="right">
                        <div class="select-style-1 mb-2">
                            <div class="select-position select-sm">
                                <select class="bg-ligh">
                                    <option value="">Last 6 Months</option>
                                    <option value="">Last 3 Months</option>
                                    <option value="">Last Year</option>
                                </select>
                            </div>
                        </div>
                        <!-- end select -->
                    </div>
                </div>
                <!-- End Title -->
                <div class="chart">
                    <div id="legend4">
                        <ul class="legend3 d-flex flex-wrap gap-3 gap-sm-0 align-items-center mb-30">
                            <li>
                                <div class="d-flex">
                                    <span class="bg-color primary-bg"> </span>
                                    <div class="text">
                                        <p class="text-sm text-success">
                                            <span class="text-dark">Store Visits</span>
                                            +25.55%
                                            <i class="lni lni-arrow-up"></i>
                                        </p>
                                        <h2>3456</h2>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex">
                                    <span class="bg-color danger-bg"></span>
                                    <div class="text">
                                        <p class="text-sm text-danger">
                                            <span class="text-dark">Visitors</span> -2.05%
                                            <i class="lni lni-arrow-down"></i>
                                        </p>
                                        <h2>3456</h2>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <canvas id="Chart4" style="width: 100%; height: 420px; margin-left: -35px;"></canvas>
                </div>
                <!-- End Chart -->
            </div>
        </div>
        <!-- End Col -->
    </div>
    <!-- ========== forecast and traffic row end ========== -->

    <!-- ========== chart scripts ========== -->
    <script>
        // Chart 1 - Yearly Stats
        const chart1 = document.getElementById('Chart1');
        if (chart1) {
            new Chart(chart1, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Sales',
                            data: [10, 20, 15, 25, 30, 35, 28, 32, 40, 38, 45, 50],
                            borderColor: '#3C50E0',
                            backgroundColor: 'rgba(60, 80, 224, 0.05)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        }

        // Chart 2 - Sales/Revenue (Pie)
        const chart2 = document.getElementById('Chart2');
        if (chart2) {
            new Chart(chart2, {
                type: 'doughnut',
                data: {
                    labels: ['Direct', 'Referral', 'Social'],
                    datasets: [
                        {
                            data: [30, 25, 45],
                            backgroundColor: ['#3C50E0', '#9B59B6', '#FF7675'],
                            borderWidth: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Chart 3 - Sales Forecast
        const chart3 = document.getElementById('Chart3');
        if (chart3) {
            new Chart(chart3, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Revenue',
                            data: [20, 25, 20, 30, 35, 40, 35, 45, 50, 55, 60, 65],
                            borderColor: '#3C50E0',
                            backgroundColor: 'rgba(60, 80, 224, 0.05)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Net Profit',
                            data: [10, 15, 12, 18, 22, 25, 20, 28, 32, 35, 40, 45],
                            borderColor: '#9B59B6',
                            backgroundColor: 'rgba(155, 89, 182, 0.05)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Orders',
                            data: [15, 18, 14, 22, 26, 30, 25, 33, 38, 40, 45, 50],
                            borderColor: '#FF9D38',
                            backgroundColor: 'rgba(255, 157, 56, 0.05)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        }

        // Chart 4 - Traffic
        const chart4 = document.getElementById('Chart4');
        if (chart4) {
            new Chart(chart4, {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
                    datasets: [
                        {
                            label: 'Store Visits',
                            data: [2000, 2500, 2200, 3000, 3500, 4000],
                            borderColor: '#3C50E0',
                            backgroundColor: 'rgba(60, 80, 224, 0.05)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Visitors',
                            data: [1500, 2000, 1800, 2500, 3000, 3200],
                            borderColor: '#FF7675',
                            backgroundColor: 'rgba(255, 118, 117, 0.05)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5000
                        }
                    }
                }
            });
        }

        // Initialize map
        const mapElement = document.getElementById('map');
        if (mapElement && typeof jsVectorMap !== 'undefined') {
            new jsVectorMap({
                selector: '#map',
                map: 'world_merc',
                regionStyle: {
                    initial: {
                        fill: '#3C50E0'
                    }
                }
            });
        }
    </script>
    <!-- ========== chart scripts end ========== -->

@endsection
