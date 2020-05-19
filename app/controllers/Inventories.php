<?php

class Inventories extends Controller {
	public function __construct() {
		$this->userModel = $this->model('User');
		$this->inventoryModel = $this->model('Inventory');
		$this->characterModel = $this->model('Character');
	}
/*
 * ============================================================
 * Create a new container
 * ============================================================
 */
	public function newContainer($invId = '') {
		// code...
	}
/*
 * ============================================================
 * Create a new item
 * ============================================================
 */
	public function newContainer($invId = '') {
		// code...
	}
}
