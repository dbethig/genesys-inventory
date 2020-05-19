<div class="inv_wrap mb-3">
	<section>
		<div id="char-view-container" class="d-flex flex-column">
			<div id="inventory__<?php echo $data['inventory']->inv__id; ?>" class="card card-body mb-3 inventory-wrap">
				<h3><?php echo $data['inventory']->inv__id; ?></h2>
				<?php foreach ($data['containers'] as $container): ?>
					<div class="card card-body mb-3 container-wrap">
						<h4>Container: <?php echo $container->cont__name; ?></h4>
						<?php
						if (!empty($data['items'][$container->cont__id])) :
							?>
							<table>
								<thead>
									<tr>
										<th>Name</th>
										<th>Enc</th>
										<th>Qty</th>
										<th>Cost</th>
										<th>Notes</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
							<?php
							foreach ($data['items'][$container->cont__id] as $item): ?>
									<tr>
										<td><?php echo $item->item__name ?></td>
										<td><?php echo $item->item__enc; ?></td>
										<td><?php echo $item->item__qty; ?></td>
										<td><?php echo $item->item__cost; ?>sp</td>
										<td><?php echo $item->item__notes; ?></td>
										<td><a href="<?php echo URLROOT; ?>/items/viewItem/<?php echo $item->item__id; ?>" class="btn btn-success btn-block" style="max-width: 100px;">View</a></td>
									</tr>
							<?php endforeach;
							?>
								</tbody>
							</table>
							<a href="<?php echo URLROOT; ?>/inventories/newitem/<?php echo $container->cont__id; ?>" class="btn btn-success btn-block">Add an item</a>
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
