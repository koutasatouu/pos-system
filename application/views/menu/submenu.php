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
                                                <a href="<?= base_url('menu/edit/' . $sm['id']) ?>" class="btn btn-xs btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('menu/delete/' . $sm['id']) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
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

                    <!-- checkbox + radio -->
                    <!-- <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label">Checkbox checked</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" disabled>
                                    <label class="form-check-label">Checkbox disabled</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radio1">
                                    <label class="form-check-label">Radio</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radio1" checked>
                                    <label class="form-check-label">Radio checked</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" disabled>
                                    <label class="form-check-label">Radio disabled</label>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- textarea -->
                    <!-- <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Textarea</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Textarea Disabled</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..." disabled></textarea>
                            </div>
                        </div>
                    </div> -->

                    <!-- select -->
                    <!-- <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Select</label>
                                <select class="form-control">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                    <option>option 5</option>
                                </select>
                            </div>
                        </div>
                    </div> -->
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