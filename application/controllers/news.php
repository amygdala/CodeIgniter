<?php
class News extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('news_model');
	}

  public function index() {
    $data['news'] = $this->news_model->get_news();
    $data['title'] = 'News archive';

    $this->load->view('news/index', $data);
  }

  public function view($slug) {
    $data['news_item'] = $this->news_model->get_news($slug);

    if (empty($data['news_item'])) {
      show_404();
    }

    $data['title'] = $data['news_item']['title'];

    $this->load->view('news/view', $data);
  }

  public function create() {
    $this->load->helper('form');
    $this->load->library('form_validation');

    $data['title'] = 'Create a news item';

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('text', 'text', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->load->view('news/create');

    }
    else {
      $this->news_model->set_news();
      redirect('/news/');
    }
  }
}
