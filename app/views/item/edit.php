<?php $itemType = ''; ?>
<a href="<?php echo URLROOT; ?>/characters/show/<?php echo $data['item__character_id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i></a>
<div class="card card-body bg-light mt-5">
	<?php echo flash('page_err'); ?>
	<h2>Update your item</h2>
	<form class="item-wrap" action="<?php echo URLROOT; ?>/items/edit/<?php echo
	$data['item__character_id'] .':' .$data['item']->item__id; ?>" method="post">
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="item__name">Item name</label>
				<input type="text" name="item__name" class="form-control <?php echo (!empty($data['item_err']['item__name_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['item']->item__name; ?>">
				<?php if(!empty($data['item_err']['item__name_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__name_err']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-2">
				<label for="item__type_id">Item Type</label>
				<select type="text" name="item__type_id" class="form-control">
					<?php foreach($data['item_types'] as $type): ?>
					<option value="<?php echo $type->type__id; ?>"
						<?php
						if ($type->type__id == $data['item']->item__type_id) {
							echo 'selected="selected"';
							$itemType = $type;
						}
						echo $type->type__name;
						?>
					></option>
					<?php	endforeach;	?>
				</select>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-2">
				<label for="item__enc">Enc</label>
				<input type="number" name="item__enc" id="item__enc" class="form-control form-num form-enc <?php echo (!empty($data['item_err']['item__enc_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['item']->item__enc; ?>">
				<?php if(!empty($data['item_err']['item__enc_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__enc_err']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-2">
				<label for="item__qty">Qty</label>
				<input type="number" name="item__qty" id="item__qty" class="form-control form-num form-enc <?php echo (!empty($data['item_err']['item__qty_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['item']->item__qty; ?>">
				<?php if(!empty($data['item_err']['item__qty_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__qty_err']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-2">
				<label for="item__enc-total">Total Enc</label>
				<p id="item__enc-total" class="form-control"><?php echo $data['item']->item__enc; ?></p>
			</div>
			<div class="form-group col-md-2">
				<label for="item__cost">Cost/Item</label>
				<div class="cost-wrap">
					<input type="number" name="item__cost" id="item__cost" class="form-control form-num form-cost <?php echo (!empty($data['item_err']['item__cost_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['item']->item__cost; ?>"><span class="item-cost-label">sp</span>
				</div>
				<?php if(!empty($data['item_err']['item__cost_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__cost_err']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-2">
				<label for="item__cost-total">Total Value</label>
				<div class="cost-wrap">
					<p id="item__cost-total" class="form-control"><?php echo $data['item']->item__cost; ?></p><span class="item-cost-label">sp</span>
				</div>
			</div>
		</div>

		<div class="form-row">
			<?php require_once 'item-attr.php'; ?>
		</div>
		<input type="submit" value="Submit" class="btn btn-success btn-block">
	</form>
</div>
