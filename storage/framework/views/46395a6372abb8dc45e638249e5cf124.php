<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $__env->make('includes.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 
</head>
<body>

<header>
<?php echo $__env->yieldContent("navbar"); ?>
</header>
<main>
   <?php echo $__env->yieldContent("content"); ?>
</main>


    <?php echo $__env->make('includes.script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 


</body>
</html>


<?php /**PATH C:\xampp\htdocs\Laravel_project\resources\views/layouts/app.blade.php ENDPATH**/ ?>