<?php
/*
 * Show selected character
 *
 */
// Display available flash messages
flash('page_msg');
flash('page_err');
?>
<div class="mb-3">
	<a href="<?php echo URLROOT; ?>/characters" class="btn btn-light"><i class="fa fa-backward"></i></a>
	<a href="<?php echo URLROOT; ?>/characters/edit/<?php echo $data['character']->char__id; ?>" class="btn btn-outline-success pull-right">Edit Character</a>
</div>
<div>
	<div id="char-view-container" class="d-flex flex-column">
		<div class="char_wrap card card-body mb-3">
				<section id="char_header" class="char_header-wrap">
					<span>Name</span>
					<div class="char_header_inner"><h4><?php echo $data['character']->char__name; ?></h4></div>
				</section>
				<section id="char_attributes" class="d-flex">
					<div class="attribute-inner mr-4">
						<span>Soak</span>
						<h4><?php echo $data['character']->char__soak; ?></h4>
					</div>
					<div class="attribute-inner d-flex flex-column">
						<span>Encumberance</span>
						<div class="enc-wrap d-flex">
							<div class="enc-inner d-flex flex-column mr-2">
								<h4><?php echo $data['character']->char__enc_total; ?></h4>
								<span>Total</span>
							</div>
							<div class="enc-inner d-flex flex-column">
								<h4><?php echo $data['character']->char__enc_curr; ?></h4>
								<span>Current</span>
							</div>
						</div>
					</div>
				</section>
				<section id="char_characteristics" class="d-flex justify-content-between mb-3">
					<div class="characteristics-inner">
						<span>Brawn</span>
						<h2><?php echo $data['character']->char__characteristic_brawn; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Agility</span>
						<h2><?php echo $data['character']->char__characteristic_agility; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Intellect</span>
						<h2><?php echo $data['character']->char__characteristic_intellect; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Cunning</span>
						<h2><?php echo $data['character']->char__characteristic_cunning; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Willpower</span>
						<h2><?php echo $data['character']->char__characteristic_willpower; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Presence</span>
						<h2><?php echo $data['character']->char__characteristic_presence; ?></h2>
					</div>
				</section>
		</div>
<?php
/*
 * =============================================
 * Inventory View
 * =============================================
 */
?>
		<div class="inv_wrap mb-3">
			<section>
				<div id="char-view-container" class="d-flex flex-column">
					<div id="inventory__<?php echo $data['inventory']->inv__id; ?>" class="card card-body mb-3 inventory-wrap">
						<h3>Inventory</h2>
						<?php foreach ($data['containers'] as $container): ?>
							<div class="card card-body mb-3 container-wrap">
								<h4><?php echo $container->cont__name; ?></h4>
								<?php
								if (!empty($data['items'][$container->cont__id])) :
									?>
									<table class="mb-4">
										<thead>
											<tr>
												<th>Name</th>
												<th>Enc</th>
												<th>Qty</th>
												<th>Total Enc</th>
												<th>Cost</th>
												<th>Notes</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
									<?php
									foreach ($data['items'][$container->cont__id] as $item): ?>
											<tr>
												<td><?php echo $item->item__name; ?></td>
												<td><?php echo $item->item__enc; ?></td>
												<td><?php echo $item->item__qty; ?></td>
												<td><?php echo ($item->item__enc * $item->item__qty); ?></td>
												<td><?php echo $item->item__cost; ?>sp</td>
												<td><?php echo $item->item__notes; ?></td>
												<td style="text-align:right;"><a href="<?php echo URLROOT; ?>/items/viewItem/<?php echo $data['character']->char__id .':' .$item->item__id; ?>" class="btn btn-outline-primary" style="min-width: 70px;">View</a>
												<a href="<?php echo URLROOT; ?>/items/edit/<?php echo $data['character']->char__id .':' .$item->item__id; ?>" class="btn btn-outline-success" style="min-width: 70px;">Edit</a>
												<a href="<?php echo URLROOT; ?>/items/delete/<?php echo $data['character']->char__id .':' .$item->item__id; ?>" class="btn btn-outline-danger ml-3"><i class="fa fa-trash"></i></a>
												<!-- Button trigger modal -->
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-item_name="<?php echo $item->item__name; ?>">
												  Launch demo modal
												</button>
												</td>
											</tr>
									<?php endforeach;
									?>
										</tbody>
									</table>
									<a href="<?php echo URLROOT; ?>/items/newitem/<?php echo $data['character']->char__id . ':' .$container->cont__id; ?>" class="btn btn-success btn-block">Add an item</a>
									<?php
								else:
									?>
									<a href="<?php echo URLROOT; ?>/inventories/newitem/<?php echo $container->cont__id; ?>" class="btn btn-success btn-block">Add an item</a>
									<?php
								endif;
								?>
							</div>
						<?php endforeach; ?>
						<a href="<?php echo URLROOT; ?>/inventories/newcontainer/<?php echo $data['inventory']->inv__id; ?>" class="btn btn-success btn-block">Add a container</a>
					</div>
				</div>
			</section>
		</div>

	</div>
</div>
