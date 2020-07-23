<?php
// printAndDie($data);
if (is_array($data['type'])):
	foreach($data['type'] as $attr):
		$attrName = strtolower($attr->attr__name);
	?>
	<div class="form-group col-md <?php echo $attrName; ?>">
		<label for="item__<?php echo $attrName; ?>"><?php echo ucwords($attrName); ?></label>
		<?php
		if ($attrName == 'range' || $attrName == 'skill' || $attrName == 'craftsmanship' || $attrName == 'material') {
			if (!SETTING[$_SESSION['setting']][$attrName]) {
				continue;
			}
			echo '<select type="text" name="item__' .$attrName .'" class="form-control" id="item__' .$attrName .'">';
			$options = SETTING[$_SESSION['setting']][$attrName];
			echo '<option value=""></option>';
			foreach ($options as $option) {
				echo '<option value="' .$option .'">' .ucwords($option) .'</option>';
			}
			echo '</select>';
		} else {
			echo '<input class="form-control" type=';
			if ($attr->meta == 'LONG' || $attr->meta == 'TINY') {
				echo '"number" name="item__' .$attrName . '"';
				$val = ' value="';
				// if ($itemAttr) {
				// 	$val .= $itemAttr;
				// } else {
					$val .= '0';
				// }
				$val .= '">';
				echo $val;
			} else {
				echo '"text" name="item__' .$attrName . '"';
				$val = ' value="';
				// if ($itemAttr) {
				// 	$val .= $itemAttr;
				// }
				$val .= '">';
				echo $val;
			}
		}
		?>
	</div>
	<?php endforeach; ?>
<?php endif; ?>
