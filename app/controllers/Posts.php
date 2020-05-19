<?php

class Posts extends Controller {

	public function __construct() {
		if (!isLoggedIn()) {
			url_redirect('users/login');
		}

		$this->postModel = $this->model('Post');
		$this->userModel = $this->model('User');
	}

	public function index() {
		// Get posts
		$posts = $this->postModel->getPosts();

		$data = [
			'posts' => $posts
		];

		$this->view('posts/index', $data);
	}

	public function add() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Sanitize POST array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data = [
				'title' => trim($_POST['title']),
				'body' => trim($_POST['body']),
				'user_id' => $_SESSION['user_id'],
				'title_err' => '',
				'body_err' => ''
			];

			// Validate data
			if (empty($data['title'])) {
				$data['title_err'] = 'Please enter a title for your post!';
			}
			if (empty($data['body'])) {
				$data['body_err'] = 'Please enter some text for your post!';
			}

			// Ensure there are no errors
			if (empty($data['title_err']) && empty($data['body_err'])) {
				// Validated
				if ($this->postModel->addPost($data)) {
					flash('post_msg', 'Post added!');
					url_redirect('posts');
				} else {
					die('Something went wrong');
				}
			} else {
				// load view with errors
				$this->view('posts/add', $data);
			}

		} else {
			$data = [
				'title' => '',
				'body' => ''
			];

			$this->view('posts/add', $data);
		}
	}

	public function edit($id) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Sanitize POST array
			$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$data = [
				'id' => $id,
				'title' => trim($_POST['title']),
				'body' => trim($_POST['body']),
				'user_id' => $_SESSION['user_id'],
				'title_err' => '',
				'body_err' => ''
			];

			// Validate data
			if (empty($data['title'])) {
				$data['title_err'] = 'Please enter a title for your post!';
			}
			if (empty($data['body'])) {
				$data['body_err'] = 'Please enter some text for your post!';
			}

			// Ensure there are no errors
			if (empty($data['title_err']) && empty($data['body_err'])) {
				// Validated
				if ($this->postModel->updatePost($data)) {
					flash('post_msg', 'Post updated!');
					url_redirect('posts');
				} else {
					die('Something went wrong');
				}
			} else {
				// load view with errors
				$this->view('posts/edit', $data);
			}

		} else {
			// Get post
			$post = $this->postModel->getPostById($id);
			if ($post) {
				// Check for post's owner
				if ($post->user_id != $_SESSION['user_id']) {
					url_redirect('posts');
				}

				$data = [
					'id' => $id,
					'title' => $post->title,
					'body' => $post->body
				];

				$this->view('posts/edit', $data);
			} else {
				flash('post_msg', 'Post not found!', 'alert alert-danger');
				url_redirect('posts');
			}
		}
	}

	// Show a specific post
	public function show($id) {
		$post = $this->postModel->getPostById($id);
		if ($post) {
			$user = $this->userModel->getUserById($post->user_id);
			$data = [
				'post' => $post,
				'user' => $user
			];
			$this->view('posts/show', $data);
		} else {
			flash('post_msg', 'Post not found!', 'alert alert-danger');
			url_redirect('posts');
		}
	}

	public function delete($id) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = $this->postModel->getPostById($id);
			if ($post) {
				// Check for post's owner
				if ($post->user_id != $_SESSION['user_id']) {
					url_redirect('posts');
				}

				if ($this->postModel->deletePost($id)) {
					flash('post_msg', 'Post deleted!');
					url_redirect('posts');
				} else {
					flash('post_msg', 'Something went wrong!', 'alert alert-danger');
					url_redirect('post');
				}
			} else {
				url_redirect('post');
			}
		} else {
			url_redirect('post');
		}
	}

}
