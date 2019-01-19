<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

    /**
     * Shows login page to user if not logged in.
     */
    public function login()
    {
        $this->load->view('Navigation/UserNavigation/Header');
        //if user not logged in,
        if (!isset($this->session->userLoggedIn)) {
            $this->load->view('Home/Login');
        }else{
            $this->load->view('Home/AlreadyLoggedIn');
        }
        $this->load->view('Navigation/UserNavigation/footer');
    }

    /**
     * Checks user login
     */
    public function checkLogin(){
        header('Content-type: application/json');
        $username = $this->uri->segment(3);
        $password = $this->uri->segment(4);
        $this->load->model('User');
        $user = $this->User->getUserFromLogin($username, $password);
        if (isset($user)){
            $this->session->userLoggedIn = $user;
        }else{
            print json_encode("Wrong pass");
        }
    }

    /**
     * Shows register page to user if not registered.
     */
    public function register()
    {
        $this->load->view('Navigation/UserNavigation/Header');
        //if user not logged in,
        if (!isset($this->session->userLoggedIn)) {
            $this->load->view('Home/Register');
        }else{
            $this->load->view('Home/AlreadyLoggedIn');
        }
        $this->load->view('Navigation/UserNavigation/footer');
    }

    /**
     * Logout a user
     */
    public function logout(){
        header('Content-type: application/json');
        if (isset($this->session->userLoggedIn )){
            $this->session->userLoggedIn = null;
        }else{
            print json_encode("Not logged in");
        }
    }


    /**
     * Show editable list to user.
     */
    public function showListEditable()
    {
        //Get user from session
        if (isset($this->session->userLoggedIn)) {
            $this->load->view('Navigation/UserNavigation/header');
            //Load user data from model
            $this->load->model('WishList');
            $wishList = $this->WishList->getFromUserId($this->session->userLoggedIn->id);
            //return View
            $this->load->view('Home/List', array(
                'wishList' => $wishList,
            ));
            $this->load->view('Navigation/UserNavigation/footer');
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
        $this->load->view('Navigation/UserNavigation/header');
        //Get list data from model
        $this->load->model('WishList');
        $wishList = new WishList();
        $wishList->load($listId);
        $wishList = $this->WishList->getFromListId($listId);
        //return View
        $this->load->view('Home/List', array(
            'wishList' => $wishList,
        ));
        $this->load->view('Navigation/UserNavigation/footer');
    }

    /**
     * Show add form for item .
     * @param int $itemId
     */
    public function showItemForm($itemId)
    {
        //If listId is set then:
        if (isset($listId)){
            // Get data from model for listId
            $this->load->model('Item');
            $item = new Item();
            $item->load($itemId);
            $this->load->view('Home/Item/Show', array(
                'item' => $item,
            ));
        }else{
            // show empty form
            $this->load->view('Home/Item/Show');
        }
        //insert or update model and db
    }

    /**
     * Add or update item
     * @param item $item
     */
    public function addOrUpdateItem($item)
    {
        $this->load->model('Item');
        $changedItem = new Item();
        $changedItem = $item;
        $changedItem->save();
    }

    /**
     * Delete item from db and list.
     * @param int $itemId
     */
    public function deleteItem($itemId)
    {
        //check if item exists
        $this->load->model('Item');
        $item = new Item();
        //If yes then delete
        $item->load($itemId);
        $item->delete($itemId);
    }
}