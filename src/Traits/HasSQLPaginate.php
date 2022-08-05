<?php

/**
 * @author M. Muflih Kholidin <mmuflic@gmail.com>
 * Date: 04.07.2017
 */

namespace MMuflih\CleanApi\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasSQLPaginate
{
    protected $request;
    protected $sqlData;
    protected $sqlCount;

    /** @return LengthAwarePaginator */
    public function paginate()
    {
        $pageNo = 1;
        $pageSize = 1000;
        if ($this->request && $this->request->has('page')) {
            $pageNo = $this->request->get("page");
        }
        if ($this->request && $this->request->has('size')) {
            $pageSize = $this->request->get("size");
        }
        $offset = ($pageNo - 1) * $pageSize;
        $items = DB::select($this->sqlData . " LIMIT $pageSize OFFSET $offset");
        $counts = DB::select($this->sqlCount);
        $count = 0;
        foreach ($counts as $c) {
            $count = $c->count;
        }
        return new PagedList($items, $count, $pageNo, $pageSize);
    }
}
