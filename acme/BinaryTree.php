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
 
    public function add($item, $direction = null)
    {     
        if ($this->head == null)
        {
            $this->head = new BinaryNode($item);
        }
        else
        {
            addTo($this->head, $item, $direction);
        }
    }


    protected function addTo($node, $item, $direction)
    {
        if ($direction == 'L')
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
        elseif($direction == 'R')
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

        $this->orderPlacementAscending()->each(function($el){
            //$this->add($el);
        });



    }

    public function level($number)
    {
        
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

}