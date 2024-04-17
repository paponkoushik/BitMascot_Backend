<?php

namespace App\Filters\User;

use App\Filters\BaseFilter;

class UserFilter extends BaseFilter
{
    public function search(string $str = '')
    {
        if (empty($str)) {
            return true;
        }

        return $this->builder
            ->where('first_name', 'like', '%' . $str . '%')
            ->where('last_name', 'like', '%' . $str . '%')
            ->orWhere('email', 'like', '%' . $str . '%');
    }
}
