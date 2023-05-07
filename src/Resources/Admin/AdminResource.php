<?php


namespace Admin\Http\Resources\Admin;


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
            'head_img'  => $this->head_img,
            'role_name' => $this->role->name,
            'status'    => $this->status
        ];
    }
}