<!-- resources/views/categories/index.blade.php -->


<?php $__env->startSection('title', 'Categories'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* CSS cho trang danh sách danh mục */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 2rem;
            color: #007bff;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .list-group {
            margin-top: 20px;
        }

        .list-group-item {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            background-color: #fff;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-group-item:hover {
            background-color: #f1f1f1;
        }

        .btn {
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            padding: 6px 12px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-warning {
            background-color: #ffc107;
            border: 1px solid #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border: 1px solid #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .auth-message {
            margin-top: 20px;
            font-size: 1rem;
            color: #343a40;
        }

        .auth-message a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .auth-message a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container">
        <h1>Các hãng sản phẩm</h1>
        <?php if(auth()->guard()->check()): ?>
            <ul class="list-group">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo e($category->name); ?>git add .

                        <!-- Bạn có thể bỏ comment các phần này nếu cần -->
                        <!-- <div>
                            <a href="<?php echo e(route('categories.edit', $category->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?php echo e(route('categories.destroy', $category->id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div> -->
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p class="auth-message">Bạn cần <a href="<?php echo e(route('login')); ?>">đăng nhập</a> để xem các danh mục.</p>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('categories.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\lar_vidu1\resources\views/categories/index.blade.php ENDPATH**/ ?>