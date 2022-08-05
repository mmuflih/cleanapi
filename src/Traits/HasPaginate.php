<?php

/**
 * @author M. Muflih Kholidin <mmuflic@gmail.com>
 * Date: 04.07.2017
 */

namespace MMuflih\CleanApi\Traits;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasPaginate
{
    protected $request;
    protected $data;

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

        if (!is_numeric($pageNo)) {
            $pageNo = 1;
        }
        if (!is_numeric($pageSize)) {
            $pageSize = 1000;
        }
        Paginator::currentPageResolver(function () use ($pageNo) {
            return $pageNo;
        });
        return $this->data
            ->paginate($pageSize);
    }
}
