<a href="<?php echo URLROOT; ?>/characters/show/<?php echo $data['char__id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i></a>
<div class="card card-body bg-light mt-5">
	<?php echo flash('page'); ?>
	<div class="d-flex align-items-center mb-4">
		<h2 class="inline">Update Container</h2>
		<a href="<?php echo URLROOT; ?>/containers/delete/<?php echo $data['cont']['cont__id']; ?>" class="btn btn-danger ml-auto"><i class="fa fa-trash"></i> Delete</a>
	</div>
	<form class="cont-wrap" action="<?php echo URLROOT; ?>/containers/edit/<?php echo $data['cont']['cont__id'] .':' .$data['char__id']; ?>" method="post">
		<div class="form-row" id="cont-main-wrap">
			<div class="form-group col-md-8">
				<label for="cont__name">Name</label>
				<input type="text" class="form-control <?php echo (!empty($data['errors']['cont__name'])) ? 'is-invalid' : '' ; ?>" id="cont__name" name="cont__name" value="<?php echo $data['cont']['cont__name']; ?>">
				<?php if(!empty($data['errors']['cont__name'])) : ?>
					<span class="invalid-feedback"><?php echo $data['errors']['cont__name']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-2 col-sm-3">
				<label for="cont__capacity">Capacity</label>
				<input type="number" id="cont__capacity" name ="cont__capacity" class="form-control <?php echo (!empty($data['errors']['cont__capacity'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['cont']['cont__capacity']; ?>">
				<?php if(!empty($data['cont_']['cont__capacity'])) : ?>
					<span class="invalid-feedback"><?php echo $data['errors']['cont__capacity']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-1 col-sm-3">
				<label for="cont__enc">Enc</label>
				<input type="number" id="cont__enc" name ="cont__enc" class="form-control <?php echo (!empty($data['errors']['cont__enc'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['cont']['cont__enc']; ?>">
				<?php if(!empty($data['cont_']['cont__enc'])) : ?>
					<span class="invalid-feedback"><?php echo $data['errors']['cont__enc']; ?></span>
				<?php endif; ?>
			</div>
			<div class="form-group col-md-1 col-sm-3 text-center">
				<label for="cont__worn">Worn?</label>
				<input type="checkbox" id="cont__worn" name ="cont__worn" class="form-control <?php echo (!empty($data['errors']['cont__worn'])) ? 'is-invalid' : '' ; ?>" value="1" <?php echo $data['cont']['cont__worn'] != 0 ? 'checked' : ''; ?>>
				<?php if(!empty($data['cont_']['cont__worn'])) : ?>
					<span class="invalid-feedback"><?php echo $data['errors']['cont__worn']; ?></span>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md">
				<label for="cont__desc">Description</label>
				<textarea name="cont__desc" id="cont__desc" rows="4" class="form-control"><?php echo $data['cont']['cont__desc']; ?></textarea>
				<?php if(!empty($data['errors']['cont__desc'])) : ?>
					<span class="invalid-feedback"><?php echo $data['errors']['cont__desc']; ?></span>
				<?php endif; ?>
			</div>
		</div>
		<input type="submit" value="Submit" class="btn btn-success btn-block">
	</form>
</div>
