<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>/assets/dist/js/demo.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        <?php if ($this->session->flashdata('msg')) : ?>
            Toast.fire({
                icon: '<?= $this->session->flashdata('msg_type') ?>',
                title: <?= json_encode($this->session->flashdata('msg')); ?>
            });
        <?php endif; ?>
    });
</script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    $(function() {
        $("#table-2").DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
        });
    });
</script>
<!-- role change -->
<script>
    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');
        $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            },
            error: function(xhr) {
                var title = xhr.status === 403 ? 'Forbidden' : 'Error changing access';
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: title,
                    showConfirmButton: false,
                    timer: 2500
                });
                // revert checkbox state for the clicked menu/role
                $('.form-check-input[data-menu="' + menuId + '"][data-role="' + roleId + '"]').prop('checked', function(i, val) {
                    return !val;
                });
            }
        });
    });
</script>
<!-- edit user -->
<script>
    $('.btn-edit-user').on('click', function() {
        const id = $(this).data('id');
        const role = $(this).data('role');
        const active = $(this).data('active');

        $('#editUserModal #edit_id').val(id);
        $('#editUserModal #edit_role').val(role);
        $('#editUserModal #edit_active').val(active);
    });

    $('.btn-delete-user').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#deleteUserModal #delete_id').val(id);
        $('#deleteUserModal #delete_name').text(name);
    });
</script>
<!-- img update -->
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
<!-- edit + delete role -->
<script>
    $('.btn-edit-role').on('click', function() {
        const id = $(this).data('id');
        const role = $(this).data('role');
        $('#editRoleModal input[name="role_id"]').val(id);
        $('#editRoleModal input[name="role"]').val(role);
        $('#editRoleModal').modal('show');
    });

    $('.btn-delete-role').on('click', function() {
        const id = $(this).data('id');
        const role = $(this).data('role');
        const action = "<?= base_url('admin/deleterole') ?>";
        $('#deleteRoleModal .role-name').text(role);
        $('#deleteRoleModal form').attr('action', action);
        $('#deleteRoleModal input[name="role_id"]').val(id);
        $('#deleteRoleModal').modal('show');
    });
</script>
<!-- submenu add/edit/delete -->
<script>
    $('.btn-edit-submenu').on('click', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const menuId = $(this).data('menu_id');
        const url = $(this).data('url');
        const icon = $(this).data('icon');
        const active = $(this).data('active');

        $('#editSubMenuModal input[name="id"]').val(id);
        $('#editSubMenuModal input[name="title"]').val(title);
        $('#editSubMenuModal select[name="menu_id"]').val(menuId);
        $('#editSubMenuModal input[name="url"]').val(url);
        $('#editSubMenuModal input[name="icon"]').val(icon);
        $('#editSubMenuModal input[name="is_active"]').prop('checked', active == 1);
        $('#editSubMenuModal').modal('show');
    });

    $('.btn-delete-submenu').on('click', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        $('#deleteSubMenuModal .submenu-name').text(title);
        $('#deleteSubMenuModal input[name="id"]').val(id);
        $('#deleteSubMenuModal').modal('show');
    });
</script>
<!-- menu edit -->
<script>
    $('.btn-edit-menu').on('click', function() {
        const id = $(this).data('id');
        const menu = $(this).data('menu');
        $('#editMenuModal input[name="id"]').val(id);
        $('#editMenuModal input[name="menu"]').val(menu);
        $('#editMenuModal').modal('show');
    });
</script>
<!-- menu delete -->
<script>
    $('.btn-delete-menu').on('click', function() {
        const id = $(this).data('id');
        const menu = $(this).data('menu');
        const submenus = $(this).data('submenus');
        $('#deleteMenuModal .menu-name').text(menu);
        $('#deleteMenuModal input[name="id"]').val(id);

        let warningHtml = '';
        if (submenus && submenus.length > 0) {
            warningHtml = '<div class="alert alert-warning mb-2">' +
                '<strong>Warning:</strong> The following submenus will also be deleted:' +
                '<ul>';
            submenus.forEach(function(title) {
                warningHtml += '<li>' + title + '</li>';
            });
            warningHtml += '</ul></div>';
        }
        $('#deleteMenuModal .submenu-warning').html(warningHtml);

        $('#deleteMenuModal').modal('show');
    });
</script>

</body>

</html>