<?php 
namespace Utils;

class TableColumn {
    private string $id;
    private string $label;
    private ?string $class;
    private bool $activated = true;
    private $sort;

    public function __construct($id, $label, $class, $activated, $sort) {
        $this->id = $id;
        $this->label = $label;
        $this->class = $class;
        $this->activated = $activated;
        $this->sort = $sort;
    }

    public function getId () {
        return $this->id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getClass () {
        return $this->class;
    }

    public function getActivated () {
        return $this->activated;
    }

    public function getSort () {
        return $this->sort;
    }

    public function __toString () {
        return $this->label;
    }

}