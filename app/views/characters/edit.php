<div class="mb-3">
	<a href="<?php echo URLROOT; ?>/characters/show/<?php echo $data['character']['char__id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i></a>
	<a href="<?php echo URLROOT; ?>/characters/delete/<?php echo $data['character']['char__id']; ?>" class="btn btn-danger float-right"><i class="fa fa-trash"></i> Delete</a>
</div>
<div class="mb-3">
	<div class="card card-body bg-light">
		<?php echo flash('page_err'); ?>
		<h2>Edit your character</h2>
		<form class="char-wrap" action="<?php echo URLROOT; ?>/characters/edit/<?php echo $data['character']['char__id']; ?>" method="post">
			<div class="form-group">
				<label for="char__name">Name</label>
				<input type="text" name="char__name" class="form-control form-control-lg <?php echo (!empty($data['char__name_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__name']; ?>">
				<?php if(!empty($data['char__name_err'])) : ?>
					<span class="invalid-feedback"><?php echo $data['char__name_err']; ?></span>
				<?php endif; ?>
			</div>

			<div class="form-group d-flex mb-5">
				<div class="attribute-inner mr-4">
					<label for="char__soak">Soak</label>
					<input type="number" name="char__soak" class="form-control form-control-lg <?php echo (!empty($data['char__soak_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__soak']; ?>" min="0">
					<?php if(!empty($data['char__soak_err'])) : ?>
						<span class="invalid-feedback"><?php echo $data['char__soak_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="attribute-inner d-flex flex-column">
					<p class="mb-2">Encumberance</p>
					<div class="enc-wrap d-flex">
						<div class="enc-inner d-flex flex-column mr-2">
							<input type="number" name="char__enc_total" class="form-control form-control-lg <?php echo (!empty($data['char__enc_total_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__enc_total']; ?>" min="0">
							<?php if(!empty($data['char__enc_total_err'])) : ?>
								<span class="invalid-feedback"><?php echo $data['char__enc_total_err']; ?></span>
							<?php endif; ?>
							<label for="char__enc_total">Total</label>
						</div>
						<div class="enc-inner d-flex flex-column">
							<input type="number" name="char__enc_curr" class="form-control form-control-lg <?php echo (!empty($data['char__enc_curr_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__enc_curr']; ?>" min="0">
							<?php if(!empty($data['char__enc_curr_err'])) : ?>
								<span class="invalid-feedback"><?php echo $data['char__enc_curr_err']; ?></span>
							<?php endif; ?>
							<label for="char__enc_curr">Current</label>
						</div>
					</div>
				</div>
			</div>

			<div id="char_characteristics" class="form-group d-flex justify-content-between mb-3">
				<div class="characteristics-wrap">
					<label for="char__characteristic_brawn">Brawn</label>
					<input type="number" name="char__characteristic_brawn" class="form-control form-control-lg <?php echo (!empty($data['char__characteristic_brawn_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__characteristic_brawn']; ?>" min="1" max="5">
					<?php if(!empty($data['char__characteristic_brawn_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['char__characteristic_brawn_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="char__characteristic_agility">Agility</label>
					<input type="number" name="char__characteristic_agility" class="form-control form-control-lg <?php echo (!empty($data['char__characteristic_agility_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__characteristic_agility']; ?>"  min="1" max="5">
					<?php if(!empty($data['char__characteristic_agility_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['char__characteristic_agility_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="char__characteristic_intellect">Intellect</label>
					<input type="number" name="char__characteristic_intellect" class="form-control form-control-lg <?php echo (!empty($data['char__characteristic_intellect_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__characteristic_intellect']; ?>"  min="1" max="5">
					<?php if(!empty($data['char__characteristic_intellect_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['char__characteristic_intellect_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="char__characteristic_cunning">Cunning</label>
					<input type="number" name="char__characteristic_cunning" class="form-control form-control-lg <?php echo (!empty($data['char__characteristic_cunning_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__characteristic_cunning']; ?>"  min="1" max="5">
					<?php if(!empty($data['char__characteristic_cunning_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['char__characteristic_cunning_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="char__characteristic_willpower">Willpower</label>
					<input type="number" name="char__characteristic_willpower" class="form-control form-control-lg <?php echo (!empty($data['char__characteristic_willpower_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__characteristic_willpower']; ?>"  min="1" max="5">
					<?php if(!empty($data['char__characteristic_willpower_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['char__characteristic_willpower_err']; ?></span>
					<?php endif; ?>
				</div>
				<div class="characteristics-wrap">
					<label for="char__characteristic_presence">Presence</label>
					<input type="number" name="char__characteristic_presence" class="form-control form-control-lg <?php echo (!empty($data['char__characteristic_presence_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['character']['char__characteristic_presence']; ?>"  min="1" max="5">
					<?php if(!empty($data['char__characteristic_presence_err'])) : ?>
					  <span class="invalid-feedback"><?php echo $data['char__characteristic_presence_err']; ?></span>
					<?php endif; ?>
				</div>

			</div>
			<input type="submit" value="Submit" class="btn btn-success btn-block">
		</form>
	</div>
</div>
