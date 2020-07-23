<?php

class Items extends Controller {
	public function __construct() {
		$this->itemModel = $this->model('item');
		$this->containerModel = $this->model('container');
		$this->characterModel = $this->model('character');
		$this->data_err = false;
	}
/*
 * ============================================================
 * Create a new item
 * ============================================================
 */
	public function viewItem($ids) {
		// characterId:itemId
		$ids = explode(':', $ids);
		$charId = $ids[0];
		$itemId = $ids[1];
		$data = $this->loadItem($itemId, $charId);
		$data['item__type_name'] = $this->itemModel->getTypeName($data['item']['item__type_id']);
		$data['item_attributes'] = $this->itemModel->getAttributes($data['item']['item__type_id']);
		$this->view('item/viewItem', $data);
	}
/*
 * ============================================================
 * Create a new item
 * ============================================================
 */
	public function newItem($ids) {
		// characterId?containerId
		$ids = explode(':', $ids);
		$charId = $ids[0];
		$contId = $ids[1];
		// $this->containerModel->checkOwner($contId, $charId);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Sanitize POST array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data['item'] = [
				'item__container_id' => $contId
			];
			// Add POST array to $data
			$data['item'] = array_merge($data['item'], $_POST);
			// Incidental item check & process
			$data['item'] = $this->incidentalItem($data['item']);
			// Add & calculate total cost if it is not set in data array
			$this->totalCostCalc($data['item']);
			// Validate fields and compire errors array
			$errors = $this->validateFields($data['item']);
			$data['item_err'] = $errors;

			// Check for error entries in $data array
			if ($this->data_err === false) {
				// Form validated
				// Create Item -----------------------------------
				// printAndDie($data['item']);
				$newItem = $this->itemModel->createItemReturnRow($data['item']);
				if ($newItem) {
					// Item created
					flash('page_msg', 'Item Created!');
					$itemId = $newItem->item__id;
					url_redirect("items/viewItem/$charId:$itemId");
				} else {
					// Error creating item
					flash('page_err', 'Error creating item', 'alert alert-danger');
					url_redirect('characters/show/' .$charId);
				}
			} else {
				// flash('page_err', 'Error creating item', 'alert alert-danger');
				$data['item__character_id'] = $charId;
				$data['item_types'] = $this->loadTypes();
				// Return to page with errors
				$this->view('item/newitem', $data);
			}
		} else {
			// Not a POST request
			// Load blank data & view for user input
			$data['item__character_id'] = $charId;
			$data['item'] = [
				'item__container_id' => $contId,
				'item__name' => '',
				'item__desc' => '',
				'item__inc' => '0',
				'item__packed' => '0',
				'item__enc' => '0',
				'item__enc_total' => '0',
				'item__enc_total_cust' => '0',
				'item__qty' => '1',
				'item__cost' => '0',
				'item__cost_total' => '0',
				'item__cost_total_cust' => '0',
				'item__condition' => '',
				'item__notes' => '',
				// 'item__damage' => '',
				// 'item__damage_add' => '',
				// 'item__damege_ability' => 'Brawn',
				// 'item__crit' => '',
				// 'item__range' => '',
				// 'item__defence' => '',
				// 'item__soak' => '',
				// 'item__skill' => '',
				'item__hp_total' => '0',
				'item__hp_current' => '0',
				'item__rarity' => '',
				'item__special' => '',
				'item__type_id' => 4 // General
			];
			foreach ($data as $key => $value) {
				$data['item_err'][$key .'_err'] = '';
			}
			$data['item_types'] = $this->loadTypes();
			$this->view('item/newitem', $data);
		}
	}
