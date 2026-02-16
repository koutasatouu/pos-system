<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>

<aside class="control-sidebar control-sidebar-dark">
</aside>
</div>
<script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<script>
    // Global PHP Variables available to all scripts
    const BASE_URL = "<?= base_url() ?>";

    $(function() {
        // A. Initialize Custom File Input (Filename appears on upload)
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        // B. Initialize DataTables
        $("#table-2").DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
        });

        // C. Initialize SweetAlert Toast
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // Trigger Toast if PHP Flashdata exists
        <?php if ($this->session->flashdata('msg')) : ?>
            Toast.fire({
                icon: '<?= $this->session->flashdata('msg_type') ?>',
                title: <?= json_encode($this->session->flashdata('msg')); ?>
            });
        <?php endif; ?>
    });
</script>


<script>
    // 3.1 Role Access Change (AJAX)
    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: BASE_URL + "/admin/changeaccess",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = BASE_URL + "/admin/roleaccess/" + roleId;
            },
            error: function(xhr) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: xhr.status === 403 ? 'Forbidden' : 'Error changing access',
                    showConfirmButton: false,
                    timer: 2500
                });
                // Revert checkbox if failed
                $('.form-check-input[data-menu="' + menuId + '"][data-role="' + roleId + '"]').prop('checked', function(i, val) {
                    return !val;
                });
            }
        });
    });

    // 3.2 User Management (Edit/Delete)
    $('.btn-edit-user').on('click', function() {
        $('#editUserModal #edit_id').val($(this).data('id'));
        $('#editUserModal #edit_role').val($(this).data('role'));
        $('#editUserModal #edit_active').val($(this).data('active'));
    });

    $('.btn-delete-user').on('click', function() {
        $('#deleteUserModal #delete_id').val($(this).data('id'));
        $('#deleteUserModal #delete_name').text($(this).data('name'));
    });

    // 3.3 Role Management (Edit/Delete)
    $('.btn-edit-role').on('click', function() {
        $('#editRoleModal input[name="role_id"]').val($(this).data('id'));
        $('#editRoleModal input[name="role"]').val($(this).data('role'));
        $('#editRoleModal').modal('show');
    });

    $('.btn-delete-role').on('click', function() {
        const action = BASE_URL + "/admin/deleterole";
        $('#deleteRoleModal form').attr('action', action);
        $('#deleteRoleModal input[name="role_id"]').val($(this).data('id'));
        $('#deleteRoleModal .role-name').text($(this).data('role'));
        $('#deleteRoleModal').modal('show');
    });

    // 3.4 Submenu Management
    $('.btn-edit-submenu').on('click', function() {
        $('#editSubMenuModal input[name="id"]').val($(this).data('id'));
        $('#editSubMenuModal input[name="title"]').val($(this).data('title'));
        $('#editSubMenuModal select[name="menu_id"]').val($(this).data('menu_id'));
        $('#editSubMenuModal input[name="url"]').val($(this).data('url'));
        $('#editSubMenuModal input[name="icon"]').val($(this).data('icon'));
        $('#editSubMenuModal input[name="is_active"]').prop('checked', $(this).data('active') == 1);
        $('#editSubMenuModal').modal('show');
    });

    $('.btn-delete-submenu').on('click', function() {
        $('#deleteSubMenuModal input[name="id"]').val($(this).data('id'));
        $('#deleteSubMenuModal .submenu-name').text($(this).data('title'));
        $('#deleteSubMenuModal').modal('show');
    });

    // 3.5 Menu Management
    $('.btn-edit-menu').on('click', function() {
        $('#editMenuModal input[name="id"]').val($(this).data('id'));
        $('#editMenuModal input[name="menu"]').val($(this).data('menu'));
        $('#editMenuModal').modal('show');
    });

    $('.btn-delete-menu').on('click', function() {
        const submenus = $(this).data('submenus');
        $('#deleteMenuModal input[name="id"]').val($(this).data('id'));
        $('#deleteMenuModal .menu-name').text($(this).data('menu'));

        let warningHtml = '';
        if (submenus && submenus.length > 0) {
            warningHtml = '<div class="alert alert-warning mb-2"><strong>Warning:</strong> The following submenus will also be deleted:<ul>';
            submenus.forEach(t => warningHtml += '<li>' + t + '</li>');
            warningHtml += '</ul></div>';
        }
        $('#deleteMenuModal .submenu-warning').html(warningHtml);
        $('#deleteMenuModal').modal('show');
    });
