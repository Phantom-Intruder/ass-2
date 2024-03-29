<?php

class Item extends CI_Model {

    const DB_TABLE_NAME = 'item';
    const DB_TABLE_PK_VALUE = 'id';
    const DB_TABLE_LIST_ID = 'listId';

    /**
     * Item number unique id
     * @var int
     */
    public $id;

    /**
     * List id of item
     * @var int
     */
    public $listId;

    /**
     * Item title
     * @var string
     */
    public $title;

    /**
     * Item url
     * @var string
     */
    public $url;

    /**
     * Item price
     * @var decimal
     */
    public $price;

    /**
     * Item priority
     * @var int
     */
    public $priority;

    /**
     * Item Created date time
     * @var datetime
     */
    public $itemCreated;

    /**
     * Create a record for item
     */
    private function insert(){
        $this->db->insert($this::DB_TABLE_NAME, $this);
        $this->{$this::DB_TABLE_PK_VALUE} = $this->db->insert_id();
        return $this->db->insert_id();
    }

    /**
     * If the record for item is there then update.
     * Else insert.
     */
    public function save(){
        if (isset($this->{$this::DB_TABLE_PK_VALUE})){
            return $this->update();
        }else{
            return $this->insert();
        }
    }

    /**
     * Delete item
     * @param int $id
     */
    public function delete($id){
        $this->db->delete($this::DB_TABLE_NAME, array($this::DB_TABLE_PK_VALUE => $id));
    }

    /**
     * Update item details
     */
    private function update(){
        $this->db->replace($this::DB_TABLE_NAME, $this, $this::DB_TABLE_PK_VALUE);
        return $this->id;
    }

    /**
     * Load item data from the database
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
     * Retrieve array of item models.
     *
     * @param int $limit
     * @param int $offset
     * @return array of item models from db, key is PK.
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
     * Get all the items in a wish list
     * @param int listId
     * @return array of item objects
     */
    public function getByListId($listId){
        $this->db->order_by("priority", "desc");
        $query = $this->db->get_where($this::DB_TABLE_NAME, array(
            $this::DB_TABLE_LIST_ID => $listId,
        ));
        $ret_value = array();
        $class = get_class($this);
        foreach ($query->result() as $row){
            $model = new $class;
            $model->populate($row);
            if ($model->priority == 1){
                $model->priority = "Must Have";
            }else if($model->priority == 2){
                $model->priority = "Would Be Nice To Have";
            }else{
                $model->priority = "If You Can";
            }
            $ret_value[$row->{$this::DB_TABLE_PK_VALUE}] = $model;
        }
        return $ret_value;
    }
}