/*
 * ============================================================
 * Edit an item
 * ============================================================
 */
	public function edit($ids) {
		// characterId?itemId
		$ids = explode(':', $ids);
		$charId = $ids[0];
		$itemId = $ids[1];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Sanitize POST array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$data['item'] = [
				'item__id' => $itemId
			];
			// Add POST array to $data
			$data['item'] = array_merge($data['item'], $_POST);
			// Incidental item check & process
			$data['item'] = $this->incidentalItem($data['item']);
			// Add & calculate total cost if it is not set in data array
			$this->totalCostCalc($data['item']);
			// Validate fields and compire errors array
			$errors = $this->validateFields($data['item']);
			$data['item_err'] = $errors;

			// printAndDie($data);
			// Check for error entries in $data array
			if ($this->data_err === false) {
				// Form validated
				// printAndDie($data);
				if ($this->itemModel->updateItem($data['item'])) {
					flash('page_msg', 'Item updated!');
				} else {
					flash('page_err', 'Error updating item', 'alert alert-danger');
				}
				url_redirect('characters/show/' .$charId);
			} else {
				$data['item__character_id'] = $charId;
				$types = $this->itemModel->getTypes();
				$data['item_types'] = $types;

				flash('page_err', 'Error creating item', 'alert alert-danger');
				// Return to page with errors
				$this->view('item/edit', $data);
			}
		} else {
			// Not a POST request
			$data = $this->loadEditItem($itemId, $charId);
			// print_r($data);
			$this->view('item/edit', $data);
		}
	}
/*
 * ============================================================
 * Load item attribute elements view
 * ============================================================
 */
	public function showAttr($typeId = 4, $itemId = null) {
		$type = $this->itemModel->getAttributesWithMeta($typeId);
		$item = $itemId?$this->itemModel->getItem($itemId):NULL;
		$data = [
			'type' => $type,
			'item' => $item
		];
		$this->view('item/itemAttrs', $data, '', false);
	}
/*
 * ============================================================
 * Get and load item data
 * ============================================================
 */
	public function loadItem($itemId, $charId)	{
		$data = [];
		$item = $this->itemModel->getItem($itemId);
		if (!$item) {
			flash('page_err', 'No item found!', 'alert alert-danger');
			url_redirect('characters/show/' .$charId);
			exit();
		}
		// Load data & view for user input
		$data['item'] = (array) $item;
		$data['item__character_id'] = $charId;
		foreach ($data as $key => $value) {
			$data['item_err'][$key .'_err'] = '';
		}
		return $data;
	}
/*
 * ============================================================
 * Get and load data then load Edit item view
 * ============================================================
 */
	public function loadEditItem($itemId, $charId)	{
		$data = $this->loadItem($itemId, $charId);
		$data['item_types'] = $this->loadTypes();
		return $data;
	}

	public function loadTypes() {
		$types = $this->itemModel->getTypes();
		return $types;
	}

/*
 * ============================================================
 * Delete an item
 * ============================================================
 */
	public function delete($ids) {
		// characterId?itemId
		$ids = explode(':', $ids);
		$charId = $ids[0];
		$itemId = $ids[1];

		$character = $this->characterModel->getCharacterById($charId);
		// Character found
		// Check for character's owner
		if ($character->char__user_id != $_SESSION['user_id']) {
			flash('page_err', 'Oh no you don\'t!', 'alert alert-danger');
			url_redirect('characters');
			exit();
		}
		$item = $this->itemModel->getItem($itemId);
		if ($item) {
			if ($this->itemModel->checkOwner($itemId, $charId)) {
				if ($this->itemModel->deleteItem($itemId)) {
					flash('page_msg', 'Item deleted!');
					url_redirect('characters/show/' .$charId);
					exit();
				} else {
					flash('page_err', 'Something went wrong!', 'alert alert-danger');
					url_redirect('characters/show/' .$charId);
					exit();
				}
			} else {
				url_redirect('characters/show/' .$charId);
				exit();
			}
		} else {
			flash('page_err', 'No item found!', 'alert alert-danger');
			url_redirect('characters/show/' .$charId);
			exit();
		}
	}
