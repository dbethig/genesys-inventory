<?php $itemType = ''; ?>
<div class="mb-3">
	<a href="<?php echo URLROOT; ?>/characters/show/<?php echo $data['item__character_id']; ?>" class="btn btn-light"><i class="fas fa-fist-raised mr-1"></i>Character</a>
</div>
<div class="card card-body bg-light mt-1">
	<?php echo flash('page_err'); ?>
	<h2>Update your item</h2>
	<form class="item-wrap" action="<?php echo URLROOT; ?>/items/edit/<?php echo $data['item__character_id'] .':' .$data['item']['item__id']; ?>" method="post">
		<div class="form-row" id="item_row-main">
			<div class="form-group col-md-6">
				<label for="item__name">Item name</label>
				<input type="text" name="item__name" class="form-control <?php echo (!empty($data['item_err']['item__name_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['item']['item__name']; ?>">
				<?php if(!empty($data['item_err']['item__name_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__name_err']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-2">
				<label for="item__type_id">Item Type</label>
				<select type="text" name="item__type_id" class="form-control" id="item__type_id">
					<?php foreach($data['item_types'] as $type): ?>
					<option value="<?php echo $type->type__id; ?>"
						<?php
						if ($type->type__id == $data['item']['item__type_id']) {
							echo 'selected="selected"';
							$itemType = $type;
						}
						?>
					><?php echo $type->type__name; ?></option>
					<?php	endforeach;	?>
				</select>
			</div>
			<div class="form-group col-md-2" style="text-align: center;">
				<label for="item__inc">Incidental?</label>
				<input type="checkbox" name="item__inc" id="item__inc" class="form-control <?php echo (!empty($data['item_err']['item__inc_err'])) ? 'is-invalid' : '' ; ?>" value="1" <?php echo $data['item']['item__inc'] != 0 ? 'checked' : '' ; ?>>
			</div>


			<div class="form-group col-md-2" style="text-align: center; <?php echo $data['item']['item__inc'] == 0 ? 'display: none': ''; ?>" id="pack-wrap">
				<?php if($data['item']['item__inc'] != 0): ?>
					<label for="item__packed">Organised?</label>
					<input type="checkbox" name="item__packed" id="item__packed" class="form-control <?php echo (!empty($data['item_err']['item__packed_err'])) ? 'is-invalid' : '' ; ?>" value="1" <?php echo $data['item']['item__packed'] != 0 ? 'checked' : '' ; ?>>
				<?php endif; ?>
			</div>


		</div>
		<div class="form-row" id="item_row-desc">
			<div class="form-group col-12">
				<label for="item__desc">Description</label>
				<input type="text" name="item__desc" id="item__desc" class="form-control form-num form-desc <?php echo (!empty($data['item_err']['item__desc_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['item']['item__desc']; ?>">
				<?php if(!empty($data['item_err']['item__desc_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__desc_err']; ?></span>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-row" id="item_row-nums">
			<div class="form-group col-md-2">
				<label for="item__enc">Enc</label>
				<input type="number" name="item__enc" id="item__enc" class="form-control form-num form-enc <?php echo (!empty($data['item_err']['item__enc_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['item']['item__enc']; ?>" <?php echo $data['item']['item__inc'] != 0 ? 'disabled' : ''; ?>>
				<?php if(!empty($data['item_err']['item__enc_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__enc_err']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-2">
				<label for="item__qty">Qty</label>
				<input type="number" name="item__qty" id="item__qty" class="form-control form-num form-enc <?php echo (!empty($data['item_err']['item__qty_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['item']['item__qty']; ?>">
				<?php if(!empty($data['item_err']['item__qty_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__qty_err']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-2">
				<label for="item__enc_total" style="width: 100%;">Total Enc <span style="float: right;padding: 0 5px;font-size: 0.9em;" class="toggle-field">edit</span></label>
				<?php $isCustomEnc = $data['item']['item__enc_total_cust'] != 0 ? TRUE : False; ?>
				<input type="number" name ="item__enc_total" id="item__enc_total" class="form-control <?php echo $isCustomEnc ? 'cust-val' : ''; ?>" value="<?php echo $data['item']['item__enc_total']; ?>" <?php echo $isCustomEnc ? 'enabled' : 'disabled' ?>>
				<input type="number" name="item__enc_total_cust" id="item__enc_total_cust"value="<?php echo $data['item']['item__enc_total_cust']; ?>" hidden>
			</div>
			<div class="form-group col-md-2">
				<label for="item__cost">Cost/Item</label>
				<div class="cost-wrap">
					<input type="number" name="item__cost" id="item__cost" class="form-control form-num form-cost <?php echo (!empty($data['item_err']['item__cost_err'])) ? 'is-invalid' : '' ; ?>" value="<?php
						if (!$data['item']['item__cost']) {
							$data['item']['item__cost'] = '0';
						}
						echo $data['item']['item__cost'];
					?>"><span class="item-cost-label">sp</span>
				</div>
				<?php if(!empty($data['item_err']['item__cost_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__cost_err']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-2">
				<label for="item__cost_total" style="width: 100%;">Total Value <span style="float: right;padding: 0 5px;font-size: 0.9em;" class="toggle-field">edit</span></label>
				<div class="cost-wrap">
					<?php $isCustomCost = $data['item']['item__cost_total_cust'] != 0 ? TRUE : False; ?>
					<input type="number" name="item__cost_total" id="item__cost_total" class="form-control <?php echo $isCustomCost ? 'cust-val' : ''; ?>" value="<?php echo $data['item']['item__cost_total']; ?>" <?php echo $isCustomCost ? 'enabled' : 'disabled' ?>>
					<input type="number" name="item__cost_total_cust" id="item__cost_total_cust"value="<?php echo $data['item']['item__cost_total_cust']; ?>" hidden>
				</div>
			</div>
		</div>

		<div class="form-row" id="item_row-attr">
			<div class="form-group col-md-2">
				<label for="item__rarity">Rarity</label>
				<input class="form-control <?php echo (!empty($data['item_err']['item__rarity_err'])) ? 'is-invalid' : '' ; ?>" type="number" name="item__rarity" id="item__rarity" value="<?php echo $data['item']['item__rarity']; ?>">
				<?php if(!empty($data['item_err']['item__rarity_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__rarity_err']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-4">
				<label>Hard Points</label>
				<div class="d-flex">
					<div class="col-md-6">
						<label for="item__hp_total">Total</label>
						<input class="form-control <?php echo (!empty($data['item_err']['item__hp_total_err'])) ? 'is-invalid' : '' ; ?>" type="number" name="item__hp_total" id="item__hp_total" value="<?php echo $data['item']['item__hp_total']; ?>">
						<?php if(!empty($data['item_err']['item__hp_total_err'])) : ?>
							<span class="invalid-feedback"><?php echo $data['item_err']['item__hp_total_err']; ?></span>
						<?php endif; ?>
					</div>
					<div class="col-md-6">
						<label for="item__hp_current">Current</label>
						<input class="form-control <?php echo (!empty($data['item_err']['item__hp_current_err'])) ? 'is-invalid' : '' ; ?>" type="number" name="item__hp_current" id="item__hp_current" value="<?php echo $data['item']['item__hp_current']; ?>">
						<?php if(!empty($data['item_err']['item__hp_current_err'])) : ?>
							<span class="invalid-feedback"><?php echo $data['item_err']['item__hp_current_err']; ?></span>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="form-group col-md-4">
				<label>Item Damaged</label>
				<div id="item-dmg-wrap">
					<label for="item__condition">Item Condition</label>
					<select type="text" name="item__condition" class="form-control">
						<option value=""></option>
						<?php foreach(SETTING[$_SESSION['setting']]['itemConditions'] as $level): ?>
						<option value="<?php echo $level; ?>"
							<?php
							if ($level == $data['item']['item__condition']) {
								echo 'selected="selected"';
							}
							?>
						><?php echo $level; ?></option>
						<?php	endforeach;	?>
					</select>
				</div>
			</div>
		</div>

		<div class="form-row" id="item_row-attr">

		</div>
		
		<div class="form-row" id="item_row-special">
			<div class="form-group col-md">
				<label for="item__special">Special</label>
				<input class="form-control" type="text" name="item__special" value="<?php echo $data['item']['item__special']; ?>">
			</div>
		</div>
		<div class="form-row" id="item_row-notes">
			<div class="form-group col-12">
				<label for="item__notes" style="width: 100%;">Notes</label>
				<textarea name="item__notes" id="item__notes" rows="4" class="form-control"><?php echo $data['item']['item__notes']; ?></textarea>
				<?php if(!empty($data['item_err']['item__notes_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['item_err']['item__notes_err']; ?></span>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-row">
			<div class="col-md-8">
				<input type="submit" value="Submit" class="btn btn-block btn-success">
			</div>
			<div class="col-md-4">
				<a href="<?php echo URLROOT; ?>/items/viewitem/<?php echo $data['item__character_id'] .":" .$data['item']['item__id']; ?>" class="btn btn-block btn-outline-warning">Cancel</a>
			</div>
		</div>
	</form>
</div>
<?php include APPROOT . '/views/pages/debug.php'; ?>
