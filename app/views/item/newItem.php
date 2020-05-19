<a href="<?php echo URLROOT; ?>/characters/show/<?php echo $data['item__char_id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i></a>
<div class="card card-body bg-light mt-5">
	<?php echo flash('page_err'); ?>
	<h2>Create a new item</h2>
	<form class="item-wrap" action="<?php echo URLROOT; ?>/items/newItem/<?php echo
	$data['item__char_id'] .':' .$data['item__container_id']; ?>" method="post">
		<div class="form-group">
			<label for="item__name">Item name</label>
			<input type="text" name="item__name" class="form-control form-control-lg <?php echo (!empty($data['item__name_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['item__name']; ?>">
			<?php if(!empty($data['item__name_err'])) : ?>
				<span class="invalid-feedback"><?php echo $data['item__name_err']; ?></span>
			<?php endif; ?>
		</div>
		<div class="form-group">
			<label for="item__type_id">Item Type</label>
			<select type="text" name="item__type_id" class="form-control">
				<?php foreach($data['item_types'] as $type): ?>
				<option value="<?php echo $type->type__id; ?>">
					<?php	echo $type->type__name;	?>
				</option>
				<?php	endforeach;	?>
			</select>
		</div>
		<input type="submit" value="Submit" class="btn btn-success btn-block">
	</form>
</div>
