<?php

namespace App\Repositories\Company;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;

interface CompanyRepositoryInterface
{
    /**
     * @param int|null $page
     * @param int|null $limit
     * @param array    $filters
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function loadAll(?int $page, ?int $limit, array $filters = []): LengthAwarePaginator;

    /**
     * @param array            $params
     * @return \App\Models\Company
     */
    public function create(array $params): Company;
}
