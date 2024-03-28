<?php 
namespace App\Utils;
use Doctrine\ORM\QueryBuilder;
interface TreatmentStrategy {
    public function execute(string $column, QueryBuilder $query);

    //la key représente le paramètre dans l'url qui va permettre de savoir qu'elle action de la classe contexte (column)
    //on appel Ex 1 : "id=sort:asc" Ex 2 : "id=lowerOrEqual:5"
    public function getKey();
}