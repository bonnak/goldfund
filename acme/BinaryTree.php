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
        if ($item->direction == 'L')
        {
            if ($node->left == null)
            {
                $node->left = new BinaryNode($item);
            }
            else
            {
                $this->addTo($node->left, $item);
            }
        }
        elseif($item->direction == 'R')
        {
            if ($node->right == null)
            {
                $node->right = new BinaryNode($item);
            }
            else
            {
                $this->addTo($node->right, $item);
            }
        }
    }

    public function render($root)
    {
        $this->head = new BinaryNode($root);

        $children = $this->orderPlacementAscending();
        
        $children->each(function($child){
            $this->add($child);
        });
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
        $node = $this->head;
        $array = [];

        do
        {
            array_push($array, [ 'data' => $node->data->toArray() ]);
            $node = $node->left;

            array_push($array, [ 'left' => []]);
            $array = $array['left'];
        }while($node !== null);

        return $array;
    }
}