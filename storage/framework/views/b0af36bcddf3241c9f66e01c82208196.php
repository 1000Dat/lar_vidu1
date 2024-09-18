<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'My Application'); ?></title>
    <!-- Include Bootstrap CSS or any other CSS framework you prefer -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
     

        <!-- Content will be injected here -->
        <div class="content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Include Bootstrap JS or other JS files -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\lar_vidu1\resources\views/products/app.blade.php ENDPATH**/ ?>