<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WalletsRepository;

use App\Wallets;
use App\Validators\WalletsValidator;

/**
 * Class WalletsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WalletsRepositoryEloquent extends BaseRepository implements WalletsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Wallets::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
