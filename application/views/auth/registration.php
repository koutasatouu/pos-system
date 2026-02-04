<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?= base_url() ?>index2.html" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Register a new account</p>

            <form action="<?= base_url('auth/registration') ?>" method="post">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Full name" name="name" id="name" value="<?= set_value('name') ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                <div class="input-group mt-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?= set_value('email') ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                <div class="input-group mt-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <input type="password" class="form-control" placeholder="Retype password" name="confirm_password" id="confirm_password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                <div class="row mt-3">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                I agree to the <a href="<?= base_url('auth/terms') ?>">terms</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <a href="<?= base_url('') ?>" class="text-center">I already have an account</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>