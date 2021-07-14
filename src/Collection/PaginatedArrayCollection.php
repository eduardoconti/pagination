<?php
declare(strict_types=1);

namespace DoctrinePagination\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Shared\Utils\DTO\ResponseParams;

class PaginatedArrayCollection
{
    /** 
     * @var int
     */
    private $total;
    /** 
     * @var int
     */
    private $lastpage;
    /** 
     * @var int
     */
    private $perpage;
    /** 
     * @var int
     */
    private $currentpage;
    /** 
     * @var string
     */
    private $nextpageurl;
    /** 
     * @var string
     */
    private $prevpageurl;
    /** 
     * @var array
     */
    private $criteria = [];
    /** 
     * @var array
     */
    private $orderBy = [];
    /** 
     * @var ArrayCollection
     */
    public $data = null;

    public function __construct(
        array $elements = [],
        int $currentpage = null,
        int $perpage = 10,
        int $total = null,
        ?array $criteria = [],
        ?array $orderBy = []
    ) {

        $this->data = new ArrayCollection($elements);

        $this->total = $total;
        $this->perpage = $perpage;
        $this->currentpage = $currentpage;
        $this->criteria = $criteria;
        $this->orderBy = $orderBy;

        $this->lastpage = $this->getLastPage();
        $this->nextpageurl = $this->getNextPageUrl();
        $this->prevpageurl = $this->getPrevPageUrl();

        $this->criteria = null;
        $this->orderBy = null;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function getLastPage(): ?int
    {
        if (!$this->getPerPage()) {
            throw new \LogicException('ResultsPerPage was not setted');
        }

        if (!$this->getTotal()) {
            return 0;
        }

        $this->lastpage = ceil($this->getTotal() / $this->getPerPage());

        return intval($this->lastpage);
    }

    public function getPerPage(): ?int
    {
        return $this->perpage;
    }

    public function getCurrentPage(): ?int
    {
        return $this->currentpage;
    }

    public function getNextPageUrl(): ?string
    {
        $this->nextpageurl = $this->mountUrl($this->getCurrentPage() + 1);

        return $this->nextpageurl;
    }

    public function getPrevPageUrl(): ?string
    {
        $this->prevpageurl = $this->mountUrl($this->getCurrentPage() - 1);

        return $this->prevpageurl;
    }

    public function getCriteria(): ?array
    {
        return $this->criteria;
    }

    public function setCriteria(?array $criteria): PaginatedArrayCollection
    {
        $this->criteria = $criteria;
        return $this;
    }

    public function getOrderBy(): ?array
    {
        return $this->orderBy;
    }

    public function setOrderBy(?array $orderBy): PaginatedArrayCollection
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    private function mountUrl(int $page): string
    {
        $order = '';
        $criteria = '';

        if ($page < 1) {
            $page = 1;
        }

        if ($page > $this->getTotal()) {
            $page = $this->getTotal();
        }

        if (!empty($this->criteria)) {
            foreach ($this->criteria as $key => $data) {
                // @TODO se precisar enviar idcompany como atributo será necessário remover
                if ($key === "idcompany") {
                    continue;
                }
                $criteria .= sprintf("&search=%s&search_field=%s", $data[1] ?? $data, $key);
            }
        }

        if (!empty($this->orderBy)) {
            foreach ($this->orderBy as $key => $data) {
                // @TODO se precisar enviar idcompany como atributo será necessário remover
                if ($key === "idcompany") {
                    continue;
                }
                $order .= sprintf("&sort=%s&order=%s", $key, $data);
            }
        }

        return sprintf("?page=%s&perpage=%s%s%s", $page, $this->getPerPage(), $order, $criteria);
    }

    /**
     * Get the value of data
     *
     * @return  ArrayCollection
     */ 
    public function getData()
    {
        return $this->data;
    }
    /** 
     * @return ResponseParams
     */
    public function getParams(){

        $this->data = null;
        return $this;

    }
}
