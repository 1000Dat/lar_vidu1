<?php $__env->startSection('title', 'Danh sách sản phẩm'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
      
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0 text-primary">Chào mừng đến với trang  </h1>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-danger shadow">Đăng xuất</button>
            </form>
        </div>
   <!-- Link đến trang Giỏ Hàng -->
   <div class="d-flex justify-content-end mb-4">
            <a href="<?php echo e(route('cart.view')); ?>" class="btn btn-warning">Xem Giỏ Hàng</a>
        </div>
        
        <!-- Hiển thị sản phẩm -->
        <div class="row">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo e($product->image ? Storage::url($product->image) : asset('images/default-placeholder.png')); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($product->name); ?></h5>
                            <p class="card-text"><strong>Mô tả:</strong> <?php echo e($product->description); ?></p>
                            <p class="card-text"><strong>Số lượng:</strong> <?php echo e($product->quantity); ?></p>
                            <p class="card-text"><strong>Giá:</strong> <?php echo e(number_format($product->price, 0, ',', '.')); ?> VND</p>
                            <div class="btn-group">
                                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-info">Chi tiết</a>
                                <a href="#" class="btn btn-primary">Mua Ngay</a>
                               <!-- Nút "Thêm vào Giỏ Hàng" -->
                               <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-secondary">Thêm vào Giỏ Hàng</button>
                                </form>
                                <form action="#" method="POST" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-outline-danger">Yêu Thích</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <style>
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .card-img-top {
            height: 200px;  /* Đặt chiều cao cố định cho ảnh */
            object-fit: cover;  /* Giữ tỷ lệ khung hình và cắt ảnh để phù hợp */
            width: 100%;  /* Đảm bảo ảnh rộng bằng toàn bộ thẻ */
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .card-text {
            margin-bottom: 0.5rem;
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;  /* Khoảng cách giữa các nút */
            flex-wrap: wrap;  /* Cho phép các nút xuống dòng nếu không đủ không gian */
        }

        .btn-group .btn {
            flex: 1;  /* Các nút sẽ có kích thước bằng nhau */
            text-align: center;  /* Căn giữa văn bản trong nút */
            font-size: 0.9em;
            padding: 0.5rem 1rem;
            margin: 0;  /* Loại bỏ khoảng cách ngoài nút */
            white-space: nowrap;  /* Ngăn chặn văn bản trong nút xuống dòng */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('products.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\lar_vidu1\resources\views/products/index.blade.php ENDPATH**/ ?>