<?php
/*
* Index page for the Character section
*
* TO-DO
*  List all user's characters
*  Add new character button
*  Link to Spell Book page?
*
*/

// Display available flash messages
flash('page_msg');
flash('page_err');
?>
<div class="jumbotron jumbotron-fluid text-center">
	<div class="container">
		<h1 class="display-4"><?php echo $data['title']; ?></h1>
	</div>
</div>
<a href="<?php echo URLROOT; ?>/inventories" class="btn btn-outline-dark mb-3">View Inventories</a>
<div class="d-flex flex-column">
	<?php
	if (empty($data['characters'])) : ?>
		<h4 class="mb-3">Characters you create will appear here. You currently have no characters associated with your account.</h4>
		<a href="<?php echo URLROOT; ?>/characters/new-character" class="btn btn-outline-success">Create a new character</a>
	<?php
	else :
		foreach($data['characters'] as $character): ?>
			<div class="card card-body mb-3">
				<?php //print_r($character); ?>
				<h4><?php echo $character->char__name; ?></h4>
				<div class="d-flex justify-content-between">
					<a href="<?php echo URLROOT; ?>/characters/show/<?php echo $character->char__id; ?>" class="btn btn-success">View Character</a>
					<a href="<?php echo URLROOT; ?>/characters/edit/<?php echo $character->char__id; ?>" class="btn btn-outline-dark">Edit Character</a>
				</div>
			</div>
		<?php endforeach; ?>
		<div class="card card-body mb-3">
			<h3 class="card-title">New Character.</h3>
			<a href="<?php echo URLROOT; ?>/characters/new-character" class="btn btn-success btn-block">Create a new character here</a>
		</div>
	<?php endif; ?>
</div>
