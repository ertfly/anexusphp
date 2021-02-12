<?php

namespace AnexusPHP\Core\Libraries\Pagination;

use League\Plates\Engine;

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
    
    public function getJson()
    {
        $totalPages = ceil($this->total / $this->perPage);
        $pages = array();

        if ($totalPages > 1 && $this->page > 1) {
            $pages[] = array(
                'pg' => 1,
                'content' => '<<',
                'active' => false
            );
        }

        if ($totalPages > 1 && $this->page > 1) {
            $pages[] = array(
                'pg' => (int)($this->page - 1),
                'content' => '<',
                'active' => false
            );
        }

        if ($this->page > 1 && $totalPages > ($this->page - 3) && ($this->page - 3) > 0) {
            $pages[] = array(
                'pg' => (int)($this->page - 3),
                'content' => str_pad(($this->page - 3), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($this->page > 1 && $totalPages > ($this->page - 2) && ($this->page - 2) > 0) {
            $pages[] = array(
                'pg' => (int)($this->page - 2),
                'content' => str_pad(($this->page - 2), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($this->page > 1 && $totalPages > ($this->page - 1) && ($this->page - 1) > 0) {
            $pages[] = array(
                'pg' => (int)($this->page - 1),
                'content' => str_pad(($this->page - 1), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($totalPages > 1) {
            $pages[] = array(
                'pg' => (int)$this->page,
                'content' => str_pad($this->page, 2, '0', STR_PAD_LEFT),
                'active' => true
            );
        }

        if ($totalPages >= ($this->page + 1)) {
            $pages[] = array(
                'pg' => (int)($this->page + 1),
                'content' => str_pad(($this->page + 1), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($totalPages >= ($this->page + 2)) {
            $pages[] = array(
                'pg' => (int)($this->page + 2),
                'content' => str_pad(($this->page + 2), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($totalPages >= ($this->page + 3)) {
            $pages[] = array(
                'pg' => (int)($this->page + 3),
                'content' => str_pad(($this->page + 3), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($totalPages > 1 && $this->page < $totalPages) {
            $pages[] = array(
                'pg' => (int)($this->page + 1),
                'content' => '>',
                'active' => false
            );
        }

        if ($totalPages > 1 && $this->page < $totalPages) {
            $pages[] = array(
                'pg' => (int)$totalPages,
                'content' => '>>',
                'active' => false
            );
        }

        return $pages;
    }

    public function getJson2()
    {
        $totalPages = ceil($this->total / $this->perPage);
        $pages = array();

        if ($totalPages > 1 && $this->page > 1) {
            $pages[] = array(
                'pg' => (int)($this->page - 1),
                'content' => '<i class="fa fa-angle-left"></i>',
                'active' => false
            );
        }

        if ($this->page > 1 && $totalPages > ($this->page - 3) && ($this->page - 3) > 0) {
            $pages[] = array(
                'pg' => (int)($this->page - 3),
                'content' => (string)($this->page - 3),
                'active' => false
            );
        }

        if ($this->page > 1 && $totalPages > ($this->page - 2) && ($this->page - 2) > 0) {
            $pages[] = array(
                'pg' => (int)($this->page - 2),
                'content' => (string)($this->page - 2),
                'active' => false
            );
        }

        if ($this->page > 1 && $totalPages > ($this->page - 1) && ($this->page - 1) > 0) {
            $pages[] = array(
                'pg' => (int)($this->page - 1),
                'content' => (string)($this->page - 1),
                'active' => false
            );
        }

        if ($totalPages > 1) {
            $pages[] = array(
                'pg' => (int)$this->page,
                'content' => (string)$this->page,
                'active' => true
            );
        }

        if ($totalPages >= ($this->page + 1)) {
            $pages[] = array(
                'pg' => (int)($this->page + 1),
                'content' => (string)($this->page + 1),
                'active' => false
            );
        }

        if ($totalPages >= ($this->page + 2)) {
            $pages[] = array(
                'pg' => (int)($this->page + 2),
                'content' => (string)($this->page + 2),
                'active' => false
            );
        }

        if ($totalPages >= ($this->page + 3)) {
            $pages[] = array(
                'pg' => (int)($this->page + 3),
                'content' => (string)($this->page + 3),
                'active' => false
            );
        }

        if ($totalPages > 1 && $this->page < $totalPages) {
            $pages[] = array(
                'pg' => (int)($this->page + 1),
                'content' => '<i class="fa fa-angle-right"></i>',
                'active' => false
            );
        }

        return $pages;
    }
}
