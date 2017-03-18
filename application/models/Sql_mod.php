<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sql_mod extends CI_Model {


    private function _get_datatables_query($table, $order, $search){
         
        $this->db->from($table);
        $i = 0;
        foreach ($search as $item) {

            if($_POST['search']['value']) {
                 
                if($i===0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($_POST['order'])) {
            $this->db->order_by($order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all($table){
        $this->db->from($table);
        return $this->db->get()->result();
    }

    public function count_filtered($table) {
        return $this->db->get($table)->num_rows();
    }
 
    public function count_all($table) {
        $this->db->get($table);
        return $this->db->count_all_results();
    }

    public function msr($table, $field, $sb) {
        $this->db->order_by($field, $sb);
        return $this->db->get($table);
    }

    public function msrgp($table, $field, $sb, $gb) {
        $this->db->group_by($gb); 
        $this->db->order_by($field, $sb);
        return $this->db->get($table);
    }

    public function msrwhere($table, $com, $field, $sb) {
        $this->db->order_by($field, $sb);
        return $this->db->get_where($table, $com);
    }

    public function save($table, $set) {
        $this->db->insert($table, $set);
        return $this->db->insert_id();
    }
    
    public function edit($table, $set, $field, $id) {
        $this->db->where($field, $id);
        $this->db->update($table, $set);
    }
    
    public function delete($table, $field, $id) {
        $this->db->delete($table, array($field => $id));
    }



}