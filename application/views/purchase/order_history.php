<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Transaction</li>
                        <li class="breadcrumb-item active">Sales History</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">List of Sales Transactions</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('purchase/cashier') ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-cash-register"></i> Back to Cashier
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table-2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Invoice</th>
                                        <th>Date & Time</th>
                                        <th>Customer</th>
                                        <th>Cashier</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($orders as $o) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><span class="badge badge-info"><?= $o['invoice']; ?></span></td>
                                            <td><?= date('d M Y, H:i', strtotime($o['created_at'])); ?></td>
                                            <td>
                                                <strong><?= $o['customer_name']; ?></strong>
                                                <?php if ($o['member_name']) : ?>
                                                    <br><small class="text-success"><i class="fas fa-user-check"></i> <?= $o['member_name']; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $o['cashier_name']; ?></td>
                                            <td class="font-weight-bold text-success">Rp <?= number_format($o['final_amount'], 0, ',', '.'); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning btn-detail" data-id="<?= $o['id']; ?>" data-invoice="<?= $o['invoice']; ?>" data-toggle="modal" data-target="#orderDetailModal">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="orderDetailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sales Receipt: <span id="modal-invoice-num"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="modal-order-items">
                        <tr>
                            <td colspan="4" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="alert('Print feature coming soon!')">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>