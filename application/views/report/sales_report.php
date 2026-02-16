<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Sales Report</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card mb-3">
                <div class="card-body py-3">
                    <form action="" method="get" class="form-inline justify-content-center">
                        <label class="mr-2">From:</label>
                        <input type="date" name="start_date" class="form-control mr-3" value="<?= $start_date; ?>">

                        <label class="mr-2">To:</label>
                        <input type="date" name="end_date" class="form-control mr-3" value="<?= $end_date; ?>">

                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp <?= number_format($grand_total, 0, ',', '.'); ?></h3>
                            <p>Total Revenue (Selected Period)</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daily Sales Breakdown</h3>
                </div>
                <div class="card-body">
                    <table id="table-2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total Transactions</th>
                                <th>Revenue (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($daily_sales as $day) : ?>
                                <tr>
                                    <td><?= date('d F Y', strtotime($day['date'])); ?></td>
                                    <td class="text-center"><?= $day['total_transactions']; ?></td>
                                    <td class="text-right font-weight-bold">
                                        <?= number_format($day['total_revenue'], 0, ',', '.'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <th class="text-right">TOTAL</th>
                                <th></th>
                                <th class="text-right">Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>