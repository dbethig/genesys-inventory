<?php

class Characters extends Controller {
	protected $data

	public function __construct() {
		$this->userModel = $this->model('User');
		$this->characterModel = $this->model('Character');
		$this->inventoryModel = $this->model('Inventory');
		$this->data = $data
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
		$this->data = [
			'title' => $pageTitle,
			'characters' => $characters
		];

		$this->view('characters/index', $this->data, $pageTitle);
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

			// if ($character) {
				// Check character is owned by current user
				if ($character->char__user_id != $_SESSION['user_id']) {
					// Current user does not own character
					url_redirect('characters');
					exit();
				}
				$this->data = [
					'character' => $character
				];
				$this->view('characters/show', $this->data);
			// } else {
			// 	// No character found with that ID
			// 	flash('page_err', 'Character not found!', 'alert alert-danger');
			// 	url_redirect('characters');
			// }
		}

		catch(CustomException $e) {
			// echo 'Message: ' .$e->errorMessage();
			$e->pageError();
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

			$this->data = [
				'user_id' => $_SESSION['user_id'],
				'charname' => $_POST['charname'],
				'characteristic_brawn' => $_POST['characteristic_brawn'],
				'characteristic_agility' => $_POST['characteristic_agility'],
				'characteristic_intellect' => $_POST['characteristic_intellect'],
				'characteristic_cunning' => $_POST['characteristic_cunning'],
				'characteristic_willpower' => $_POST['characteristic_willpower'],
				'characteristic_presence' => $_POST['characteristic_presence'],
				'soak' => $_POST['soak'],
				'enc_total' => $_POST['enc_total'],
				'enc_curr' => $_POST['enc_curr'],
				'charname_err' => '',
				'characteristic_brawn_err' => '',
				'characteristic_agility_err' => '',
				'characteristic_intellect_err' => '',
				'characteristic_cunning_err' => '',
				'characteristic_willpower_err' => '',
				'characteristic_presence_err' => '',
				'soak_err' => '',
				'enc_total_err' => '',
				'enc_curr_err' => ''
			];

			// Validate CharName
			if (empty($this->data['charname'])) {
				$this->data['charname_err'] = 'Please enter a name for your character.';
			}

			// Validate attributes
			if (empty($this->data['characteristic_brawn'])) {
				$this->data['characteristic_brawn_err'] = 'Please enter a value.';
			}
			if (empty($this->data['characteristic_agility'])) {
				$this->data['characteristic_agility_err'] = 'Please enter a value.';
			}
			if (empty($this->data['characteristic_intellect'])) {
				$this->data['characteristic_intellect_err'] = 'Please enter a value.';
			}
			if (empty($this->data['characteristic_cunning'])) {
				$this->data['characteristic_cunning_err'] = 'Please enter a value.';
			}
			if (empty($this->data['characteristic_willpower'])) {
				$this->data['characteristic_willpower_err'] = 'Please enter a value.';
			}
			if (empty($this->data['characteristic_presence'])) {
				$this->data['characteristic_presence_err'] = 'Please enter a value.';
			}
			// Validate soak
			if (empty($this->data['soak'])) {
				if (!empty($this->data['characteristic_brawn'])) {
					// Set soak to Brawn value
					$this->data['soak'] = $this->data['characteristic_brawn'];
				}
			}
			// Validate encumberance
			if (empty($this->data['enc_total'])) {
				if (!empty($this->data['characteristic_brawn'])) {
					// Set encumberance total to (Brawn value + 5)
					$this->data['enc_total'] = $this->data['characteristic_brawn'] + 5;
				}
			}
			if (empty($this->data['enc_curr'])) {
				// If empty default to 0
				$this->data['enc_curr'] = '0';
			}

			// Check for error entries in $this->data array
			if (empty($this->data['charname_err']) && empty($this->data['characteristic_brawn_err']) && empty($this->data['characteristic_agility_err']) && empty($this->data['characteristic_intellect_err']) && empty($this->data['characteristic_cunning_err']) && empty($this->data['characteristic_wis_err']) && empty($this->data['characteristic_presence_err'])) {
				// Form validated
				// Create new character and store in this variable
				$newChar = $this->characterModel->createCharacterReturnRow($this->data);
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
						$container = $this->inventoryModel->createContainer($containerData);
						if ($container == TRUE) {
							// Set success message and go to character's page
							flash('page_msg', "Character created!");
							url_redirect('characters/show/' . $newChar->char__id);
							// $this->view('characters/show/' . $newChar->char__id, $this->data);
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
				$this->view('characters/newcharacter', $this->data);
			}
		} else {
			// Not a POST request
			$this->data = [
				'charname' => '',
				'characteristic_brawn' => '2',
				'characteristic_agility' => '2',
				'characteristic_intellect' => '2',
				'characteristic_cunning' => '2',
				'characteristic_willpower' => '2',
				'characteristic_presence' => '2',
				'soak' => '',
				'enc_total' => '',
				'enc_curr' => ''
			];
			$this->view('characters/newcharacter', $this->data);
		}
	}

