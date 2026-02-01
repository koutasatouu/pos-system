<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <?php if ($user['role_id'] == 1) {
                                echo '<a href="' . base_url('admin') . '">Home</a>';
                            } else {
                                echo '<a href="' . base_url('user') . '">Home</a>';
                            } ?>
                        </li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dashboard Overview</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <?php
                // safe defaults
                $stats = isset($stats) ? $stats : ['sales' => 0, 'orders' => 0, 'products' => 0, 'customers' => 0];
                if (!isset($chartLabels)) {
                    $chartLabels = [];
                    for ($i = 29; $i >= 0; $i--) {
                        $chartLabels[] = date('M j', strtotime("-$i days"));
                    }
                }
                if (!isset($chartData)) {
                    $chartData = array_fill(0, 30, 0);
                }
                ?>

                <!-- Stat boxes -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo number_format($stats['sales']); ?></h3>
                                <p>Total Sales</p>
                            </div>
                            <div class="icon"><i class="ion ion-bag"></i></div>
                            <a href="<?php echo base_url('admin/sales'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo number_format($stats['orders']); ?></h3>
                                <p>Orders</p>
                            </div>
                            <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                            <a href="<?php echo base_url('admin/orders'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo number_format($stats['products']); ?></h3>
                                <p>Products</p>
                            </div>
                            <div class="icon"><i class="fas fa-box"></i></div>
                            <a href="<?php echo base_url('admin/products'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo number_format($stats['customers']); ?></h3>
                                <p>Customers</p>
                            </div>
                            <div class="icon"><i class="fas fa-users"></i></div>
                            <a href="<?php echo base_url('admin/customers'); ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Chart & Recent Orders -->
                <div class="row">
                    <section class="col-lg-7 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sales (Last 30 days)</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="salesChart" style="height:230px; min-height:230px"></canvas>
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-5 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recent Orders</h3>
                            </div>
                            <div class="card-body table-responsive p-0" style="height:230px;">
                                <?php if (!empty($recent_orders)) { ?>
                                    <table class="table table-head-fixed text-nowrap">
                                        <tbody>
                                            <?php foreach ($recent_orders as $order) { ?>
                                                <tr>
                                                    <td>#<?php echo $order['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($order['total']); ?></td>
                                                    <td><?php echo date('M j', strtotime($order['date'])); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p class="text-muted m-3">No recent orders</p>
                                <?php } ?>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Quick actions -->
                <div class="row mt-3">
                    <div class="col-12">
                        <a class="btn btn-app bg-success" href="<?php echo base_url('admin/products'); ?>"><i class="fas fa-box"></i> Products</a>
                        <a class="btn btn-app bg-primary" href="<?php echo base_url('admin/orders'); ?>"><i class="fas fa-shopping-cart"></i> Orders</a>
                        <a class="btn btn-app bg-warning" href="<?php echo base_url('admin/customers'); ?>"><i class="fas fa-users"></i> Customers</a>
                        <a class="btn btn-app bg-danger" href="<?php echo base_url('admin/reports'); ?>"><i class="fas fa-chart-line"></i> Reports</a>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <!-- optional footer -->
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <!-- Chart.js (CDN) and init script -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function() {
                var ctx = document.getElementById('salesChart');
                if (!ctx) return;
                var labels = <?php echo json_encode($chartLabels); ?>;
                var data = <?php echo json_encode($chartData); ?>;
                new Chart(ctx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Sales',
                            data: data,
                            fill: true,
                            backgroundColor: 'rgba(60,141,188,0.2)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: 2
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            })();
        </script>
        <!-- /.content -->
</div>
<!-- /.content-wrapper -->