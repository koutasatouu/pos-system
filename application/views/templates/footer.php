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
<!-- category edit -->
<script>
    // Pass data to Edit Modal
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#editCategoryModal #edit_id').val(id);
        $('#editCategoryModal #edit_name').val(name);
    });

    // Pass data to Delete Modal
    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#deleteCategoryModal #delete_id').val(id);
        $('#deleteCategoryModal #delete_name').text(name);
    });
</script>
<script>
    // Handle Edit Modal Data
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const phone = $(this).data('phone');
        const address = $(this).data('address');
        const description = $(this).data('description');

        $('#editSupplierModal #edit_id').val(id);
        $('#editSupplierModal #edit_name').val(name);
        $('#editSupplierModal #edit_phone').val(phone);
        $('#editSupplierModal #edit_address').val(address);
        $('#editSupplierModal #edit_description').val(description);
    });

    // Handle Delete Modal Data
    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#deleteSupplierModal #delete_id').val(id);
        $('#deleteSupplierModal #delete_name').text(name);
    });
</script>

<script>
    // Handle Edit Data
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const unit = $(this).data('unit');
        const min_stock = $(this).data('min_stock');

        $('#editIngredientModal #edit_id').val(id);
        $('#editIngredientModal #edit_name').val(name);
        $('#editIngredientModal #edit_unit').val(unit);
        $('#editIngredientModal #edit_min_stock').val(min_stock);
    });

    // Handle Delete Data
    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#deleteIngredientModal #delete_id').val(id);
        $('#deleteIngredientModal #delete_name').text(name);
    });
</script>

<script>
    // Handle Edit Data
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const phone = $(this).data('phone');
        const email = $(this).data('email');
        const active = $(this).data('is_active');

        $('#editMemberModal #edit_id').val(id);
        $('#editMemberModal #edit_name').val(name);
        $('#editMemberModal #edit_phone').val(phone);
        $('#editMemberModal #edit_email').val(email);
        $('#editMemberModal #edit_active').val(active);
    });

    // Handle Delete Data
    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#deleteMemberModal #delete_id').val(id);
        $('#deleteMemberModal #delete_name').text(name);
    });
</script>

<script>
    // 1. File Input Name Fix (Bootstrap Custom File Input)
    // This makes the filename appear when you select an image
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    // 2. Handle Edit Data
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const price = $(this).data('price');
        const category = $(this).data('category');
        const available = $(this).data('available');

        $('#editProductModal #edit_id').val(id);
        $('#editProductModal #edit_name').val(name);
        $('#editProductModal #edit_price').val(price);
        $('#editProductModal #edit_category').val(category);
        $('#editProductModal #edit_available').val(available);
    });

    // 3. Handle Delete Data
    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#deleteProductModal #delete_id').val(id);
        $('#deleteProductModal #delete_name').text(name);
    });
</script>
<script>
    $(document).ready(function() {

        // Data from PHP to JS
        const ingredients = <?= json_encode($ingredients); ?>;

        // 1. Function to add a row
        $('#add-row').click(function() {
            let options = '<option value="">Select Item</option>';
            ingredients.forEach(function(ing) {
                options += `<option value="${ing.id}" data-unit="${ing.unit}">${ing.name}</option>`;
            });

            let html = `
        <tr>
            <td>
                <select name="ingredient_id[]" class="form-control ing-select" required>
                    ${options}
                </select>
            </td>
            <td><span class="unit-label">-</span></td>
            <td><input type="number" name="qty[]" class="form-control qty-input" min="0.1" step="any" required></td>
            <td><input type="number" name="price[]" class="form-control price-input" min="0" required></td>
            <td class="subtotal">0</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
        </tr>
    `;
            $('#cart-table').append(html);
        });

        // 2. Remove row
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            calculateTotal();
        });

        // 3. Auto-update Unit Label when Ingredient is selected
        $(document).on('change', '.ing-select', function() {
            let unit = $(this).find(':selected').data('unit');
            $(this).closest('tr').find('.unit-label').text(unit || '-');
        });

        // 4. Calculate Subtotal & Grand Total on input change
        $(document).on('input', '.qty-input, .price-input', function() {
            let row = $(this).closest('tr');
            let qty = parseFloat(row.find('.qty-input').val()) || 0;
            let price = parseFloat(row.find('.price-input').val()) || 0;
            let sub = qty * price;

            row.find('.subtotal').text(sub.toLocaleString('id-ID'));
            calculateTotal();
        });

        function calculateTotal() {
            let total = 0;
            $('#cart-table tr').each(function() {
                let qty = parseFloat($(this).find('.qty-input').val()) || 0;
                let price = parseFloat($(this).find('.price-input').val()) || 0;
                total += (qty * price);
            });
            $('#grand-total').text('Rp ' + total.toLocaleString('id-ID'));
        }
    });
