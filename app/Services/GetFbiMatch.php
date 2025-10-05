<?php

namespace App\Services;

use App\Domain\Contracts\FbiCasesContract;

class GetFbiMatch
{
     public function get(string $query): ?array
     {
         $match = $query ? app(FbiCasesContract::class)->findCase($query) : null;

         if (!$match) return null;

         return [
             'uid'=> $match->uid,
             'title'=>$match->title,
             'url'=>$match->url
         ];
     }
}
