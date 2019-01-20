<?php

class User extends CI_Model {
    const DB_TABLE_NAME = 'user';
    const DB_TABLE_PK_VALUE = 'id';
    const DB_TABLE_USERNAME = 'username';

    /**
 * User unique id
 * @var int
 */
    public $id;

    /**
     * User first name
     * @var string firstName
     */
    public $firstName;

    /**
     * User username
     * @var string username
     */
    public $username;

    /**
     * User password
     * @var string password
     */
    public $password;

    /**
     * Date user profile was created
     * @var datetime dateCreated
     */
    public $dateCreated;

    /**
     * Create a record for user.
     * @return int insert id
     */
    private function insert(){
        $this->db->insert($this::DB_TABLE_NAME, $this);
        $this->{$this::DB_TABLE_PK_VALUE} = $this->db->insert_id();
        return $this->db->insert_id();
    }

    /**
     * Insert user.
     * @return int insert id
     */
    public function save(){
        return $this->insert();
    }

    /**
     * Load user data from the database
     * @param int $id
     */
    public function load($id){
        $query = $this->db->get_where($this::DB_TABLE_NAME, array(
            $this::DB_TABLE_PK_VALUE => $id,
        ));
        $this->populate($query->row());
    }

    /**
     * Populate data from an array
     * @param mixed $row
     */
    public function populate($row){
        foreach ($row as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * Retrieve array of user models.
     *
     * @param int $limit
     * @param int $offset
     * @return array of user models from db, key is PK.
     */
    public function get($limit = 100, $offset = 0){
        if ($limit){
            $query = $this->db->get($this::DB_TABLE_NAME, $limit, $offset);
        }
        else{
            $query = $this->db->get($this::DB_TABLE_NAME);
        }
        $ret_value = array();
        $class = get_class($this);
        foreach ($query->result() as $row){
            $model = new $class;
            $model->populate($row);
            $ret_value[$row->{$this::DB_TABLE_PK_VALUE}] = $model;
        }
        return $ret_value;
    }

    /**
     * Get user if exists
     *
     * @param string username
     * @param string password
     * @return User object
     */
    public function getUserFromLogin($username, $password){
        $this->db->where($this::DB_TABLE_USERNAME, $username);
        $ret_val = $this->db->get($this::DB_TABLE_NAME);
        if ($ret_val->num_rows() != 1){
            //No such user
            return null;
        }
        else{
            $row = $ret_val->result();
            echo json_encode($row);
            $password_hash = $row['0']->password;
            if (password_verify($password, $password_hash)){
                return $row;
            }else{
                return null;
            }
        }
    }
}