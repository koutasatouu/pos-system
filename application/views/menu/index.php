<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Menu Management</h1>
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
                        <li class="breadcrumb-item active">Menu Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                If you want it, then you'll have to take it
                            </h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-sm btn-info mb-2" data-toggle="modal" data-target="#menuModal">
                                <i class="fas fa-plus"></i> Add New Menu
                            </button>
                            <table id="table-2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Menu</th>
                                        <th>Action(s)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($menu as $m) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $m['menu'] ?></td>
                                            <td>
                                                <?php
                                                $subs = array_filter($submenu, function ($s) use ($m) {
                                                    return $s['menu_id'] == $m['id'];
                                                });
                                                $subs_titles = array_map(function ($s) {
                                                    return $s['title'];
                                                }, $subs);
                                                ?>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-menu" data-id="<?= $m['id'] ?>" data-menu="<?= htmlspecialchars($m['menu'], ENT_QUOTES) ?>" data-submenus='<?= json_encode($subs_titles) ?>'>
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Menu</th>
                                        <th>Action(s)</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="menuModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" placeholder="Title..." name="menu">
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
    </div>
</div>
<div class="modal fade" id="deleteMenuModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('menu/delete') ?>" method="post">
                <input type="hidden" name="id" value="">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Menu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete menu <strong class="menu-name"></strong>?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>