<?php

namespace App\Repositories\Company;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository implements CompanyRepositoryInterface
{
    private const DEFAULT_PAGE  = 1;
    private const DEFAULT_LIMIT = 10;

    /**
     * @param int|null $page
     * @param int|null $limit
     * @param array    $filters
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function loadAll(?int $page, ?int $limit, array $filters = []): LengthAwarePaginator
    {
        $limit = $limit ?? self::DEFAULT_LIMIT;
        $page = $page ?? self::DEFAULT_PAGE;
        $offset = ($page * $limit) - $limit;

        $query = Company::query();
        $query = $this->applyFilters($query, $filters);

        $total = $query->count();

        $result = $query
            ->limit($limit)
            ->offset($offset)
            ->orderBy('created_at', 'desc')
            ->get();

        return new LengthAwarePaginator(CompanyResource::collection($result), $total, $limit, $page);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                 $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (array_key_exists('title', $filters) && $filters['title'] !== null) {
            $title = $filters['title'];
            $query->whereRaw("title LIKE '%{$title}%'");
        }

        if (array_key_exists('user_id', $filters) && $filters['user_id'] !== null) {
            $userId = $filters['user_id'];
            $query->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            });
        }

        return $query;
    }

    /**
     * @param array            $params
     *
     * @return \App\Models\Company
     */
    public function create(array $params): Company
    {
        $company = new Company();
        $company->title = $params['title'];
        $company->phone = $params['phone'];
        $company->description = $params['description'];
        $company->save();

        return $company;
    }
}
