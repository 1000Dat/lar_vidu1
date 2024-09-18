<!-- resources/views/admin/categories/edit.blade.php -->


<?php $__env->startSection('title', 'Edit Category'); ?>

<?php $__env->startSection('content'); ?>
    <h2>Edit Category</h2>

    <form action="<?php echo e(route('admin.categories.update', $category->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo e($category->name); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\lar_vidu1\resources\views/admin/categories/edit.blade.php ENDPATH**/ ?>