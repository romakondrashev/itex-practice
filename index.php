<?php require 'common/header.php'; ?>
<?php
$session = mt_rand(1,999);
?>
<main>
    <div class="container-fluid">
        <h1 class="mt-5">Главная</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Главная</li>
        </ol>
        

        <!-- My queues -->
        <div class="queue_wrapper">
            <div class="mb-3">
                <h2 class="queue_title ">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>Очереди созданные мной
                </h2>
            </div>
            <div class="row">
                <?php 
                    $limit = 6;
                    require 'backend/get-queue-cards/my-queues.php'; 
                ?>
            </div>
        </div>   


        <!-- Awaiting queues -->
        <div class="queue_wrapper">
            <div class="mb-3">
                <h2 class="queue_title ">
                    <i class="fas fa-user-clock mr-2"></i>Участие в очереди
                </h2>
            </div>
            <div class="row">
                <?php 
                    $limit = 6;
                    require 'backend/get-queue-cards/awaiting-queues.php'; 
                ?>
            </div>
        </div>  
        
    </div>
</main>



<?php require 'common/footer.php'; ?>