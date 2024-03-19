<?php 
namespace Utils;

class TableColumn {
    private string $id;
    private string $label;
    private ?string $class;
    private bool $activated = true;
    private \Sort $sort;

    public function __construct($id, $label, $class, $activated) {
        $this->id = $id;
        $this->label = $label;
        $this->class = $class;
        $this->activated = $activated;
    }

}