	/**
	*
	*
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
			$this->data = [
				'char_id' => $id,
				'user_id' => $_SESSION['user_id'],
				'charname' => $_POST['charname'],
				'characteristic_brawn' => $_POST['characteristic_brawn'],
				'characteristic_agility' => $_POST['characteristic_agility'],
				'characteristic_intellect' => $_POST['characteristic_intellect'],
				'characteristic_cunning' => $_POST['characteristic_cunning'],
				'characteristic_willpower' => $_POST['characteristic_willpower'],
				'characteristic_presence' => $_POST['characteristic_presence'],
				'soak' => $_POST['soak'],
				'enc_total' => $_POST['enc_total'],
				'enc_curr' => $_POST['enc_curr']//,
				// 'charname_err' => '',
				// 'characteristic_brawn_err' => '',
				// 'characteristic_agility_err' => '',
				// 'characteristic_intellect_err' => '',
				// 'characteristic_cunning_err' => '',
				// 'characteristic_willpower_err' => '',
				// 'characteristic_presence_err' => '',
				// 'soak_err' => '',
				// 'enc_total_err' => '',
				// 'enc_curr_err' => ''
			];
			// Validate CharName
			if (empty($this->data['charname'])) {
				$this->data['charname_err'] = 'Please enter a name for your character.';
			}
			// Validate attributes
			$characteristics = [
				$this->data['characteristic_brawn'],
				$this->data['characteristic_agility'],
				$this->data['characteristic_intellect'],
				$this->data['characteristic_cunning'],
				$this->data['characteristic_willpower'],
				$this->data['characteristic_presence']
			];
			$this->validateFields($characteristic, 'Please enter a value.');

			// Validate soak
			if (empty($this->data['soak'])) {
				if (!empty($this->data['characteristic_brawn'])) {
					// Set soak to Brawn value
					$this->data['soak'] = $this->data['characteristic_brawn'];
				}
			}
			// Validate encumberance
			if (empty($this->data['enc_total'])) {
				if (!empty($this->data['characteristic_brawn'])) {
					// Set encumberance total to (Brawn value + 5)
					$this->data['enc_total'] = $this->data['characteristic_brawn'] + 5;
				}
			}
			if (empty($this->data['enc_curr'])) {
				// If empty default to 0
				$this->data['enc_curr'] = '0';
			}
			// Check for error entries in $this->data array
			if (empty($this->data['charname_err']) && empty($this->data['characteristic_brawn_err']) && empty($this->data['characteristic_agility_err']) && empty($this->data['characteristic_intellect_err']) && empty($this->data['characteristic_cunning_err']) && empty($this->data['characteristic_wis_err']) && empty($this->data['characteristic_presence_err'])) {
				// Form validated
				if ($this->characterModel->updateCharacter($this->data)) {
					flash('page_msg', 'Character updated!');
					url_redirect('characters/show/' . $id);
				} else {
					// Return with error flash message
					flash('page_err', 'Something went wrong! 01', 'alert alert-danger');
					$this->view('characters/edit', $this->data);
					exit();
				}
			} else {
				// Return to page with errors
				$this->view('characters/edit', $this->data);
			}
		} else {
			// Get character to edit
			$character = $this->characterModel->getCharacterById($id);
			if ($character) {
				// Check for post's owner
				if ($character->char__user_id != $_SESSION['user_id']) {
					flash('page_err', 'Nope', 'alert alert-danger');
					url_redirect('characters');
					exit();
				}
				$this->data = [
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
					'charname_err' => '',
					'characteristic_brawn_err' => '',
					'characteristic_agility_err' => '',
					'characteristic_intellect_err' => '',
					'characteristic_cunning_err' => '',
					'characteristic_willpower_err' => '',
					'characteristic_presence_err' => '',
					'soak_err' => '',
					'enc_total_err' => '',
					'enc_curr_err' => ''
				];

				$this->view('characters/edit', $this->data);
			} else {
				flash('page_err', 'Character not found!', 'alert alert-danger');
				url_redirect('characters');
			}
		}
	}
	/**
	*
	*
	* ----------------------------------------
	* Delete a character
	* ----------------------------------------
	*/
	public function delete($charId) {
		$character = $this->characterModel->getCharacterById($charId);
		if ($character) {
			// Character found
			// Check for post's owner
			if ($character->char__user_id != $_SESSION['user_id']) {
				flash('page_err', 'Oh no you don\'t!', 'alert alert-danger');
				url_redirect('characters');
				exit();
			}
			echo "Character found! ID: $charId NAME: " . $character->char__name;
			// Find Inventories & Containers
			$d = $this->inventoryModel->getInvId_Conatiners($charId);
			if ($d === false) {
				// No inventories or containers found
				die('No inventories or containers found');
			}
			// Go through array of inventories
			foreach ($d as $inv) {
				echo "<br>Inventory found! ID: ".$inv['inv_id'];
				// Go through array of conatiners
				foreach ($inv['containers'] as $container) {
					echo "<br>Conatiner found! ID: " . $container->cont__id . " NAME: " . $container->cont__name;
					$r = $this->inventoryModel->deleteContainer($container->cont__id);
					if($r !== TRUE) {
						die($r);
					}
				}
				$r = $this->inventoryModel->deleteInventory($inv['inv_id']);
				if($r !== TRUE) {
					die($r);
				}
			}
			$r = $this->characterModel->deleteCharacter($charId);
			if($r !== TRUE) {
				die($r);
			}
			// No character found!
			// flash('page_err', 'Character deleted!');
			// url_redirect('characters');
		} else {
			// No character found!
			flash('page_err', 'Couldn\'t find that character!', 'alert alert-danger');
			url_redirect('characters');
		}
	}
/*
 * ============================================================
 * Validate fields and return
 * ============================================================
 */
	public function validateFields($fields, $msg) {
		$return = [];
		foreach ($fields as $field => $value) {
			if (empty($value)) {

			}
		}
	}
/*
 * ============================================================
 * Add array to data
 * ============================================================
 */
	public function addToData($this->data, $arr) {
		$return = [];
		foreach ($fields as $field => $value) {
			if (empty($value)) {

			}
		}
	}



}
