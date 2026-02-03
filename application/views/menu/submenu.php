<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>DataTables</h1>
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
                        <li class="breadcrumb-item active">Submenu Management</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                But you'd already knew that
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-sm btn-info mb-2" data-toggle="modal" data-target="#subMenuModal">
                                <i class="fas fa-plus"></i> Add New Submenu
                            </button>
                            <table id="table-2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ttile</th>
                                        <th>Menu</th>
                                        <th>Url</th>
                                        <th>Icon</th>
                                        <th>Active</th>
                                        <th>Action(s)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($submenu as $sm) : ?>
                                        <tr>
                                            <td>
                                                <?php static $i = 0;
                                                echo ++$i; ?>
                                            </td>
                                            <td><?= $sm['title'] ?></td>
                                            <td><?= $sm['menu'] ?></td>
                                            <td>
                                                <a href="<?= base_url($sm['url']) ?>"><?= $sm['url'] ?></a>
                                            <td>
                                                <i class="<?= $sm['icon'] ?> text-info"></i>
                                            </td>
                                            <td>
                                                <?php if ($sm['is_active'] == 1) : ?>
                                                    <i class="fas fa-check text-success"></i>
                                                <?php else : ?>
                                                    <i class="fas fa-xmark text-danger"></i>
                                                <?php endif; ?>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-primary btn-edit-submenu" data-id="<?= $sm['id'] ?>" data-title="<?= htmlspecialchars($sm['title'], ENT_QUOTES) ?>" data-menu_id="<?= $sm['menu_id'] ?>" data-url="<?= htmlspecialchars($sm['url'], ENT_QUOTES) ?>" data-icon="<?= htmlspecialchars($sm['icon'], ENT_QUOTES) ?>" data-active="<?= $sm['is_active'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-submenu" data-id="<?= $sm['id'] ?>" data-title="<?= htmlspecialchars($sm['title'], ENT_QUOTES) ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Ttile</th>
                                        <th>Menu</th>
                                        <th>Url</th>
                                        <th>Icon</th>
                                        <th>Active</th>
                                        <th>Action(s)</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- /.modal -->
<div class="modal fade" id="subMenuModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Submenu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" placeholder="Title..." name="title">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>On Menu</label>
                                <select class="form-control" name="menu_id" id="menu_id">
                                    <?php foreach ($menu as $m) : ?>
                                        <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Url</label>
                                <input type="text" class="form-control" placeholder="Submenu url..." name="url">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Icon</label>
                                <input type="text" class="form-control" placeholder="Icon name..." name="icon">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                                    <label class="form-check-label">Active?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Edit Submenu Modal -->
<div class="modal fade" id="editSubMenuModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('menu/editsubmenu') ?>" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Submenu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" placeholder="Title..." name="title">
                    </div>
                    <div class="form-group">
                        <label>On Menu</label>
                        <select class="form-control" name="menu_id">
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Url</label>
                        <input type="text" class="form-control" placeholder="Submenu url..." name="url">
                    </div>
                    <div class="form-group">
                        <label>Icon</label>
                        <input type="text" class="form-control" placeholder="Icon name..." name="icon">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1">
                            <label class="form-check-label">Active?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Delete Submenu Modal -->
<div class="modal fade" id="deleteSubMenuModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('menu/deletesubmenu') ?>" method="post">
                <input type="hidden" name="id" value="">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Submenu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete submenu <strong class="submenu-name"></strong>?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>