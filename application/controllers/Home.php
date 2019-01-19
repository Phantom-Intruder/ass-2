<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

    /**
     * Index Page for Home controller.
     */
    public function login()
    {
        $this->load->view('Navigation/UserNavigation/Header');
        //if user not logged in,
        if (!isset($this->session->userLoggedIn)) {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'userName',
                    'label' => 'Username',
                    'rules' => 'required',
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required',
                )
            ));
            $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
            if (!$this->form_validation->run()) {
                $this->load->view('Home/Login');
            }else{
                $this->load->model('User');
                $user = new User();
                $user->userName = $this->input->post('userName');
                $user->password = $this->input->post('password');
                if ($user->login()){
                    //success
                }else{
                    //retry
                    $this->load->view('Home/Login');
                }
            }
        }else{
            $this->load->view('Home/AlreadyLoggedIn');
            die();
        }
    }

    /**
     * Show editable list to user.
     */
    public function showListEditable()
    {
        //Get user from session
        if (isset($this->session->userLoggedIn)) {
            //Load user data from model
            $this->load->model('WishList');
            $wishList = $this->WishList->getFromUserId($this->session->userLoggedIn);
            //return View
            print json_encode($wishList);
        }else{
            //If no user, then redirect to login page
            redirect('/Home/Login', 'refresh');
        }
    }

    /**
     * Show viewable list to anonymous user.
     * @param int $listId
     */
    public function showListViewable($listId)
    {
        //Get list data from model
        $this->load->model('WishList');
        $wishList = $this->WishList->getFromListId($listId);
        //return View
    }

    /**
     * Show add form for item .
     * @param int $listId
     */
    public function addItem($listId)
    {
        //If listId is set then:
            // Get data from model for listId
            // Fill form view with data
        //else
            // show empty form
        //insert or update model and db
    }

    /**
     * Delete item from db and list.
     * @param int $listId
     */
    public function deleteItem($listId)
    {
        //check if item exists
        //If yes then delete
    }
}