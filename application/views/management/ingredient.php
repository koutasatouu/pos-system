<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ingredient Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Management</li>
                        <li class="breadcrumb-item active">Ingredients</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Raw Ingredients</h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#newIngredientModal">
                                <i class="fas fa-plus"></i> Add New Ingredient
                            </button>

                            <table id="table-2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Ingredient Name</th>
                                        <th>Unit</th>
                                        <th>Current Stock</th>
                                        <th>Min. Stock Alert</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($ingredients as $ing) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($ing['name']); ?></td>
                                            <td><span class="badge badge-info"><?= htmlspecialchars($ing['unit']); ?></span></td>
                                            <td>
                                                <?php if ($ing['current_stock'] <= $ing['min_stock']) : ?>
                                                    <span class="text-danger font-weight-bold"><?= $ing['current_stock']; ?></span>
                                                    <i class="fas fa-exclamation-circle text-danger" title="Low Stock!"></i>
                                                <?php else : ?>
                                                    <span class="text-success"><?= $ing['current_stock']; ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $ing['min_stock']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning btn-edit" data-id="<?= $ing['id']; ?>" data-name="<?= htmlspecialchars($ing['name'], ENT_QUOTES); ?>" data-unit="<?= htmlspecialchars($ing['unit'], ENT_QUOTES); ?>" data-min_stock="<?= $ing['min_stock']; ?>" data-toggle="modal" data-target="#editIngredientModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $ing['id']; ?>" data-name="<?= htmlspecialchars($ing['name'], ENT_QUOTES); ?>" data-toggle="modal" data-target="#deleteIngredientModal">
                                                    <i class="fas fa-trash"></i>
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

<div class="modal fade" id="newIngredientModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Ingredient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('management/ingredient'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Ingredient Name</label>
                        <input type="text" class="form-control" name="name" placeholder="e.g. Fresh Milk, Espresso Beans" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="form-control" name="unit">
                                    <option value="gram">Gram (g)</option>
                                    <option value="ml">Milliliter (ml)</option>
                                    <option value="pcs">Pieces (pcs)</option>
                                    <option value="kg">Kilogram (kg)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Min. Stock Alert</label>
                                <input type="number" step="0.01" class="form-control" name="min_stock" placeholder="e.g. 1000" required>
                                <small class="text-muted">Notify when stock falls below this.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editIngredientModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Ingredient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('management/ingredient_edit'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Ingredient Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="form-control" id="edit_unit" name="unit">
                                    <option value="gram">Gram (g)</option>
                                    <option value="ml">Milliliter (ml)</option>
                                    <option value="pcs">Pieces (pcs)</option>
                                    <option value="kg">Kilogram (kg)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Min. Stock Alert</label>
                                <input type="number" step="0.01" class="form-control" id="edit_min_stock" name="min_stock" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteIngredientModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Ingredient</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('management/ingredient_delete'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_id">
                    <p>Are you sure you want to delete <strong id="delete_name"></strong>?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>