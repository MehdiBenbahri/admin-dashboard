<?php 
namespace App\Utils;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class Column {
    private string $id;
    private string $label;
    private ?string $class;
    private bool $activated = true;
    private $sort;

    private Request $request;

    public function __construct($id, $label, $class, $activated, $sort, Request $request) {
        $this->id = $id;
        $this->label = $label;
        $this->class = $class;
        $this->activated = $activated;
        $this->sort = $sort;
        $this->request = $request;
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

    public function executeTreatment (QueryBuilder $q, $alias) {
        //si dans l'url, il y'a un paramètre de filtrage / trie
        if ($this->request->query->get($this->id)) {
            //alors on cherche qu'elle filtrage / trie appliquer
            $s = $this->findSortByRequest($this->request->query->get($this->id));
            // si on trouve une stratégie qui correspond à ce qu'on a en paramètre, on l'applique
            if ($s) {
                return $s->getStrategy()->execute($alias . "." . $this->id, $q);
            }
        }
        return $q;
    }

    private function findSortByRequest(string $key) {
        foreach ($this->sort as $s) {
            if ($s->getStrategy()->getKey() === $key) {
                return $s;
            }
        }
    }

}