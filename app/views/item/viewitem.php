<?php $itemType = ''; ?>

<div class="mb-3">
	<a href="<?php echo URLROOT; ?>/characters/show/<?php echo $data['item__character_id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i></a>
	<a href="<?php echo URLROOT; ?>/items/edit/<?php echo $data['item__character_id'] .":" .$data['item']['item__id']; ?>" class="btn btn-outline-success float-right">Edit</a>
</div>
<div class="card card-body bg-light mt-1">
	<?php echo flash('page_err'); ?>
		<div class="form-row">
			<div class="form-group col-md-8">
				<p for="item__name">Item name</p>
				<p class="form-control" name="item__name" id="item__name"><?php echo $data['item']['item__name']; ?></p>
			</div>
			<div class="form-group col-md-2">
				<p for="item__type_id">Item Type</p>
				<p class="form-control" name="item__type_id" id="item__type_id"><?php echo $data['item__type_name']; ?></p>
			</div>
			<div class="form-group col-md-1 d-flex flex-column align-items-center">
				<p for="item__inc">Indidental?</p>
				<div class="form-control item-checkbox <?php echo $data['item']['item__inc'] == 1 ? 'checkbox-checked' : '' ; ?>" name="item__type_id" id="item__type_id">
					<?php if($data['item']['item__inc'] == 1): ?>
						<i class="fas fa-check"></i>
					<?php endif; ?>
				</div>
			</div>
			<?php if($data['item']['item__inc'] == 1): ?>
				<div class="form-group col-md-1 d-flex flex-column align-items-center">
					<p for="item__packed">Packed?</p>
					<div class="form-control item-checkbox <?php echo $data['item']['item__packed'] == 1 ? 'checkbox-checked' : '' ; ?>" name="item__packed" id="item__packed">
						<?php if($data['item']['item__packed'] == 1): ?>
							<i class="fas fa-check"></i>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="form-row">
			<div class="form-group col-md">
				<p for="item__desc">Description</p>
				<p name="item__desc" id="item__desc" class="form-control"><?php echo $data['item']['item__desc']; ?></p>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-2">
				<p for="item__enc">Enc</p>
				<p name="item__enc" id="item__enc" class="form-control form-num form-enc"><?php echo $data['item']['item__enc']; ?></p>
			</div>
			<div class="form-group col-md-2">
				<p for="item__qty">Qty</p>
				<p name="item__qty" id="item__qty" class="form-control form-num form-enc"><?php echo $data['item']['item__qty']; ?></p>
			</div>
			<div class="form-group col-md-2">
				<p for="item__enc_total">Total Enc</p>
				<p name="item__enc_total" id="item__enc_total" class="form-control"><?php echo $data['item']['item__enc']; ?></p>
			</div>
			<div class="form-group col-md-2">
				<p for="item__cost">Cost/Item</p>
				<div class="cost-wrap">
					<p name="item__cost" id="item__cost" class="form-control form-num form-cost"><?php echo $data['item']['item__cost']; ?><span class="item-cost-p">sp</span></p>
				</div>
			</div>
			<div class="form-group col-md-2">
				<p for="item__cost_total">Total Value</p>
				<div class="cost-wrap">
					<p name="item__cost_total" id="item__cost_total" class="form-control"><?php echo $data['item']['item__cost']; ?><span class="item-cost-p">sp</span></p>
				</div>
			</div>
			<div class="form-group col-md-2">
				<p>Rarity</p>
				<p class="form-control" name="item__rarity" id="="item__rarity" "><?php echo $data['item']['item__rarity']; ?></p>
			</div>
		</div>
		<div class="form-row">
			<?php require_once 'view-item-attr.php'; ?>
		</div>
		<div class="form-row">
			<div class="form-group col-md">
				<p>Special</p>
				<p class="form-control" name="item__special" id="="item__special" "><?php echo $data['item']['item__special']; ?></p>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md">
				<p for="item__notes">Notes</p>
				<p name="item__notes" id="item__notes" class="form-control"><?php echo $data['item']['item__notes']; ?></p>
			</div>
		</div>
</div>
