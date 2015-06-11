<?php

class domain{

    protected $id,
              $name,
              $exists   = 0;

    function __construct($id = 1){

        // Get the Quest (Skill) based on the id
        if (is_numeric($id)){
            $domain_row = get_domain($id);
            $this->build($domain_row);
        }
    }

    function build($domain_row){
        if ($domain_row->id > 0){
            $this->exists = 1;
            $this->id     = $domain_row->id;
            $this->name   = $domain_row->name;
        }
    }

    function get_id(){
        return $this->id;
    }

    function get_name(){
        return $this->name;
    }
}