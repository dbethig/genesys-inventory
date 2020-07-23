<?php flash('page_err'); ?>
<a href="<?php echo URLROOT; ?>/characters/show/<?php echo $data['char__id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i></a>
<div class="card card-body bg-light mt-5">
	<form class="item-wrap" action="<?php echo URLROOT; ?>/containers/newcontainer/<?php echo $data['char__id']; ?>" method="post">
		<div class="form-group">
			<label for="cont__name">Container Name</label>
			<input type="text" name="cont__name" class="form-control form-control-lg <?php echo (!empty($data['errors']['cont__name'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['cont']['cont__name']; ?>">
			<?php if(!empty($data['errors']['cont__name'])) : ?>
				<span class="invalid-feedback"><?php echo $data['errors']['cont__name']; ?></span>
			<?php endif; ?>

			<label for="cont__capacity">Capacity</label>
			<input type="number" name="cont__capacity" class="form-control form-control-lg <?php echo (!empty($data['errors']['cont__capacity'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['cont']['cont__capacity']; ?>">
			<?php if(!empty($data['errors']['cont__capacity'])) : ?>
				<span class="invalid-feedback"><?php echo $data['errors']['cont__capacity']; ?></span>
			<?php endif; ?>

			<label for="cont__enc">Enc</label>
			<input type="number" name="cont__enc" class="form-control form-control-lg <?php echo (!empty($data['errors']['cont__enc'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['cont']['cont__enc']; ?>">
			<?php if(!empty($data['errors']['cont__enc'])) : ?>
				<span class="invalid-feedback"><?php echo $data['errors']['cont__enc']; ?></span>
			<?php endif; ?>
			<?php /* ?>
			<label for="cont__worn">Worn?</label>
			<input type="checkbox" name="cont__worn" class="form-control form-control-lg <?php echo (!empty($data['errors']['cont__worn'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['cont']['cont__worn']; ?>">
			<?php if(!empty($data['errors']['cont__worn'])) : ?>
				<span class="invalid-feedback"><?php echo $data['errors']['cont__worn']; ?></span>
			<?php endif; ?>
			<?php */ ?>
		</div>
		<div class="form-group">
			<label for="cont__desc">Container Description</label>
			<input type="text" name="cont__desc" class="form-control form-control-lg <?php echo (!empty($data['errors']['cont__desc'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['cont']['cont__desc']; ?>">
			<?php if(!empty($data['errors']['cont__desc'])) : ?>
				<span class="invalid-feedback"><?php echo $data['errors']['cont__desc']; ?></span>
			<?php endif; ?>
		</div>
		<input type="submit" value="Submit" class="btn btn-success btn-block">
	</form>
</div>
