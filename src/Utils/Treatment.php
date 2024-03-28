<?php
namespace App\Utils;


class Treatment {

    private string $label;
    private TreatmentStrategy $strategy;
    private string $icon;

    private $data;

    public function __construct(string $label, TreatmentStrategy $strategy, string $icon, $data) {
        $this->label = $label;
        $this->icon = $icon;
        $this->strategy = $strategy;
        $this->data = $data;
    }

    public function getLabel(): string {
        return $this->label;
    }

    public function getStrategy(): TreatmentStrategy {
        return $this->strategy;
    }

    public function getIcon(): string {
        return $this->icon;
    }

    public function apply(string $column){
        $this->strategy->execute($column, $this->data);
    }

}