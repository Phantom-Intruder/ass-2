<?php

class WishList extends CI_Model
{
    const DB_TABLE_NAME = 'user_list';
    const DB_TABLE_PK_VALUE = 'id';

    /**
     * List unique id
     * @var int
     */
    public $id;

    /**
     * List owner id
     * @var int ownerId
     */
    public $ownerId;

    /**
     * List name
     * @var string listName
     */
    public $listName;

    /**
     * List description
     * @var string description
     */
    public $description;

    /**
     * Date list was created
     * @var datetime listCreated
     */
    public $listCreated;

    /**
     * Create a record for list.
     */
    private function insert(){
        $this->db->insert($this::DB_TABLE_NAME, $this);
        $this->{$this::DB_TABLE_PK_VALUE} = $this->db->insert_id();
    }

    /**
     * Insert list.
     */
    public function save(){
        $this->insert();
    }

    /**
     * Load list data from the database
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
     * Retrieve array of wish list models.
     *
     * @param int $limit
     * @param int $offset
     * @return array of wish list models from db, key is PK.
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

}
