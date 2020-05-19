<?php
/*
* Index page for the Inventory section
*
*/

// Display available flash messages
flash('page_msg');
flash('page_err');
?>
<div class="jumbotron jumbotron-fluid text-center">
	<div class="container">
		<h1 class="display-4"><?php echo $data['title']; ?></h1>
	</div>
</div>
<div class="d-flex flex-column">
	<?php
	if (empty($data['inventories'])) : ?>
		<h4 class="mb-3">Woops, can't find any.</h4>
	<?php
	else :
		foreach($data['inventories'] as $inventory): ?>
			<div class="card card-body mb-3">
				<?php //print_r($inventory); ?>
				<h4><?php echo $inventory->char__name; ?> ID: <?php echo $inventory->char__id; ?></h4>
				<div class="d-flex justify-between">
					<a href="<?php echo URLROOT; ?>/inventories/show/<?php echo $inventory->inv__id; ?>" class="btn btn-success">View Inventory <?php echo $inventory->inv__id; ?></a>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
