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
		// characterId?itemId
		$ids = explode(':', $ids);
		$charId = $ids[0];
		$itemId = $ids[1];
		$data = $this->loadItem($itemId, $charId);
		$data['item__type_name'] = $this->itemModel->getTypeName($data['item']->item__type_id);
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
			$data = [
				'item__container_id' => $contId
			];
			// Add POST array to $data
			$data = array_merge($data, $_POST);
			// Validate fields
			$data = $this->validateFields($data);
			// Check for error entries in $data array
			if ($this->data_err === false) {
				// Form validated
				$newItem = $this->itemModel->createItemReturnRow($data);
				if ($newItem) {
					flash('page_msg', 'Item Created!');
					$this->loadEditItem($charId, $newItem->item__id);
				} else {
					flash('page_err', 'Error creating item', 'alert alert-danger');
					url_redirect('characters/show/' .$charId);
				}
			} else {
				$data['item__char_id'] = $charId;
				// Return to page with errors
				$this->view('item/newitem', $data);
			}
		} else {
			// Not a POST request
			// Load blank data & view for user input
			$data = [
				'item__char_id' => $charId,
				'item__container_id' => $contId,
				'item__name' => '',
				'item__desc' => '',
				'item__enc' => '',
				'item__qty' => '',
				'item__cost' => '',
				'item__notes' => '',
				'item__damage' => '',
				'item__crit' => '',
				'item__range' => '',
				'item__defence' => '',
				'item__soak' => '',
				'item__hp' => '',
				'item__rarity' => '',
				'item__skill' => '',
				'item__special' => ''
			];

			foreach ($data as $key => $value) {
				$data[$key .'_err'] = '';
			}
			$types = $this->itemModel->getTypes();
			$data['item_types'] = $types;
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
			// print_r($data);
			// Validate fields
			$data['item'] = $this->validateFields($data['item']);
			// Check for error entries in $data array
			if ($this->data_err === false) {
				// Form validated
				if ($this->itemModel->editItem($itemId, $data['item'])) {
					flash('page_msg', 'Item updated!');
				} else {
					flash('page_err', 'Error updating item', 'alert alert-danger');
				}

				url_redirect('characters/show/' .$charId);
			} else {
				$data['item__character_id'] = $charId;
				$types = $this->itemModel->getTypes();
				$data['item_types'] = $types;

				// Return to page with errors
				$this->view('item/edit', $data);
			}
		} else {
			// Not a POST request
			$data = $this->loadEditItem($itemId, $charId);
			$this->view('item/edit', $data);
		}
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
		$data['item'] = $item;
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
		$types = $this->itemModel->getTypes();
		$data['item_types'] = $types;
		return $data;
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
	public function validateFields($data, $msg = 'Enter a valid number') {
		// All integer fields
		$intFields = ['item__enc', 'item__qty', 'item__cost', 'item__ damage', 'item__crit', 'item__defence', 'item__soak', 'item__hp', 'item__rarity'];
		// Validate name field
		if (empty($data['item__name'])) {
			$data['item__name_err'] = 'Please enter a name.';
			$this->data_err = true;
		}
		// Validate all integer fields
		foreach ($intFields as $int) {
			if (!empty($data[$int])) {
				if (!is_numeric($data[$int])) {
					$data[$int .'_err'] = $msg;
					$this->data_err = true;
				}
			}
		}
		return $data;
	}

	public function itemToData($item) {
		$result = [];
		foreach($item as $att => $val) {
			$result[$att] = $val;
		}
		return $result;
	}

}