</script>


<script>
    // 4.1 Categories
    $('.btn-edit[data-target="#editCategoryModal"]').on('click', function() {
        $('#editCategoryModal #edit_id').val($(this).data('id'));
        $('#editCategoryModal #edit_name').val($(this).data('name'));
    });
    $('.btn-delete[data-target="#deleteCategoryModal"]').on('click', function() {
        $('#deleteCategoryModal #delete_id').val($(this).data('id'));
        $('#deleteCategoryModal #delete_name').text($(this).data('name'));
    });

    // 4.2 Suppliers
    $('.btn-edit[data-target="#editSupplierModal"]').on('click', function() {
        $('#editSupplierModal #edit_id').val($(this).data('id'));
        $('#editSupplierModal #edit_name').val($(this).data('name'));
        $('#editSupplierModal #edit_phone').val($(this).data('phone'));
        $('#editSupplierModal #edit_address').val($(this).data('address'));
        $('#editSupplierModal #edit_description').val($(this).data('description'));
    });
    $('.btn-delete[data-target="#deleteSupplierModal"]').on('click', function() {
        $('#deleteSupplierModal #delete_id').val($(this).data('id'));
        $('#deleteSupplierModal #delete_name').text($(this).data('name'));
    });

    // 4.3 Ingredients
    $('.btn-edit[data-target="#editIngredientModal"]').on('click', function() {
        $('#editIngredientModal #edit_id').val($(this).data('id'));
        $('#editIngredientModal #edit_name').val($(this).data('name'));
        $('#editIngredientModal #edit_unit').val($(this).data('unit'));
        $('#editIngredientModal #edit_min_stock').val($(this).data('min_stock'));
        // If you added current_stock in previous step:
        if ($(this).data('current_stock')) {
            $('#editIngredientModal #edit_current_stock').val($(this).data('current_stock'));
        }
    });
    $('.btn-delete[data-target="#deleteIngredientModal"]').on('click', function() {
        $('#deleteIngredientModal #delete_id').val($(this).data('id'));
        $('#deleteIngredientModal #delete_name').text($(this).data('name'));
    });

    // 4.4 Members
    $('.btn-edit[data-target="#editMemberModal"]').on('click', function() {
        $('#editMemberModal #edit_id').val($(this).data('id'));
        $('#editMemberModal #edit_name').val($(this).data('name'));
        $('#editMemberModal #edit_phone').val($(this).data('phone'));
        $('#editMemberModal #edit_email').val($(this).data('email'));
        $('#editMemberModal #edit_active').val($(this).data('is_active'));
    });
    $('.btn-delete[data-target="#deleteMemberModal"]').on('click', function() {
        $('#deleteMemberModal #delete_id').val($(this).data('id'));
        $('#deleteMemberModal #delete_name').text($(this).data('name'));
    });

    // 4.5 Products
    $('.btn-edit[data-target="#editProductModal"]').on('click', function() {
        $('#editProductModal #edit_id').val($(this).data('id'));
        $('#editProductModal #edit_name').val($(this).data('name'));
        $('#editProductModal #edit_price').val($(this).data('price'));
        $('#editProductModal #edit_category').val($(this).data('category'));
        $('#editProductModal #edit_available').val($(this).data('available'));
    });
    $('.btn-delete[data-target="#deleteProductModal"]').on('click', function() {
        $('#deleteProductModal #delete_id').val($(this).data('id'));
        $('#deleteProductModal #delete_name').text($(this).data('name'));
    });
</script>


