<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i></a>
<br>
<h1><?php echo $data['post']->title; ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
	Written by <?php echo $data['user']->fname . ' ' . $data['user']->sname; ?> on <?php echo $data['user']->created_at; ?>
</div>
<p><?php echo $data['post']->body; ?></p>
<?php if($data['post']->user_id == $_SESSION['user_id']): ?>
	<hr>
	<a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark"><i class="fa fa-edit"></i> Edit</a>
<?php endif; ?>
