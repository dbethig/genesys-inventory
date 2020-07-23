<?php

class Containers extends Controller {
	public function __construct() {
		$this->elementModel = $this->model('Element');
		$this->userModel = $this->model('User');
		$this->inventoryModel = $this->model('Inventory');
		$this->characterModel = $this->model('Character');
		$this->containerModel = $this->model('Container');
		$this->data_err = false;
	}
/*
 * ============================================================
 * Create a new container
 * ============================================================
 */
	public function newContainer($charId) {
		// $this->containerModel->checkOwner($contId, $charId);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$inv = $this->inventoryModel->getInventoryByCharacter($charId);
			if (!$inv) {
				flash('page_err', 'Opps, something went wrong!', 'alert alert-danger');
				url_redirect('characters/show/' .$charId);
			}

			// Sanitize POST array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			// Add POST array to $data
			$data['cont'] = $_POST;
			// Calculate list order and add to array
			$listOrder = $this->containerModel->countContainersByInv($inv->inv__id) + 1;
			$data['cont'] += [
				'cont__inv_id' => $inv->inv__id,
				'cont__order' => $listOrder
			];
			// printAndDie($data);
			$newCont = $this->elementModel->createElement('containers', $data['cont']);
			if ($newCont === TRUE) {
				flash('page_msg', 'Container Created!');
				url_redirect('characters/show/' .$charId);
			} else {
				flash('page_err', 'Error creating container<br>' . $newCont, 'alert alert-danger');
				$this->view('containers/newContainer', $data);
			}
		} else {
			$data = $this->elementModel->createEmptyElement('containers', 'cont');
			$data['char__id'] = $charId;
			$this->view('containers/newContainer', $data);
		}
	}
/*
 * ============================================================
 * Edit a Conatiner
 * ============================================================
 */
	public function edit($ids) {
		// conatinerID:containerID
		$ids = explode(':', $ids);
		$contId = $ids[0];
		$charId = $ids[1];
		$cont = (array) $this->containerModel->getContainerById($contId);

		if(!$cont) {
			flash('page_err', 'Opps, something went wrong!', 'alert alert-danger');
			url_redirect('characters/show/' .$charId);
		}
		$data = [
			'char__id' => $charId,
			'cont' => [
				'cont__id' => $contId
			]
		];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			/*
			 * ------------------------------------
			 * POST request
			 * ------------------------------------
			 */
			// Sanitize POST array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			// Add $_POST data to container array
			// $data['cont'] = $_POST;
			$data['cont'] = array_merge($data['cont'], $_POST);

			// Validate fields and compire errors array
			$errors = $this->validateFields($data['cont']);
			$data['errors'] = $errors;
			// printAndDie($data);

			if ($this->data_err === false) {
				// Form validated
				// printAndDie($data);
				if ($this->elementModel->updateElement('containers', $data['cont'], 'cont__id')) {
				// if ($this->containerModel->updateContainer($data['cont'])) {
					flash('page_msg', 'Container updated!');
				} else {
					flash('page_err', 'Error updating container', 'alert alert-danger');
				}
				url_redirect('characters/show/' .$charId);
			} else {
				// Add cont__id to $data array
				// Used to populate urls on page
				$data['cont']['cont__id'] = $contId;
				flash('page_err', 'Error creating container', 'alert alert-danger');
				// Return to page with errors
				$this->view('containers/edit', $data);
			}
		} else {
			/*
			 * ------------------------------------
			 * Not a POST request
			 * ------------------------------------
			 */
			$data = [
				'char__id' => $charId,
				'cont' => $cont
			];
			$data['errors'] = $this->elementModel->emptyErrorArray($cont);
			// printAndDie($data);
			$this->view('containers/edit', $data);
		}
	}
/*
 * ============================================================
 * Delete a container
 * ============================================================
 */
	public function delete($id)	{
		$charId = $this->containerModel->getCharId($id);
		if (!$charId) {
			flash('page_err', 'Something went wrong!', 'alert alert-danger');
			url_redirect('characters');
		}
		$cont = $this->containerModel->getContainerById($id);
		$deletedOrder = $cont->cont__order;
		$r = $this->elementModel->deleteElement('containers', $id , 'cont__id');
		$conts = $this->containerModel->getContainers($cont->cont__inv_id);
		$toUpdate = array_filter(array_map(function($c) use ($deletedOrder) {
			$order = $c->cont__order;
			if ($order > $deletedOrder) {
				$r = [
					'cont__id' => $c->cont__id,
					'cont__order' => --$order
				];
				return $r;
			}
		}, $conts));
		// printAndDie($toUpdate);
		$this->elementModel->updateElements('containers', $toUpdate, 'cont__id');
		if ($r) {
			flash('page_msg', 'Container Deleted');
			url_redirect('characters/show/' .$charId);
		} else {
			flash('page_err', 'Error deleting container', 'alert alert-danger');
		}
	}
/*
 * ============================================================
 * Validate contianer fields
 * ============================================================
 */
	public function validateFields($data, $msg = 'Enter a valid number') {
		$errors = [];
		// Validate name field
		if (empty($data['cont__name'])) {
			$errors['cont__name'] = 'Please enter a name.';
			$this->data_err = true;
		}
		// Validate all integer fields
		$intFields = ['cont__enc', 'cont__capacity'];
		$intErrors = $this->elementModel->validateIntergers($intFields, $data);
		$errors = array_merge($errors, $intErrors);
		return $errors;
	}
/*
 * ============================================================
 * Edit container list order
 * ============================================================
 */
	public function listOrder($data)	{
		if (!$data) {
			errorpage("Data array empty");
		}
		$data = explode(':', $data);
		$dir = $data[0];
		$contId = $data[1];

		$cont = $this->elementModel->getElementById('containers', 'cont__id', $contId);
		// printAndDie($cont);
		$charId = $this->containerModel->getCharId($contId);
		if (!$charId) {
			errorpage("Character ID not found for container $contId");
		}
		$orderMax = $this->containerModel->countContainersByInv($cont->cont__inv_id);
		$order = $cont->cont__order;
		if (($dir === '0' && $order !== $orderMax) || ($dir === '1' && $order !== 1)) {
			if ($dir === '1') {
				// Move container above it down in the order list
				$otherOrder = $cont->cont__order - 1;
				$otherDir = 'down';
				$mainDir = 'up';
			} else {
				// Move container below it up in the order list
				$otherOrder = $cont->cont__order + 1;
				$otherDir = 'up';
				$mainDir = 'down';
			}
			// Move container above/below it
			$where['c'] = [
				'cont__inv_id' => $cont->cont__inv_id,
				'cont__order' => $otherOrder
			];
			$this->containerModel->updateOrder($this->elementModel->getElement('containers', $where), $otherDir);
			// Move conatiner in the list order
			$this->containerModel->updateOrder($cont, $mainDir);
		}
		url_redirect("characters/show/$charId");
	}

}
