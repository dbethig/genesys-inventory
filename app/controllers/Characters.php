<?php

class Characters extends Controller {

	public function __construct() {
		$this->userModel = $this->model('User');
		$this->characterModel = $this->model('Character');
		$this->inventoryModel = $this->model('Inventory');
		$this->containerModel = $this->model('Container');
		$this->itemModel = $this->model('Item');
		$this->data_err = false;
	}
/*
 * ----------------------------------------
 * Get all characters for user
 * ----------------------------------------
 */
	public function index() {
		// Redirect to the login page if the user is not logged in
		if(!isLoggedIn()) {
			flash('page_err', 'Please login first.', 'alert alert-warning');
			url_redirect('users/login');
		}
		// Get all the user's characters
		$characters = $this->characterModel->getCharacters($_SESSION['user_id']);

		$pageTitle = 'Character Manager';
		$data = [
			'title' => $pageTitle,
			'characters' => $characters
		];

		$this->view('characters/index', $data, $pageTitle);
	}
	/**
	*
	*
	* ----------------------------------------
	* View a character
	* ----------------------------------------
	*/
	public function show($id) {
		// Redirect to the login page if the user is not logged in
		if(!isLoggedIn()) {
			flash('page_err', 'Please login.', 'alert alert-warning');
			url_redirect('users/login');
		}
		try {
			$character = $this->characterModel->getCharacterById($id);
			// Check character is owned by current user
			if ($character->char__user_id != $_SESSION['user_id']) {
				// Current user does not own character
				url_redirect('characters');
				exit();
			}
			$inventory = $this->inventoryModel->getInventoryByCharacter($character->char__id); // Obj
			$containers = $this->containerModel->getContainers($inventory->inv__id); // Array of container obj
			$containerEnc = !empty($containers) ? $this->containerModel->calcContainerEnc($containers) : 0; // Sum of all containers with !isNull(cont__enc) && cont__worn !== 0
			$items = !empty($containers) ? $this->itemModel->getItems($containers) : ''; // Assoc array of the containers with the items as obj inside Eg. Array([cont__id]=>[item_obj, item_obj])
			$itemsEnc = !empty($items) ? $this->itemModel->calcItemEnc($items) : 0; // Sum of all items in 'worn' containers


			// echo "<p>$containerEnc</p><p>";
			// print_r($items);
			// echo "</p><p>$itemsEnc</p>";
			// die();
			// Should this be done when an item is created/edited?
			$this->characterModel->updateEncCurrent($id, $itemsEnc);
			$this->characterModel->updateEncTotal($id, $containerEnc);
			$character = $this->characterModel->getCharacterById($id);
			$data = [
				'user_id' => $_SESSION['user_id'],
				'character' => $character,
				'inventory' => $inventory,
				'containers' => $containers,
				'items' => $items
			];
			echo "<p>Container Enc Total: $containerEnc</p>";
			echo "<p>Item Enc Total: $itemsEnc</p>";
			// print_r($data);
			// die();
			$this->view('characters/show', $data);
		} catch (CustomException $e) {
			flash('page_err', 'Character not found!', 'alert alert-danger');
			url_redirect('characters');
		}
	}
/*
 * ============================================================
 * Create a new characters
 * ============================================================
 */
	public function newCharacter() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Sanitize POST array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			// Add POST array to $data
			$data['character']['char__user_id'] = $_SESSION['user_id'];
			$data['character'] = array_merge($data['character'], $_POST);
			// print_r($data);
			// die();
			// Validate fields and add errors
			$dataWithErrors = $this->validateCharacterFields($data);
			// Check for error entries in $data array
			if ($this->data_err === false) {
				// Form validated
				// Create new character and store in this variable
				$newChar = $this->characterModel->createCharacterReturnRow($data['character']);
				if ($newChar) {
					// Create a new inventory
					$newInventoryId = $this->inventoryModel->createInventoryGetId($newChar->char__id);
					if ($newInventoryId) {
						$containerData = [
							'cont__inv_id' => $newInventoryId,
							'cont__name' => 'General',
							'cont__descr' => NULL,
							'cont__capacity' => NULL,
							'cont__enc' => NULL,
							'cont__worn' => 1
						];
						$container = $this->containerModel->createContainer($containerData);
						if ($container == TRUE) {
							// Set success message and go to character's page
							flash('page_msg', "Character created!");
							url_redirect('characters/show/' . $newChar->char__id);
							// $this->view('characters/show/' . $newChar->char__id, $data);
						} else {
							// Return with error flash message
							flash('page_err', 'Something went wrong! 02', 'alert alert-danger');
							url_redirect('characters');
							exit();
						}
					} else {
						// Query did not execute
						flash('page_err', 'Couldn\'t create inventory!', 'alert alert-danger');
						url_redirect('characters');
						exit();
					}
				} else {
					// Return with error flash message
					flash('page_err', 'Something went wrong! 03', 'alert alert-danger');
					url_redirect('characters');
					exit();
				}
			} else {
				// Return to page with errors
				$this->view('characters/newcharacter', $dataWithErrors);
			}
		} else {
			// Not a POST request
			$data = [
				'char__name' => '',
				'char__characteristic_brawn' => '2',
				'char__characteristic_agility' => '2',
				'char__characteristic_intellect' => '2',
				'char__characteristic_cunning' => '2',
				'char__characteristic_willpower' => '2',
				'char__characteristic_presence' => '2',
				'char__soak' => '2',
				'char__enc_total' => '7',
				'char__enc_curr' => '0'
			];
			foreach ($data as $key => $value) {
				$data[$key .'_err'] = '';
			}
			$this->view('characters/newcharacter', $data);
		}
	}
