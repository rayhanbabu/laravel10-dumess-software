<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;

class MemberImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Member([
            'hall_id'=>$row[0],
            'name'=>$row[1],
            'phone'=>$row[2],
            'card'=>$row[3],
            'registration'=>$row[4],
            'email'=>$row[5],
            'email2'=>$row[6],
            'password'=>$row[7], 
            'security_money'=>$row[8], 
            'session'=>$row[9], 
            'email_verify'=>1,
            'member_status'=>1,
            'status'=>1,
        ]);
    }
}
