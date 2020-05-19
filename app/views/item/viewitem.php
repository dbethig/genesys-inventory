<a href="<?php echo URLROOT; ?>/characters/show/<?php echo $data['item__character_id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i></a>
<div class="card card-body bg-light mt-5">
	<?php echo flash('page_err'); ?>
	<h2>Update your item</h2>
	<section id="char_attributes" class="d-flex">
		<div class="item-header-wrap">
			<h4 class="form-control col-md-0"><?php echo $data['item']['item_name']; ?></h4>
			<h4 class="form-control col-md-2"><?php echo $data['item__type_name']; ?></h4>
		</div>
	</section>
</div>