</script>
<script>
    // AJAX for Details
    $('.btn-detail').on('click', function() {
        const id = $(this).data('id');
        const invoice = $(this).data('invoice');

        $('#modal-invoice').text(invoice);
        $('#modal-items').html('<tr><td colspan="3" class="text-center">Loading...</td></tr>');

        $.ajax({
            url: "<?= base_url('purchase/get_details'); ?>",
            type: "post",
            data: {
                id: id
            },
            success: function(response) {
                $('#modal-items').html(response);
            },
            error: function() {
                $('#modal-items').html('<tr><td colspan="3" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    });
</script>
<script>
    // 1. ADD TO CART FUNCTION
    function addToCart(id, name, price) {
        // Remove "Empty Cart" text
        $('#empty-cart').remove();

        // Check if item exists
        let existingRow = $(`#row-${id}`);
        if (existingRow.length > 0) {
            let qtyInput = existingRow.find('.qty-input');
            let newQty = parseInt(qtyInput.val()) + 1;
            qtyInput.val(newQty);
            updateRowTotal(id, price);
        } else {
            // Add new row
            let html = `
            <tr id="row-${id}">
                <td>
                    <span class="font-weight-bold">${name}</span>
                    <input type="hidden" name="product_id[]" value="${id}">
                    <input type="hidden" name="price[]" value="${price}">
                </td>
                <td>
                    <input type="number" name="qty[]" class="form-control form-control-sm qty-input" 
                            value="1" min="1" onchange="updateRowTotal(${id}, ${price})">
                </td>
                <td class="text-right row-total">
                    Rp ${new Intl.NumberFormat('id-ID').format(price)}
                </td>
                <td>
                    <button type="button" class="btn btn-xs btn-danger" onclick="removeRow(${id})">x</button>
                </td>
            </tr>
        `;
            $('#cart-table').append(html);
        }
        calculateGrandTotal();
    }

    // 2. UPDATE ROW TOTAL
    window.updateRowTotal = function(id, price) {
        let row = $(`#row-${id}`);
        let qty = row.find('.qty-input').val();
        let total = qty * price;
        row.find('.row-total').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
        calculateGrandTotal();
    }

    // 3. REMOVE ROW
    window.removeRow = function(id) {
        $(`#row-${id}`).remove();
        calculateGrandTotal();
    }

    // 4. GRAND TOTAL
    function calculateGrandTotal() {
        let total = 0;
        $('.qty-input').each(function() {
            let qty = $(this).val();
            let price = $(this).closest('tr').find('input[name="price[]"]').val();
            total += (qty * price);
        });

        $('#display-total').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
        $('#input-total').val(total);
    }

    // 5. SEARCH FUNCTION
    $('#search').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#product-grid .product-item').filter(function() {
            $(this).toggle($(this).data('name').indexOf(value) > -1)
        });
    });
</script>
<script>
    // AJAX for Order Details
    $('.btn-detail').on('click', function() {
        const id = $(this).data('id');
        const invoice = $(this).data('invoice');

        $('#modal-invoice-num').text(invoice);
        $('#modal-order-items').html('<tr><td colspan="4" class="text-center">Loading data...</td></tr>');

        $.ajax({
            url: "<?= base_url('purchase/get_order_details'); ?>",
            type: "post",
            data: {
                id: id
            },
            success: function(response) {
                $('#modal-order-items').html(response);
            },
            error: function() {
                $('#modal-order-items').html('<tr><td colspan="4" class="text-center text-danger">Failed to load details.</td></tr>');
            }
        });
    });
</script>
</body>

</html>