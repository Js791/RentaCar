
<div class="container" id="flash">
    <?php $messages = getMessages(); ?>
    <?php if ($messages) : ?>
        <?php foreach ($messages as $msg) : ?>
            <div class="row justify-content-center">
                <div class="alert alert-<?php se($msg, 'color', 'info'); ?>" role="alert"><?php se($msg, "text", ""); ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script>
    
    function moveMeUp(ele) {
        let target = document.getElementById("target");
        if (target) {
            target.after(ele);
        }
    }

    moveMeUp(document.getElementById("flash"));
</script>
<style>
    .alert-success  {
        background-color: green !important;
    }

    .alert-warning {
        background-color: yellow !important;
    }

    .alert-danger {
        background-color: red !important;
    }

    .alert-info {
        background-color: teal !important;
    }
</style>