/*
 * ----------------------------------------
 * Edit a character
 * ----------------------------------------
 */
	public function edit($id) {
		// Redirect to the login page if the user is not logged in
		if(!isLoggedIn()) {
			flash('page_err', 'Please login.', 'alert alert-warning');
			url_redirect('users/login');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			//
			// Sanitize POST array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			// Add POST array into $data
			$data['character'] = $_POST;
			$data['character']['char__id'] = $id;
			$data['user_id'] = $_SESSION['user_id'];
			print_r($data);
			// Validate fields
			$dataWithErrors = $this->validateCharacterFields($data);
			// Check is any errors where detected when validating
			if ($this->data_err === false) {
				// Form validated
				if ($this->characterModel->updateCharacter($data['character'])) {
					flash('page_msg', 'Character updated!');
					url_redirect('characters/show/' . $id);
				} else {
					// Return with error flash message
					flash('page_err', 'Something went wrong! 01', 'alert alert-danger');
					$this->view('characters/edit', $data);
				}
			} else {
				// Return to page with errors
				$this->view('characters/edit', $dataWithErrors);
			}
		} else {
			// Get character to edit
			try {
				$character = $this->characterModel->getCharacterById($id);
				// Check for post's owner
				if ($character->char__user_id != $_SESSION['user_id']) {
					flash('page_err', 'Nope', 'alert alert-danger');
					url_redirect('characters');
					exit();
				}
				$data = [
					'user_id' => $_SESSION['user_id'],
					'character' => (array) $character
				];
				foreach ($data['character'] as $key => $value) {
					$data[$key .'_err'] = '';
				}
				// $data = $this->validateCharacterFields($data);
				$this->view('characters/edit', $data);
			} catch (CustomException $e) {
				// $e->pageError();
				flash('page_err', 'Character not found!', 'alert alert-danger');
				url_redirect('characters');
			}
		}
	}
/*
 * ----------------------------------------
 * Delete a character
 * ----------------------------------------
 */
	public function delete($charId) {
		try {
			$character = $this->characterModel->getCharacterById($charId);
			// Character found
			// Check for character's owner
			if ($character->char__user_id != $_SESSION['user_id']) {
				flash('page_err', 'Oh no you don\'t!', 'alert alert-danger');
				url_redirect('characters');
				exit();
			}
			// Find Inventory, Containers & Items
			$inventory = $this->inventoryModel->getInventoryByCharacter($charId);
			$containers = $this->containerModel->getContainers($inventory->inv__id);
			$items = $this->itemModel->getItems($containers);

			$this->itemModel->deleteItems($items);
			$this->containerModel->deleteContainers($containers);
			$this->inventoryModel->deleteInventory($inventory->inv__id);
			$this->characterModel->deleteCharacter($charId);

			flash('page_msg', 'Character Deleted!');
			url_redirect('characters');
		} catch(CustomException $e) {
			// No character found!
			flash('page_err', 'No character found!', 'alert alert-danger');
			url_redirect('characters');
		}
	}

/*
 * ============================================================
 * Validate a field
 * ============================================================
 */
	public function validateField($field) {
		if (isset($field) && $field !== '') {
			// Field is valid
			return true;
		} else {
			// Empty field
			return false;
		}
	}

/*
 * ============================================================
 * Validate fields
 * ============================================================
 */
	public function validateFields($fields, $msg, $needle = false) {
		$errors = [];
		foreach ($fields as $key => $value) {
			if ($needle) {
				if (startsWith($needle, $key)) {
					if (!$this->validateField($value)) {
						$errors[$key .'_err'] = $msg;
						$this->data_err = true;
					} else {
						$errors[$key .'_err'] = '';
					}
				}
			} else {
				if (!$this->validateField($value)) {
					$errors[$key .'_err'] = $msg;
					$this->data_err = true;
				} else {
					$errors[$key .'_err'] = '';
				}
			}
		}
		return $errors;
	}
/*
 * ============================================================
 * Validate all the character fields
 * ============================================================
 */
	public function validateCharacterFields($data) {
		// Validate CharName
		if (!$this->validateField($data['character']['char__name'])) {
			$data['charname_err'] = 'Please enter a name for your character';
			$this->data_err = true;
		}
		// Validate characteristics
		$c = $this->validateFields($data['character'], 'Please enter a value.', 'char__characteristic_');
		$data = array_merge($data, $c);
		// Validate soak
		if (!$this->validateField($data['character']['char__soak'])) {
			if ($this->validateField($data['character']['char__characteristic_brawn'])) {
				$data['character']['char__soak'] = $data['character']['char__characteristic_brawn'];
			} else {
				$this->data_err = true;
			}
		}
		// Validate encumberance
		if (!$this->validateField($data['character']['char__enc_total'])) {
			if ($this->validateField($data['character']['char__characteristic_brawn'])) {
				$data['character']->char__enc_total = $data['character']['char__characteristic_brawn'] + 5;
			} else {
				$this->data_err = true;
			}
		}
		if (!$this->validateField($data['character']['char__enc_curr'])) {
			$data['character']['char__enc_curr'] = 0;
		}

		return $data;
	}
}
