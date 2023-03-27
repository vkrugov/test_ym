<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\IndexRequest;
use App\Http\Requests\Company\StoreRequest;
use App\Http\Resources\CompanyResource;
use App\Repositories\Company\CompanyRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserCompanyController extends Controller
{
    /**
     * @var \App\Repositories\Company\CompanyRepositoryInterface
     */
    private CompanyRepositoryInterface $companyRepository;

    /**
     * @param \App\Repositories\Company\CompanyRepositoryInterface $companyRepository
     */
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param \App\Http\Requests\Company\IndexRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $page = $request->get('page');
        $limit = $request->get('limit');
        $filters = $request->get('filters', []);
        $filters['user_id'] = Auth::id();
        $companies = $this->companyRepository->loadAll($page, $limit, $filters);

        return response()->json($companies);
    }

    /**
     * @param \App\Http\Requests\Company\StoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $params = $request->only([
            'title', 'description', 'phone'
        ]);

        $company = $this->companyRepository->create($params);
        $company->users()->attach(Auth::user());

        return response()->json([
            'company' => new CompanyResource($company),
        ], Response::HTTP_CREATED);
    }
}
