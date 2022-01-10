<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'movie_id' => $this->movie_id,
            'content' => $this->content,
            'rating' => $this->rating,
            'movie_title' => $this->movie->title,
            'movie_director' => $this->movie->director,
            'movie_synopsys' => $this->movie->synopsys,
            'movie_year' => $this->movie->year,
            'friend' => Auth::user()->isFriendWith($this->user)
        ];
    }
}
