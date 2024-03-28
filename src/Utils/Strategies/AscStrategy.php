<?php 
namespace App\Utils;
use Doctrine\ORM\QueryBuilder;

class AscStrategy implements TreatmentStrategy {

    public function getKey() {
        return "sort:asc";
    }

    public function execute(string $column, QueryBuilder $query){
        return $query->orderBy($column, "ASC");
    }

}