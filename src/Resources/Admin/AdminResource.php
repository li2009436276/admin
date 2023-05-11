<?php


namespace Admin\Resources\Admin;


use Admin\Resources\BaseResource;

class AdminResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'role_id'   => $this->role_id,
            'account'   => $this->account,
            'nickname'  => $this->nickname,
            'phone'     => $this->phone,
            'email'     => $this->email,
            'avatar'  => $this->avatar,
            'role_name' => $this->role->name,
            'status'    => $this->status
        ];
    }
}