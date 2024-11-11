<?php 
session_start();
include "includes/header.php";
require_once 'model/User.php';
require_once 'model/Orders.php';
require_once 'model/Product.php';

$user = new User();
$order = new Order(); // Class name should be `Orders` as per your provided methods
$product = new Product();

// Fetching data using the new methods
$totalSales = $order->getTotalSales();
$totalOrders = $order->getOrderCount();
$activeUserCount = $user->countActiveUsers();
// $monthlySalesData = $order->getMonthlySales();
// $monthlySalesData=$order->getLastMonthSales();
// For chart data
// $months = json_encode(array_column($monthlySalesData, 'month'));
// $sales = json_encode(array_column($monthlySalesData, 'total_sales'));
?>

<!-- Replace the hardcoded numbers in the cards with dynamic data -->

<!-- Example of replacing static sales and orders with dynamic data -->

 <style>
    .card {
    background-color: #fff;
    border-radius: 10px;
    border: none;
    position: relative;
    margin-bottom: 30px;
    box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
}
.l-bg-cherry {
    background: linear-gradient(to right, #493240, #f09) !important;
    color: #fff;
}

.l-bg-blue-dark {
    background: linear-gradient(to right, #373b44, #4286f4) !important;
    color: #fff;
}

.l-bg-green-dark {
    background: linear-gradient(to right, #0a504a, #38ef7d) !important;
    color: #fff;
}

.l-bg-orange-dark {
    background: linear-gradient(to right, #a86008, #ffba56) !important;
    color: #fff;
}

.card .card-statistic-3 .card-icon-large .fas, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal {
    font-size: 110px;
}

.card .card-statistic-3 .card-icon {
    text-align: center;
    line-height: 50px;
    margin-left: 15px;
    color: #000;
    position: absolute;
    right: -5px;
    top: 20px;
    opacity: 0.1;
}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
}

.l-bg-green {
    background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
    color: #fff;
}

.l-bg-orange {
    background: linear-gradient(to right, #f9900e, #ffba56) !important;
    color: #fff;
}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
}
 </style>

 <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-md-6 col-8 align-self-center">
                     
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">
                      
                    </div>
                </div>
            </div>
            
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales chart -->
                <div class="row">
    <div class="row ">
    <div class="col-xl-6 col-lg-6">
    <div class="card l-bg-cherry">
        <div class="card-statistic-3 p-4">
            <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
            <div class="mb-4">
                <h5 class="card-title mb-0">Total Sales</h5>
            </div>
            <div class="row align-items-center mb-2 d-flex">
                <div class="col-8">
                    <h2 class="d-flex align-items-center mb-0">
                        <?php echo number_format($totalSales, 2); ?> <!-- Dynamically display total sales -->
                    </h2>
                </div>
                
            </div>
            <div class="progress mt-1 " data-height="8" style="height: 8px;">
                <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-6 col-lg-6">
    <div class="card l-bg-blue-dark">
        <div class="card-statistic-3 p-4">
            <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
            <div class="mb-4">
                <h5 class="card-title mb-0">Orders</h5>
            </div>
            <div class="row align-items-center mb-2 d-flex">
                <div class="col-8">
                    <h2 class="d-flex align-items-center mb-0">
                        <?php echo $totalOrders; ?> <!-- Dynamically display total orders -->
                    </h2>
                </div>
            </div>
            <div class="progress mt-1 " data-height="8" style="height: 8px;">
                <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
            </div>
        </div>
    </div>
</div>
 
<div class="col-xl-6 col-lg-6">
    <div class="card l-bg-blue-dark">
        <div class="card-statistic-3 p-4">
            <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
            <div class="mb-4">
                <h5 class="card-title mb-0">Active users</h5>
            </div>
            <div class="row align-items-center mb-2 d-flex">
                <div class="col-8">
                    <h2 class="d-flex align-items-center mb-0">
                        <?php echo $activeUserCount; ?> <!-- Dynamically display total orders -->
                    </h2>
                </div>
            </div>
            <div class="progress mt-1 " data-height="8" style="height: 8px;">
                <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
            </div>
        </div>
    </div>
</div>
 
 
 
</div>
               
                <!-- ============================================================== -->
               
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div>
                                                <h3 class="card-title">Sales Overview</h3>
                                                <h6 class="card-subtitle">Ample Admin Vs Pixel Admin</h6>
                                            </div>
                                            <div class="ms-lg-auto mx-sm-auto mx-lg-0">
                                                <ul class="list-inline d-flex">
                                                    <li class="me-4">
                                                        <h6 class="text-success"><i
                                                                class="fa fa-circle font-10 me-2 "></i>Ample</h6>
                                                    </li>
                                                    <li>
                                                        <h6 class="text-info"><i
                                                                class="fa fa-circle font-10 me-2"></i>Pixel</h6>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="amp-pxl" style="height: 360px;">
                                            <div class="chartist-tooltip"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                <!-- ============================================================== -->

              
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
        
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <?php 
 include "includes/footer.php";
 ?>