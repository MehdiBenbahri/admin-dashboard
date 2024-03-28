<?php 
namespace App\Utils;
use Doctrine\ORM\QueryBuilder;
class DescStrategy implements TreatmentStrategy {

    public function getKey() {
        return "sort:desc";
    }

    public function execute(string $column, QueryBuilder $query){
        return $query->orderBy($column, "DESC");
    }

}