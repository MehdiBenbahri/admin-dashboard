<?php 

class Sort {

    private string $label;
    private string $action;
    private string $icon;

    public function __construct(string $label, string $action, $icon) {
        $this->label = $label;
        $this->action = $action;
        $this->icon = $icon;
    }

}