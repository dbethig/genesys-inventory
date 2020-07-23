<?php
if (is_array($data['item_attributes'])):
	foreach($data['item_attributes'] as $attr):
		$attrName = strtolower($attr->attr__name);
	?>
		<div class="form-group col-md">
			<p><?php echo ucwords($attrName); ?></p>
			<p class="form-control"><?php echo $data['item']['item__' .$attrName]; ?></p>
		</div>
	<?php endforeach; ?>
<?php endif;?>
