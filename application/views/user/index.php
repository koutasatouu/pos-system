<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url($user['role_id'] == 1 ? 'admin' : 'user') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">My Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?= base_url('assets/img/profile/') . $user['image'] ?>" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?= $user['name'] ?></h3>

                            <p class="text-muted text-center">
                                <?= $user['role_id'] == 1 ? "Administrator" : "Member" ?>
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right"><?= $user['email'] ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Member Since</b> <a class="float-right"><?= date('d F Y', $user['date_created']); ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Status</b>
                                    <a class="float-right">
                                        <?php if ($user['is_active'] == 1) : ?>
                                            <span class="badge badge-success">Active</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger">Inactive</span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            </ul>

                            <a href="<?= base_url('user/edit') ?>" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                            <a href="<?= base_url('user/changepassword') ?>" class="btn btn-warning btn-block"><b>Change Password</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <div class="card-body">
                            <strong>
                                <i class="fas fa-book mr-1"></i>
                                Biography
                            </strong>
                            <p class="text-muted">
                                <?= $user['about'] ? $user['about'] : '<span class="font-italic text-black-50">No biography added yet.</span>' ?>
                            </p>
                            <hr>
                            <strong><i class="fas fa-phone mr-1"></i>
                                Phone Number
                            </strong>
                            <p class="text-muted">
                                <?= $user['phone_number'] ? $user['phone_number'] : '<span class="font-italic text-black-50">No phone number.</span>' ?>
                            </p>
                            <hr>
                            <strong>
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                Account Type
                            </strong>
                            <p class="text-muted">
                                <?= $user['role_id'] == 1 ? "System Administrator" : "Standard User" ?>
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <a href="<?= base_url('user/logout') ?>" class="btn btn-danger btn-block"><b>Logout</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>