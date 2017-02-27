<?php

namespace Acme;

class BinaryNode
{
    public $data;
    public $left;
    public $right;

    public function __construct($data) 
    {
        $this->data = $data;        
        $this->left = null;
        $this->right = null;
    }
}

class BinaryTree
{
    protected $head;   

    public function __construct($data = null) 
    {
        $this->head = $data;
    } 
 
    public function add($item)
    {   
        $this->addTo($this->head, $item);
    }

    protected function addTo($node, $item)
    {
        $direction = $item->direction === 'L' ? 'left' : 'right';

        if($node->data->id == $item->placement_id)
        {
            $node->{$direction} = new BinaryNode($item);            
        }
        else{
            if($node->{$direction} !== null)
            {
                $this->addTo($node->{$direction}, $item);
            }            
        }
    }

    public function render($root)
    {
        $this->head = new BinaryNode($root);

        $this->orderPlacementAscending()->each(function($el){
            $this->add($el);
        });
    }

    public function level($number)
    {
        // $node = $this->head;
        
        // for($i=0; $i<$number; $i++)
        // {
        //     if($node->)
        // }
        // return 
    }

    public function headChildren()
    {
        return $this->orderPlacementAscending();
    }

    protected function orderPlacementAscending()
    {
        return $this->head->data->children
                ->sortBy('placement_id');
    }

    public function toArray()
    {
        $data = [
            'id'            => $this->head->data->id,
            'sponsor_id'    => $this->head->data->sponsor_id,
            'placement_id'  => $this->head->data->placement_id,
            'username'      => $this->head->data->username,
            'left' => null,
            'right' => null,
        ];        

        $node_left = $this->head->left;
        $data_l = &$data['left'];
        while($node_left !== null)
        {
            $data_l = [ 
                'id'            => $node_left->data->id,
                'sponsor_id'    => $node_left->data->sponsor_id,
                'placement_id'  => $node_left->data->placement_id,
                'username'      => $node_left->data->username,
            ];

            $data_l = &$data_l['left'];
            $node_left = $node_left->left;
        }

        $node_right = $this->head->right;
        $data_r = &$data['right'];
        while($node_right !== null)
        {
            $data_r = [
                'id'            => $node_right->data->id,
                'sponsor_id'    => $node_right->data->sponsor_id,
                'placement_id'  => $node_right->data->placement_id,
                'username'      => $node_right->data->username,
            ];

            $data_r = &$data_r['right'];
            $node_right = $node_right->right;
        }

        return $data;
    }
}