<style>
    .product-card {
        cursor: pointer;
        transition: 0.2s;
    }

    .product-card:hover {
        transform: scale(1.02);
        border-color: #007bff;
    }

    .scroll-area {
        height: 65vh;
        overflow-y: auto;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cashier Area</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <h4 class="text-primary font-weight-bold"><?= $invoice; ?></h4>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-7">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <input type="text" id="search" class="form-control" placeholder="Search menu...">
                        </div>
                        <div class="card-body bg-light scroll-area">
                            <div class="row" id="product-grid">
                                <?php foreach ($products as $p) : ?>
                                    <div class="col-md-4 col-sm-6 product-item" data-name="<?= strtolower($p['name']); ?>">
                                        <div class="card product-card mb-3" onclick="addToCart(<?= $p['id']; ?>, '<?= $p['name']; ?>', <?= $p['price']; ?>)">

                                            <?php $img = $p['image'] ? $p['image'] : 'default.jpg'; ?>
                                            <img src="<?= base_url('assets/img/product/') . $img; ?>" class="card-img-top" style="height: 100px; object-fit: cover;">

                                            <div class="card-body p-2 text-center">
                                                <h6 class="font-weight-bold mb-0 text-truncate"><?= $p['name']; ?></h6>
                                                <small class="text-success font-weight-bold">Rp <?= number_format($p['price'], 0, ',', '.'); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <form action="<?= base_url('purchase/process_cashier'); ?>" method="post">
                        <input type="hidden" name="invoice" value="<?= $invoice; ?>">

                        <div class="card card-warning card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Current Order</h3>
                            </div>
                            <div class="card-body p-0 scroll-area" style="height: 40vh;">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th width="20%">Qty</th>
                                            <th class="text-right">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart-table">
                                        <tr id="empty-cart">
                                            <td colspan="4" class="text-center text-muted">Cart is empty</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="d-flex justify-content-between mb-2">
                                    <h5>Grand Total:</h5>
                                    <h5 class="text-primary font-weight-bold" id="display-total">Rp 0</h5>
                                    <input type="hidden" name="final_amount" id="input-total" value="0">
                                </div>

                                <div class="form-group">
                                    <select name="member_id" class="form-control select2">
                                        <option value="">-- Guest Customer --</option>
                                        <?php foreach ($members as $m) : ?>
                                            <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="customer_name" class="form-control" placeholder="Customer Name (Optional)">
                                </div>

                                <button type="submit" class="btn btn-success btn-block btn-lg">
                                    <i class="fas fa-money-bill-wave"></i> PAY NOW
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>