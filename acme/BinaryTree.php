<?php

namespace Acme;

class BinaryNode
{
    public $data;
    public $left;
    public $right;

    public function __construct($item) 
    {
        $this->data = $item;        
        $this->left = null;
        $this->right = null;
    }
}

class BinaryTree
{
    protected $head;
    protected $placement;
    protected $direction;   

    public function __construct($data = null, $placement = null, $direction = null) 
    {
        $this->head = $data !== null ? new BinaryNode($data) : null;
        $this->placement = $placement;
        $this->direction = $direction;
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

    public function render()
    {
        if($this->head === null) throw new \Exception('Root cannot be null');

        $children = $this->head->data->children->sortByDesc($this->placement);

        dd($children->map(function($item, $key){ return [$item->username, $item->placement_id]; }));

        $children->each(function($item, $key) {
            var_dump($item->placement_id);
        });
    }

    public function toArray()
    {
    }
}