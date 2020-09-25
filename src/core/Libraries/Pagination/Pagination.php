<?php

namespace AnexusPHP\Core\Libraries\Pagination;

class Pagination
{
    private $total;
    private $perPage;
    private $url;
    private $page;
    private $rows;
    private $pageVar;

    public function __construct($total, $perPage, $pageVar, $page, $url)
    {
        $this->total = $total;
        $this->perPage = $perPage;
        $this->page = ($page == 0 ? 1 : $page);
        $this->url = $url;
        $this->rows = array();
        $this->pageVar = $pageVar;
    }

    public function setRows(array $rows)
    {
        $this->rows = $rows;
        return $this;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getOffset()
    {
        if (ceil($this->total / $this->perPage) > 1) {
            return (int) $this->perPage * ($this->page - 1);
        }
        return 0;
    }

    public function getTotal()
    {
        return (int) $this->total;
    }

    public function getHtml()
    {
        $data['pagination'] = array();
        $data['totalPages'] = ceil($this->total / $this->perPage);
        $data['page'] = $this->page;
        $data['url'] = preg_match("/\?/", $this->url) ? $this->url . '&' : $this->url . '?';
        $data['pageVar'] = $this->pageVar;
        return (new Engine(dirname(__DIR__) . DS . 'Pagination' . DS . 'Views', 'phtml'))->render('Pagination', $data);
    }
}
