<?php require 'common/header.php'; ?>


<main>
	<div class="container-fluid">
		<h1 class="mt-4">Список очередей с моим участием</h1>
		<ol class="breadcrumb mb-4">
			<li class="breadcrumb-item ">
				<a href="<?php echo $home_url; ?>">
					Главная
				</a>
			</li>
			<li class="breadcrumb-item active">Список ожидающих очередей</li>
		</ol>
		<div class="d-flex justify-content-end">
			<a data-fancybox href="javascript:;" data-src="#add_queue_modal" rel="nofollow" class="btn btn-primary modalbox " onclick="clicked_new_queue_button();"><i class="fas fa-plus"></i></a>
		</div>	
		<div class="row">
			<?php require 'backend/get-queue-cards/awaiting-queues.php'; ?>
		</div>
	</div>
</main>





<?php require 'common/footer.php'; ?>