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
				<?php
				if (!empty($data['containers'])):
				 foreach ($data['containers'] as $container): ?>
					<?php $contId = $container->cont__id; ?>
					<div class="card-group mb-3">
						<div class="order-wrap d-flex flex-column">
							<a href="<?php echo URLROOT ."/containers/listorder/1:$contId"; ?>" class="btn btn-outline-info order-arr-wrap d-flex justify-content-center align-items-center">
								<i class="fas fa-sort-up"></i>
							</a>
							<a href="<?php echo URLROOT ."/containers/listorder/0:$contId"; ?>" class="btn btn-outline-info order-arr-wrap d-flex justify-content-center align-items-center">
								<i class="fas fa-sort-down"></i>
							</a>
						</div>
						<div class="card card-body char-cont-wrap">
							<div class="row char-cont-head d-flex align-items-center">
								<div class="col-md-9">
									<h4><?php echo $container->cont__name; ?> : <?php echo $container->cont__order; ?></h4>
								</div>
								<div class="col-sm-3 col-md-1">
									<?php $contEnc = $container->cont__enc !== null ? $container->cont__enc : 0; ?>
									<p>Enc: <?php echo $contEnc; ?></p>
								</div>
								<div class="col-sm-3 col-md-1">
									<p>Worn: <?php echo $container->cont__worn == 0 ? 'No' : 'Yes'; ?></p>
								</div>
								<div class="col-sm-3 col-md-1">
									<a class="float-right" href="<?php echo URLROOT; ?>/containers/edit/<?php echo $contId . ':' . $data['character']->char__id; ?>">
										<i class="fas fa-pen-square"></i>
									</a>
								</div>
							</div>

							<?php
							if (!empty($data['items'][$contId])) :
								?>
								<table>
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
								foreach ($data['items'][$contId] as $item): ?>
										<tr>
											<td><?php echo $item->item__name; ?></td>
											<td><?php echo $item->item__enc; ?></td>
											<td><?php echo $item->item__qty; ?></td>
											<td><?php echo $item->item__enc_total; ?></td>
											<td><?php echo $item->item__cost; ?>sp</td>
											<td><?php echo $item->item__notes; ?></td>
											<td style="text-align:right;"><a href="<?php echo URLROOT; ?>/items/viewItem/<?php echo $data['character']->char__id .':' .$item->item__id; ?>" class="btn btn-outline-primary btn-sm" style="min-width: 70px;">View</a>
											<a href="<?php echo URLROOT; ?>/items/edit/<?php echo $data['character']->char__id .':' .$item->item__id; ?>" class="btn btn-outline-success btn-sm" style="min-width: 70px;">Edit</a>
											<a href="<?php echo URLROOT; ?>/items/delete/<?php echo $data['character']->char__id .':' .$item->item__id; ?>" class="btn btn-outline-danger ml-3"><i class="fa fa-trash"></i></a>
											<?php /*
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-item_name="<?php echo $item->item__name; ?>">
											  Launch demo modal
											</button>
											*/ ?>
											</td>
										</tr>
								<?php endforeach; ?>
										<tr>
											<td>
												<a href="<?php echo URLROOT; ?>/items/newitem/<?php echo $data['character']->char__id . ':' .$contId; ?>" class="btn btn-outline-success btn-sm btn-block mt-2">Add item</a>
											</td>
										</tr>
									</tbody>
								</table>
								<?php
							else:
								?>
								<a href="<?php echo URLROOT; ?>/items/newitem/<?php echo $data['character']->char__id . ':' .$contId; ?>" class="btn btn-primary btn-sm mt-2">Add item</a>
								<?php
							endif;
							?>
						</div>
					</div>
					<?php endforeach;
				endif; ?>
				<a href="<?php echo URLROOT; ?>/containers/newcontainer/<?php echo $data['character']->char__id; ?>" class="btn btn-outline-success btn-block btn-sm">Add container</a>
			</div>
		</div>
	</section>
</div>
