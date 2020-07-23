<?php
// if (is_array($itemType->attributes)):
if (is_array($itemType)):
	foreach($itemType->attributes as $attr):
		$attrName = strtolower($attr->attr__name);
	?>
		<div class="form-group col-md <?php echo $attrName; ?>">
			<label for="item__<?php echo $attrName; ?>"><?php echo ucwords($attrName); ?></label>
			<?php
			$itemAttr = $data['item']['item__' .$attrName];
			if ($attrName == 'range' || $attrName == 'skill' || $attrName == 'craftsmanship' || $attrName == 'material') {
				if (!SETTING[$_SESSION['setting']][$attrName]) {
					continue;
				}
				echo '<select type="text" name="item__' .$attrName .'" class="form-control">';
				$options = SETTING[$_SESSION['setting']][$attrName];
				echo '<option value=""></option>';
				foreach ($options as $option) {
					echo '<option value="' .$option .'">' .ucwords($option) .'</option>';
				}
				echo '</select>';
			} else {
				echo '<input class="form-control" type=';
				switch ($attr->meta['native_type']) {
					case 'LONG': // INT(11)
						echo '"number" name="item__' .$attrName . '"';
						$val = ' value="';
						if ($itemAttr) {
							$val .= $itemAttr;
						} else {
							$val .= '0';
						}
						$val .= '">';
						echo $val;
						break;

					default: // VARCHAR
						echo '"text" name="item__' .$attrName . '"';
						$val = ' value="';
						if ($itemAttr) {
							$val .= $itemAttr;
						}
						$val .= '">';
						echo $val;
						break;
				}
			}
			?>
		</div>
	<?php endforeach; ?>
<?php endif;?>
