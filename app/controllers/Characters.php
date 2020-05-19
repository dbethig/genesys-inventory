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
	/**
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
			$inventory = $this->inventoryModel->getInventoryByCharacter($character->char__id);
			$containers = $this->containerModel->getContainers($inventory->inv__id);
			$items = $this->itemModel->getItems($containers);
			$data = [
				'user_id' => $_SESSION['user_id'],
				'character' => $character,
				'inventory' => $inventory,
				'containers' => $containers,
				'items' => $items
			];
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
			$data = [
				'user_id' => $_SESSION['user_id'],
			];
			// Add POST array to $data
			$data = array_merge($data, $_POST);
			// Validate fields and add errors
			$dataWithErrors = $this->validateCharacterFields($data);
			// Check for error entries in $data array
			if ($this->data_err === false) {
				// Form validated
				// Create new character and store in this variable
				$newChar = $this->characterModel->createCharacterReturnRow($data);
				if ($newChar) {
					// Create a new inventory
					$newInventoryId = $this->inventoryModel->createInventoryGetId($newChar->char__id);
					if ($newInventoryId) {
						$containerData = [
							'inv_id' => $newInventoryId,
							'name' => 'General',
							'descr' => NULL,
							'capacity' => NULL,
							'enc' => NULL
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
				'charname' => '',
				'characteristic_brawn' => '2',
				'characteristic_agility' => '2',
				'characteristic_intellect' => '2',
				'characteristic_cunning' => '2',
				'characteristic_willpower' => '2',
				'characteristic_presence' => '2',
				'soak' => '2',
				'enc_total' => '7',
				'enc_curr' => '0'
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
			$data = ['char_id' => $id, 'user_id' => $_SESSION['user_id']];
			// Add POST array into $data
			$data = array_merge($data, $_POST);
			// Validate fields
			$dataWithErrors = $this->validateCharacterFields($data);
			// Check is any errors where detected when validating
			if ($this->data_err === false) {
				// Form validated
				if ($this->characterModel->updateCharacter($data)) {
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
					'char_id' => $id,
					'charname' => $character->char__name,
					'characteristic_brawn' => $character->char__characteristic_brawn,
					'characteristic_agility' => $character->char__characteristic_agility,
					'characteristic_intellect' => $character->char__characteristic_intellect,
					'characteristic_cunning' => $character->char__characteristic_cunning,
					'characteristic_willpower' => $character->char__characteristic_willpower,
					'characteristic_presence' => $character->char__characteristic_presence,
					'soak' => $character->char__soak,
					'enc_total' => $character->char__enc_total,
					'enc_curr' => $character->char__enc_curr,
				];
				$data = $this->validateCharacterFields($data);
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
	public function validateCharacterFields($data = []) {
		// Validate CharName
		if (!$this->validateField($data['charname'])) {
			$data['charname_err'] = 'Please enter a name for your character';
			$this->data_err = true;
		}
		// Validate characteristics
		$c = $this->validateFields($data, 'Please enter a value.', 'characteristic_');
		$data = array_merge($data, $c);
		// Validate soak
		if (!$this->validateField($data['soak'])) {
			if ($this->validateField($data['characteristic_brawn'])) {
				$data['soak'] = $data['characteristic_brawn'];
			} else {
				$this->data_err = true;
			}
		}
		// Validate encumberance
		if (!$this->validateField($data['enc_total'])) {
			if ($this->validateField($data['characteristic_brawn'])) {
				$data['enc_total'] = $data['characteristic_brawn'] + 5;
			} else {
				$this->data_err = true;
			}
		}
		if (!$this->validateField($data['enc_curr'])) {
			$data['enc_curr'] = 0;
		}
		return $data;
	}
}