/*
 * ============================================================
 * Validate character fields
 * ============================================================
 */
	public function validateFields($data) {
		$errors = [];
		// All required fields
		$reqFields = [
			'item__name' => 'Name',
			'item__enc' => 'Encumberance',
			'item__enc_total' => 'Value',
			'item__qty' => 'Quantity'
		];
		// All integer fields
		$intFields = [
			'item__enc' => 'Encumberance',
			'item__enc_total' => '',
			'item__qty' => 'Quantity',
			'item__cost' => 'Cost',
			'item__cost_total' => '',
			'item__ damage' => '',
			'item__crit' => '',
			'item__defence' => '',
			'item__soak' => '',
			'item__hp' => '',
			'item__rarity' => ''
		];

		// Validate required fields
		foreach ($reqFields as $f => $m) {
			if (!isset($data[$f])) {
				$errors[$f .'_err'] = $this->writeArrayError($f, $m .' Required');
			}
		}
		if (!($data['item__name'])) {
			$errors['item__name_err'] = $this->writeArrayError('item__name', $data['item__name'] .' Required');
		}
		// Validate all integer fields
		foreach ($intFields as $f => $m) {
			if (isset($data[$f])) {
				if (!is_numeric($data[$f]) && !empty($data[$f])) {
					$errors[$f .'_err'] = $this->writeArrayError($f, $m);
				}
			}
		}
		return $errors;
	}

	public function writeArrayError($f, $m = '') {
		$error = $m != '' ? $m : 'Invalid Value';
		$this->data_err = true;
		return $error;
	}

	public function itemToData($item) {
		$result = [];
		foreach($item as $att => $val) {
			$result[$att] = $val;
		}
		return $result;
	}

	public function incidentalItem($d) {
		$d['item__enc'] = !array_key_exists('item__enc', $d) ? 0 : $d['item__enc'];
		$d['item__enc'] = !array_key_exists('item__enc', $d) ? 0 : $d['item__enc'];
		$d['item__enc'] = !array_key_exists('item__enc', $d) ? 0 : $d['item__enc'];
		if (!is_numeric($d['item__enc']) || array_key_exists('item__inc', $d)) {
			$itemEnc = 0;
			if (!array_key_exists('item__enc_total', $d)) {
				// Item doesn't have custom enc value
				if (array_key_exists('item__inc', $d)) {
					// Item is Incidental
					if(array_key_exists('item__packed', $d)) {
						$itemEnc = 0.05;
						$encCalc = floor($d['item__qty'] * $itemEnc);
						$d['item__enc_total'] = $encCalc ? $encCalc : 0 ;
					} else {
						$itemEnc = 0.1;
						$encCalc = floor($d['item__qty'] * $itemEnc);
						$d['item__enc_total'] = $encCalc ? $encCalc : 0 ;
						$d['item__packed'] = 0;
					}
				} else {
					// Add the inceidental & packed fields to the array. 0 = NULL for SQL purposes
					$d['item__inc'] = 0;
					$d['item__packed'] = 0;
					$encCalc = floor($d['item__qty'] * $d['item__enc']);
					$d['item__enc_total'] = $encCalc ? $encCalc : 0 ;
				}
			}
			$d['item__enc'] = $itemEnc;
		}	elseif (!array_key_exists('item__inc', $d)) {
			$d += [
				'item__inc' => 0,
				'item__packed' => 0
			];
		}
		if (!array_key_exists('item__enc_total', $d)) {
			$d['item__enc_total'] = floor($d['item__qty'] * $d['item__enc']);
		}
		return $d;
	}

	public function totalCostCalc($item) {
		// It won't be set if the user has not set it themselves as the field will be disabled.
		if (!array_key_exists('item__cost_total', $item)) {
			$item['item__cost_total'] = $item['item__qty'] * $item['item__cost'];
		} elseif (empty($item['item__cost_total']) && $item['item__cost_total_cust'] == 0) {
			$item['item__cost_total'] = $item['item__qty'] * $item['item__cost'];
		}
	}

}
