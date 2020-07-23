<a href="<?php echo URLROOT; ?>/posts/show/<?php echo $data['id']; ?>" class="btn btn-light"><i class="fa fa-backward"></i></a>
<form class="float-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['id']; ?>" method="post">
	<input type="submit" value="Delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">
</form>
<div class="card card-body bg-light mt-5">
	<?php echo flash('register_success'); ?>
	<h2>Edit Post</h2>
	<p>Edit your post below then press save.</p>
	<form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="post">
			<div class="form-group">
				<label for="title">Title<sup>*</sup>:</label>
				<input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : '' ; ?>" value="<?php echo $data['title']; ?>">
				<span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
			</div>
			<div class="form-group">
				<label for="body">Body<sup>*</sup>:</label>
				<textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : '' ; ?>"><?php echo $data['body']; ?></textarea>
				<span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
			</div>
			<input type="submit" value="save" class="btn btn-success btn-block">
	</form>
</div>