<?php if (isset($ingredients)) : ?>
    <script>
        $(document).ready(function() {
            // Only run if we are on the Stock In page (check for add-row button)
            if ($('#add-row').length === 0) return;

            const ingredients = <?= json_encode($ingredients); ?>;

            // Add Row
            $('#add-row').click(function() {
                let options = '<option value="">Select Item</option>';
                ingredients.forEach(ing => {
                    options += `<option value="${ing.id}" data-unit="${ing.unit}">${ing.name}</option>`;
                });

                let html = `
                <tr>
                    <td><select name="ingredient_id[]" class="form-control ing-select" required>${options}</select></td>
                    <td><span class="unit-label">-</span></td>
                    <td><input type="number" name="qty[]" class="form-control qty-input" min="0.1" step="any" required></td>
                    <td><input type="number" name="price[]" class="form-control price-input" min="0" required></td>
                    <td class="subtotal">0</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>`;
                $('#cart-table').append(html);
            });

            // Remove Row
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                calculateStockTotal();
            });

            // Update Unit
            $(document).on('change', '.ing-select', function() {
                let unit = $(this).find(':selected').data('unit');
                $(this).closest('tr').find('.unit-label').text(unit || '-');
            });

            // Calculate Totals
            $(document).on('input', '.qty-input, .price-input', function() {
                let row = $(this).closest('tr');
                let qty = parseFloat(row.find('.qty-input').val()) || 0;
                let price = parseFloat(row.find('.price-input').val()) || 0;
                row.find('.subtotal').text((qty * price).toLocaleString('id-ID'));
                calculateStockTotal();
            });

            function calculateStockTotal() {
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
<?php endif; ?>


<script>
    // These functions must be global so the onclick="" in HTML can find them

    // Add Item to Cart
    function addToCart(id, name, price) {
        if ($('#cart-table').length === 0) return; // Prevent error if not on POS page

        $('#empty-cart').remove();
        let existingRow = $(`#row-${id}`);

        if (existingRow.length > 0) {
            let qtyInput = existingRow.find('.qty-input');
            qtyInput.val(parseInt(qtyInput.val()) + 1);
            updateRowTotal(id, price);
        } else {
            let html = `
                <tr id="row-${id}">
                    <td>
                        <span class="font-weight-bold">${name}</span>
                        <input type="hidden" name="product_id[]" value="${id}">
                        <input type="hidden" name="price[]" value="${price}">
                    </td>
                    <td><input type="number" name="qty[]" class="form-control form-control-sm qty-input" value="1" min="1" onchange="updateRowTotal(${id}, ${price})"></td>
                    <td class="text-right row-total">Rp ${new Intl.NumberFormat('id-ID').format(price)}</td>
                    <td><button type="button" class="btn btn-xs btn-danger" onclick="removeRow(${id})">&nbsp;<b>x</b>&nbsp;</button></td>
                </tr>`;
            $('#cart-table').append(html);
        }
        calculatePOSTotal();
    }

    // Update Row Logic
    window.updateRowTotal = function(id, price) {
        let row = $(`#row-${id}`);
        let qty = row.find('.qty-input').val();
        row.find('.row-total').text('Rp ' + new Intl.NumberFormat('id-ID').format(qty * price));
        calculatePOSTotal();
    }

    window.removeRow = function(id) {
        $(`#row-${id}`).remove();
        calculatePOSTotal();
    }

    function calculatePOSTotal() {
        let total = 0;
        $('.qty-input').each(function() {
            let qty = $(this).val();
            let price = $(this).closest('tr').find('input[name="price[]"]').val();
            total += (qty * price);
        });
        $('#display-total').text('Rp ' + new Intl.NumberFormat('id-ID').format(total));
        $('#input-total').val(total);
    }

    // POS Search
    $('#search').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#product-grid .product-item').filter(function() {
            $(this).toggle($(this).data('name').indexOf(value) > -1)
        });
    });
</script>

<script>
    $('.btn-detail').on('click', function() {
        const id = $(this).data('id');
        const invoice = $(this).data('invoice');

        // Handles both Sales History and Purchase History modals
        $('#modal-invoice').text(invoice);
        $('#modal-invoice-num').text(invoice); // For the other modal ID

        const targetBody = $('#modal-items, #modal-order-items');
        targetBody.html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

        // Determine URL based on the button context or ID
        // Note: This assumes you are on a page where the correct URL is obvious, 
        // or we try one and fail gracefully. 
        // Better approach: Add data-url to the button in PHP.
        // For now, based on your previous code, I'll use the Purchase one as default logic:

        let url = BASE_URL + "/purchase/get_details";
        // If we are in Order History (Sales), switch URL
        if ($(this).data('target') === '#orderDetailModal') {
            url = BASE_URL + "/purchase/get_order_details";
        }

        $.ajax({
            url: url,
            type: "post",
            data: {
                id: id
            },
            success: function(response) {
                targetBody.html(response);
            },
            error: function() {
                targetBody.html('<tr><td colspan="4" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    });
</script>

</body>

</html>