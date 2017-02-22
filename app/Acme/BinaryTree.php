<?php

class BinaryNode
{
    public $data;    // contains the node item
    public $left;     // the left child BinaryNode
    public $right;     // the right child BinaryNode

    public function __construct($item) 
    {
        $this->data = $item;        
        $this->left = null;
        $this->right = null;
    }
}

class BinaryTree
{
    protected $root;

    public function __construct() 
    {
        $this->root = null;
    }

    public function isEmpty() 
    {
        return $this->root === null;
    }

    public function insert($item) 
    {
        $node = new BinaryNode($item);
        if ($this->isEmpty()) {
            $this->root = $node;
        } else {
            $this->insertNode($node, $this->root);
        }
    }

    protected function insertNode($node, &$subtree) 
    {
        if ($subtree === null) {
            $subtree = $node;
        }
        else {
            if ($node->value > $subtree->value) {
                $this->insertNode($node, $subtree->right);
            }
            else if ($node->value < $subtree->value) {
                $this->insertNode($node, $subtree->left);
            }
            else {
                // reject duplicates
            }
        }
    }
}