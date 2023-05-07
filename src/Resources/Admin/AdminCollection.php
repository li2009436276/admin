<?php


namespace Admin\Resources\Admin;


use Admin\Resources\BaseCollection;

class AdminCollection extends BaseCollection
{
    public function toArray($request)
    {
        return AdminResource::collection($this);
    }
}