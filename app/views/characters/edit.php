<div class="mb-3">
	<a href="<?php echo URLROOT; ?>/characters" class="btn btn-light"><i class="fa fa-backward"></i></a>
	<a href="<?php echo URLROOT; ?>/characters/delete/<?php echo $data['char_id']; ?>" class="btn btn-danger pull-right"><i class="fa fa-trash"></i> Delete</a>
</div>
<div class="mb-3">
	<div class="card card-body bg-light">
		<?php echo flash('page_err'); ?>
		<h2>Create a new Character</h2>
		<p>Create yur new hero by filling in their details below!</p>
		<form class="char-wrap" action="<?php echo URLROOT; ?>/characters/edit/<?php echo $data['char_id']; ?>" method="post">
			<div class="form-group">
				<label for="charname">Name</label>
				<input type="text" name="charname" class="form-control form-control-lg <?php echo (!empty($data['charname_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['charname']; ?>">
				<?php if(!empty($data['charname_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['charname_err']; ?></span>
				<?php endif; ?>
			</div>

			<div class="form-group d-flex mb-5">
				<div class="attribute-inner mr-4">
					<label for="soak">Soak</label>
					<input type="number" name="soak" class="form-control form-control-lg <?php echo (!empty($data['soak_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['soak']; ?>" min="0">
					<?php if(!empty($data['soak_err'])) : ?>
						<span class="invalid-feedback"><?php echo $data['soak_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="attribute-inner d-flex flex-column">
					<p class="mb-2">Encumberance</p>
					<div class="enc-wrap d-flex">
						<div class="enc-inner d-flex flex-column mr-2">
							<input type="number" name="enc_total" class="form-control form-control-lg <?php echo (!empty($data['enc_total_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['enc_total']; ?>" min="0">
							<?php if(!empty($data['enc_total_err'])) : ?>
								<span class="invalid-feedback"><?php echo $data['enc_total_err']; ?></span>
							<?php endif; ?>
							<label for="enc_total">Total</label>
						</div>
						<div class="enc-inner d-flex flex-column">
							<input type="number" name="enc_curr" class="form-control form-control-lg <?php echo (!empty($data['enc_curr_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['enc_curr']; ?>" min="0">
							<?php if(!empty($data['enc_curr_err'])) : ?>
								<span class="invalid-feedback"><?php echo $data['enc_curr_err']; ?></span>
							<?php endif; ?>
							<label for="enc_curr">Current</label>
						</div>
					</div>
				</div>
			</div>

			<div id="char_characteristics" class="form-group d-flex justify-content-between mb-3">
				<div class="characteristics-wrap">
					<label for="characteristic_brawn">Brawn</label>
					<input type="number" name="characteristic_brawn" class="form-control form-control-lg <?php echo (!empty($data['characteristic_brawn_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['characteristic_brawn']; ?>" min="1" max="5">
					<?php if(!empty($data['characteristic_brawn_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['characteristic_brawn_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="characteristic_agility">Agility</label>
					<input type="number" name="characteristic_agility" class="form-control form-control-lg <?php echo (!empty($data['characteristic_agility_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['characteristic_agility']; ?>"  min="1" max="5">
					<?php if(!empty($data['characteristic_agility_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['characteristic_agility_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="characteristic_intellect">Intellect</label>
					<input type="number" name="characteristic_intellect" class="form-control form-control-lg <?php echo (!empty($data['characteristic_intellect_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['characteristic_intellect']; ?>"  min="1" max="5">
					<?php if(!empty($data['characteristic_intellect_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['characteristic_intellect_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="characteristic_cunning">Cunning</label>
					<input type="number" name="characteristic_cunning" class="form-control form-control-lg <?php echo (!empty($data['characteristic_cunning_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['characteristic_cunning']; ?>"  min="1" max="5">
					<?php if(!empty($data['characteristic_cunning_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['characteristic_cunning_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="characteristic_willpower">Willpower</label>
					<input type="number" name="characteristic_willpower" class="form-control form-control-lg <?php echo (!empty($data['characteristic_willpower_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['characteristic_willpower']; ?>"  min="1" max="5">
					<?php if(!empty($data['characteristic_willpower_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['characteristic_willpower_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="characteristic_presence">Presence</label>
					<input type="number" name="characteristic_presence" class="form-control form-control-lg <?php echo (!empty($data['characteristic_presence_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['characteristic_presence']; ?>"  min="1" max="5">
					<?php if(!empty($data['characteristic_presence_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['characteristic_presence_err']; ?></span>
					<?php endif; ?>
				</div>

			</div>
			<input type="submit" value="Submit" class="btn btn-success btn-block">
		</form>
	</div>
</div>
