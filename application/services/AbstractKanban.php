<?php

namespace app\services;

abstract class AbstractKanban
{
    protected $limit;

    protected $default_sort;

    protected $default_sort_direction;

    protected $status;

    protected $page = 1;

    protected $refreshAtTotal;

    protected $ci;

    protected $q;

    protected $queryTapCallback;

    private $sort_by_column;

    private $sort_direction;
    
	protected $category; // Category filter

    public function __construct($status, $category)
    {
    
        $this->category = $category; // Set the category

        $this->status         = $status;
        $this->ci             = &get_instance();
        $this->limit          = $this->limit();
        $this->sort_by_column = $this->defaultSortColumn();
        $this->sort_direction = $this->defaultSortDirection();
    }

    public function tapQuery(callable $callback)
    {
        $this->queryTapCallback = $callback;

        return $this;
    }

    public function totalPages()
    {
        return ceil(
            $this->countAll() / $this->limit
        );
    }

    public function get() // Pass the selected category
    {
        // Check if the selected category is set and valid
        if (!empty($this->category)) {
            // Add a where condition to filter by the 'cat' column
            $this->ci->db->where('category',  $this->category);
        }
    
        // Handle pagination logic
        if ($this->refreshAtTotal && $this->refreshAtTotal !== '0') {
            // Update the current page based on the total number provided to load
            $this->page(ceil(($this->refreshAtTotal) / $this->limit()));
            $allPagesTotal = $this->page * $this->limit();
    
            if ($allPagesTotal > $this->refreshAtTotal) {
                $this->ci->db->limit($this->refreshAtTotal);
            } else {
                $this->ci->db->limit($allPagesTotal);
            }
        } else {
            if ($this->page > 1) {
                $position = (($this->page - 1) * $this->limit());
                $this->ci->db->limit($this->limit(), $position);
            } else {
                $this->ci->db->limit($this->limit());
            }
        }
    
        // Initiate the query
        $this->initiateQuery();
    
        // Apply search filter if available
        if ($this->q) {
            $this->applySearchQuery($this->q);
        }
    
        // Apply sorting if needed
        $this->applySortQuery();
    
        // Call additional hooks for the query if needed
        $this->tapQueryIfNeeded();
        $this->applyCategoryFilter($this->q); // Ensure this is called before executing the query

        // Execute and return the results
        return $this->ci->db->get()->result_array();
    }
    
    public function countAll()
    {
        $this->initiateQuery();

        if ($this->q) {
            $this->applySearchQuery($this->q);
        }

        $this->tapQueryIfNeeded();

        return $this->ci->db->count_all_results();
    }

    public function refresh($atTotal)
    {
        $this->refreshAtTotal = $atTotal;

        return $this;
    }

    public function page($page)
    {
        $this->page = $page;

        return $this;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function sortBy($column, $direction)
    {
        if ($column && $direction) {
            $this->sort_by_column = $column;
            $this->sort_direction = $direction;
        }

        return $this;
    }

    public function search($q)
    {
        $this->q = $q;
    // Apply the category filter if the category is set
    if (!empty($this->category)) {
        $this->ci->db->where(db_prefix() . 'leads.category', $this->category);
    }

        return $this;
    }

    protected function applySortQuery()
    {
        if ($this->sort_by_column && $this->sort_direction) {
            $nullsLast  = $this->qualifyColumn($this->sort_by_column) . ' IS NULL ' . $this->sort_direction;
            $actualSort = $this->qualifyColumn($this->sort_by_column) . ' ' . $this->sort_direction;

            $this->ci->db->order_by(
                $nullsLast . ', ' . $actualSort,
                '',
                false
            );
        }
    }

    protected function tapQueryIfNeeded()
    {
        if ($this->queryTapCallback) {
            call_user_func_array($this->queryTapCallback, [$this->status, $this->ci]);
        }
    }

    protected function qualifyColumn($column)
    {
        return db_prefix() . $this->table() . '.' . $column;
    }

    public static function updateOrder($data, $column, $table, $status, $statusColumnName = 'status', $primaryKey = 'id')
    {
        $ci = &get_instance();

        $batch    = [];
        $allOrder = [];
        $allIds   = [];

        foreach ($data as $order) {
            $allIds[]   = $order[0];
            $allOrder[] = $order[1];
            $batch[]    = [
                $primaryKey => $order[0],
                $column     => $order[1],
            ];
        }

        $max = max($allOrder);

        $ci->db->query('UPDATE ' . db_prefix() . $table . ' SET ' . $column . '=' . $max . '+' . $column . ' WHERE ' . $primaryKey . ' NOT IN (' . implode(',', $allIds) . ') AND ' . $statusColumnName . '=' . $status);

        $ci->db->update_batch($table, $batch, $primaryKey);
    }

    abstract protected function table();

    abstract protected function initiateQuery();

    abstract protected function applySearchQuery($q);

    abstract public function defaultSortDirection();

    abstract public function defaultSortColumn();

    abstract public function limit();
}
