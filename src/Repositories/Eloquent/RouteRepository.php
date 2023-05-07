<?php


namespace Admin\Repositories\Eloquent;


use Admin\Models\Route;
use Admin\Repositories\Contracts\RouteInterface;
use MakeRep\Repository;
use DB;

class RouteRepository extends Repository implements RouteInterface
{

    function model()
    {
        return Route::class;
    }
}