<?php
require APPPATH . 'libraries/REST_Controller.php';

class Home extends REST_Controller
{

    /**
     * Show editable list to user.
     */
    public function index_get()
    {
        //Get user from session
        if (isset($this->session->wishListId)) {
            $this->load->view('Navigation/UserNavigation/header');

            $this->load->view('List/Show');
        }else{
            //If no user, then redirect to login page```
            redirect('/Home/Login/Directed/1', 'refresh');
        }
    }

    /**
     * Shows login page to user if not logged in.
     * @param int $directed
     */
    public function login_get($directed = 0)
    {
        $this->load->view('Navigation/UserNavigation/Header');
        //if user not logged in,
        if (!isset($this->session->wishListId)) {
            $this->load->view('User/Login', array(
                'directed' => $directed,
            ));
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
            //print_r($user);
            $this->load->model('WishList');
            $wishList = $this->WishList->getFromUserId($user['0']->id);
            $this->session->firstName = $user['0']->firstName;
            $this->session->wishListId = $wishList['0']->id;
            $data['loginValid'] = true;
            //print json_encode($data);
        }else{
            $data['loginValid'] = false;
            //print json_encode($data);
        }
    }

    /**
     * Shows register page to user if not registered.
     */
    public function register_get()
    {
        $this->load->view('Navigation/UserNavigation/Header');
        //if user not logged in,
        if (!isset($this->session->wishListId)) {
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
            $this->session->wishListId = $wishList->id;
            $this->session->firstName = $user->firstName;
        }else{
            print json_encode("Wrong pass");
        }
    }

    /**
     * Logout a user
     */
    public function logout_get(){
        header('Content-type: application/json');
        if (isset($this->session->wishListId)){
            session_destroy();
            redirect('/Home/Login', 'refresh');
        }else{
            print json_encode("Not logged in");
        }
    }

    /**
     * Gets items in users list with userID
     */
    public function items_get()
    {
        header('Content-type: application/json');
        if (isset($this->session->wishListId)) {
            $this->load->model('Item');
            //echo $wishList[0]->id;
            $items = $this->Item->getByListId($this->session->wishListId);
            print json_encode($items);
        }else{
            //If no user, then redirect to login page
            redirect('/User/Login', 'refresh');
        }
    }

    /**
     * Show non editable page
     */
    public function list_view_get($id){
        $this->load->view('Navigation/UserNavigation/Header');
        $this->load->library('table');

        $this->load->model('WishList');
        $wishList = new WishList();
        $wishList->load($this->session->wishListId);

        $this->load->model('Item');
        $items = $this->Item->getByListId($id);
        $itemsList = array();
        foreach ($items as $item){
            $itemsList[] = array(
                $item->title,
                anchor($item->url, $item->url),
                $item->price,
                $item->priority,
            );
        }
        $this->load->view('List/View', array(
            'firstName' => $this->session->firstName,
            'wishList' => $wishList,
            'items' => $itemsList
        ));
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
        if ($this->post('priority') == "Must Have"){
            $item->priority = 1;
        }else if($this->post('priority') == "Would Be Nice To Have"){
            $item->priority = 2;
        }else{
            $item->priority = 3;
        }
        //Load wish list data from model
        $this->load->model('WishList');

        $wishList = $this->WishList->getFromUserId($this->session->wishListId);

        $item->listId = $wishList[0]->id;
        $item->itemCreated = date("Y-m-d H:i:s");;

        $itemId = $item->save();
        $item->id = $itemId;
        print json_encode($item);
    }

    /**
     * Deletes sent items from database
     */
    public function item_delete($id){
        header('Content-type: application/json');

        $this->load->model('Item');
        $item = new Item();

        $item->delete($id);
        $item->id = (int)$id;
        print json_encode($item);
    }

    /**
     * Updates one item
     */
    public function item_put()
    {
        header('Content-type: application/json');
        date_default_timezone_set('Asia/Colombo');

        $this->load->model('Item');
        $item = new Item();
        $item->id = $this->put('id');
        $item->title = $this->put('title');
        $item->url = $this->put('url');
        $item->price = $this->put('price');
        if ($this->put('priority') == "Must Have"){
            $item->priority = 1;
        }else if($this->put('priority') == "Would Be Nice To Have"){
            $item->priority = 2;
        }else{
            $item->priority = 3;
        }

        $item->listId = $this->session->wishListId;
        $item->itemCreated = date("Y-m-d H:i:s");;

        $itemId = $item->save();
        $item->id = $itemId;
        print json_encode($item);
    }

    /**
     * Gets shareable link
     */
    public function link_get(){
        header('Content-type: application/json');
        $data['link'] = base_url()."index.php/Home/list_view/".html_escape($this->session->wishListId);
        print json_encode($data);
    }
}