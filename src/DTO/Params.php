<?php

declare(strict_types=1);

namespace DoctrinePagination\DTO;

use Doctrine\ORM\AbstractQuery;

class Params
{
    /** 
     * @var int
     */
    private $page = 1;
    /** 
     * @var int
     */
    private $per_page = 20;
    /** 
     * @var array
     */
    private $criteria = [];
    /** 
     * @var string
     */
    private $sort = '';
    /** 
     * @var string
     */
    private  $order = 'ASC';
    /** 
     * @var string
     */
    private  $search = '';
    /** 
     * @var string
     */
    private $search_field = '';
    /** 
     * @var int
     */
    private  $hydrateMode = AbstractQuery::HYDRATE_OBJECT;

    public function __construct(?array $dados = [])
    {
        if (empty($dados))
            return;

        foreach ($dados as $key => $dado) {
            $key = trim($key);
            $dado = trim($dado);

            if (!isset($this->$key) || $dado === "undefined") {
                continue;
            }

            $this->$key = $this->treatData($key, $dado);
        }
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): Params
    {
        $this->page = $page;
        return $this;
    }

    public function getPerPage(): ?int
    {
        return $this->per_page;
    }

    public function setPerPage(?int $per_page): Params
    {
        $this->per_page = $per_page;
        return $this;
    }

    public function getCriteria(): ?array
    {
        if (empty($this->getSearch()) || empty($this->getSearchField())) {
            return $this->criteria;
        }

        return array_merge($this->criteria, [
            $this->getSearchField() => ["ILIKE", $this->getSearch()]
        ]);
    }

    public function setCriteria(?array $criteria): Params
    {
        $this->criteria = $criteria;
        return $this;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function setSort(?string $sort): Params
    {
        $this->sort = $sort;
        return $this;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function setOrder(?string $order): Params
    {
        $this->order = $order;
        return $this;
    }

    public function getOrderBy(): array
    {
        if ($this->getSort() && $this->getOrder()) {
            return [$this->getSort() => $this->getOrder()];
        }

        return [];
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): Params
    {
        $this->search = $search;
        return $this;
    }

    public function getSearchField(): ?string
    {
        return $this->search_field;
    }

    public function setSearchField(?string $search_field): Params
    {
        $this->search_field = $search_field;
        return $this;
    }

    public function getHydrateMode(): ?int
    {
        return $this->hydrateMode;
    }

    public function setHydrateMode(?int $hydrateMode): Params
    {
        $this->hydrateMode = $hydrateMode;
        return $this;
    }

    private function treatData($key, $dado)
    {
        $typeDado = gettype($this->$key);

        switch ($typeDado) {
            case "integer":
            case "string":
                $method = sprintf("%sval", substr($typeDado, 0, 3));

                return call_user_func($method, $dado);
            case "array":
                return is_array($dado) ? $dado : (array)$dado;
            default:
                return $dado;
        }
    }
}
