<?php
if (is_array($itemType->attributes)):
	foreach($itemType->attributes as $attr):
		$attrName = strtolower($attr->attr__name);
	?>
		<div class="form-group col-md">
			<label for="item__<?php echo $attrName; ?>"><?php echo ucwords($attrName); ?></label>
			<input class="form-control" type=<?php
			$itemAttr = $data['item']->{'item__' .$attrName};

			if ($attrName == 'damage' || $attrName == 'crit' || $attrName == 'soak' || $attrName == 'defence' || $attrName == 'hp') {
				// code...
			}

			switch ($attr->meta['native_type']) {
				case 'LONG': // INT(11)
					echo '"number" name="item__' .$attrName . '"';
					$val = ' value="';
					if ($itemAttr) {
						$val .= $itemAttr;
					} else {
						$val .= '0';
					}
					$val .= '"';
					echo $val;
					break;

				default: // VARCHAR
					echo '"text" name="item__' .$attrName . '"';
					if ($itemAttr) {
						$val = ' value="' .$itemAttr . '"';
						echo $val;
					}
					break;
			}
			echo $data['item']->{'item__' .$attrName }?  : '';
			?>>
		</div>
	<?php endforeach; ?>
<?php endif;?>
<div class="form-group col-md">
	<label for="item__rarity">Rarity</label>
	<input class="form-control" type="number" name="item__rarity" value="<?php echo $data['item']->item__rarity; ?>">
</div>
<div class="form-group col-md">
	<label for="item__special">Special</label>
	<input class="form-control" type="text" name="item__special" value="<?php echo $data['item']->item__special; ?>">
</div>
<?php //print_r($data['item_types']); ?>
