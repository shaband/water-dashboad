<?php


namespace App\Traits;


use Carbon\Carbon;

trait CanBlock
{
    public function toggleBlock(): void
    {

        if (is_null($this->blocked_at)) {
            $this->fill(['blocked_at' => Carbon::now()]);
        } else {
            $this->fill(['blocked_at' => null]);
        }
        $this->save();
    }

}
