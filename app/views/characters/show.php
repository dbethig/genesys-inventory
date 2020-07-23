<?php
/*
 * Show selected character
 *
 */
// Display available flash messages
flash('page_msg');
flash('page_err');
// print_r($data);
?>
<div class="mb-3">
	<a href="<?php echo URLROOT; ?>/characters" class="btn btn-light"><i class="fa fa-backward"></i></a>
	<a href="<?php echo URLROOT; ?>/characters/edit/<?php echo $data['character']->char__id; ?>" class="btn btn-outline-success float-right">Edit Character</a>
</div>
<div>
	<div id="char-view-container" class="d-flex flex-column">
		<div class="char_wrap card card-body mb-3">
				<section id="char_header" class="char_header-wrap">
					<span>Name</span>
					<div class="char_header_inner"><h4><?php echo $data['character']->char__name; ?></h4></div>
				</section>
				<section id="char_attributes" class="d-flex">
					<div class="attribute-inner mr-4">
						<span>Soak</span>
						<h4><?php echo $data['character']->char__soak; ?></h4>
					</div>
					<div class="attribute-inner d-flex flex-column">
						<span>Encumberance</span>
						<div class="enc-wrap d-flex">
							<div class="enc-inner d-flex flex-column mr-2">
								<h4><?php echo $data['character']->char__enc_total; ?></h4>
								<span>Total</span>
							</div>
							<div class="enc-inner d-flex flex-column">
								<h4><?php echo $data['character']->char__enc_curr; ?></h4>
								<span>Current</span>
							</div>
						</div>
					</div>
				</section>
				<section id="char_characteristics" class="d-flex justify-content-between mb-3">
					<div class="characteristics-inner">
						<span>Brawn</span>
						<h2><?php echo $data['character']->char__characteristic_brawn; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Agility</span>
						<h2><?php echo $data['character']->char__characteristic_agility; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Intellect</span>
						<h2><?php echo $data['character']->char__characteristic_intellect; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Cunning</span>
						<h2><?php echo $data['character']->char__characteristic_cunning; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Willpower</span>
						<h2><?php echo $data['character']->char__characteristic_willpower; ?></h2>
					</div>
					<div class="characteristics-inner">
						<span>Presence</span>
						<h2><?php echo $data['character']->char__characteristic_presence; ?></h2>
					</div>
				</section>
		</div>

<?php
/*
 * =============================================
 * Inventory View
 * =============================================
 */
		 require_once 'characterShowInv.php';
		?>


	</div>
</div>
<?php include APPROOT . '/views/pages/debug.php'; ?>
