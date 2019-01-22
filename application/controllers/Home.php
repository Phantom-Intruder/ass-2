<?php
require APPPATH . 'libraries/REST_Controller.php';

class Home extends REST_Controller
{

    /**
     * Shows login page to user if not logged in.
     */
    public function login_get()
    {
        $this->load->view('Navigation/UserNavigation/Header');
        //if user not logged in,
        if (!isset($this->session->userLoggedIn)) {
            $this->load->view('User/Login');
        }else{
            redirect('/Home/List', 'refresh');
        }
        //$this->load->view('Navigation/UserNavigation/footer');
    }

    /**
     * Checks user login
     */
    public function login_post(){
        header('Content-type: application/json');
        $this->load->model('User');
        $user = $this->User->getUserFromLogin($this->post('username'), $this->post('password'));
        if (isset($user)){
            $this->session->userLoggedIn = $user;
            redirect('/List/Show', 'refresh');
        }else{
            print json_encode("Wrong pass");
        }
    }

    /**
     * Shows register page to user if not registered.
     */
    public function register_get()
    {
        $this->load->view('Navigation/UserNavigation/Header');
        //if user not logged in,
        if (!isset($this->session->userLoggedIn)) {
            $this->load->view('User/Register');
        }else{
            $this->load->view('User/AlreadyLoggedIn');
        }
        //$this->load->view('Navigation/UserNavigation/footer');
    }

    /**
     * Gets user and wish list data from register page
     */
    public function register_post(){
        header('Content-type: application/json');
        date_default_timezone_set('Asia/Colombo');

        $this->load->model('User');
        $user = new User();
        $user->firstName = $this->post('firstName');
        $user->username = $this->post('username');
        $user->password = password_hash($this->post('password'), PASSWORD_DEFAULT);
        $user->dateCreated = date("Y-m-d H:i:s");
        $insertId = $user->save();

        $this->load->model('WishList');
        $wishList = new WishList();
        $wishList->ownerId = $insertId;
        $wishList->listName= $this->post('listName');
        $wishList->description = $this->post('description');
        $wishList->listCreated = date("Y-m-d H:i:s");

        $wishList->save();

        if (isset($user)){
            $this->session->userLoggedIn = $user;
            redirect('/List/Show', 'refresh');
        }else{
            print json_encode("Wrong pass");
        }
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
    public function list_get()
    {
        //Get user from session
        if (isset($this->session->userLoggedIn)) {
            $this->load->view('Navigation/UserNavigation/header');
            //return View
            $this->load->view('List/Show');
            //$this->load->view('Navigation/UserNavigation/footer');
        }else{
            //If no user, then redirect to login page
            redirect('/Home/Login', 'refresh');
        }
    }

    /**
     * Gets items in users list with userID
     */
    public function item_get()
    {
        header('Content-type: application/json');
        if (isset($this->session->userLoggedIn)) {
            //Load wish list data from model
            $this->load->model('WishList');
            //print_r($this->session->userLoggedIn['0']->id);
            $wishList = $this->WishList->getFromUserId($this->session->userLoggedIn['0']->id);
            //get items from wishlist
            $this->load->model('Item');
            //echo $wishList[0]->id;
            $items = $this->Item->getByListId($wishList[0]->id);
            print json_encode($items);
        }else{
            //If no user, then redirect to login page
            redirect('/User/Login', 'refresh');
        }
    }

    /**
     * Gets posted item and adds it
     */
    public function item_post()
    {
        header('Content-type: application/json');
        date_default_timezone_set('Asia/Colombo');

        $this->load->model('Item');
        $item = new Item();
        $item->title = $this->post('title');
        $item->url = $this->post('url');
        $item->price = $this->post('price');
        $item->priority = $this->post('priority');

        //Load wish list data from model
        $this->load->model('WishList');
        //print_r($this->session->userLoggedIn['0']->id);
        $wishList = $this->WishList->getFromUserId($this->session->userLoggedIn['0']->id);

        $item->listId = $wishList[0]->id;
        $item->itemCreated = date("Y-m-d H:i:s");;

        $item->save();
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