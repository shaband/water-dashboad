<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class NewPromocode
{
    use SerializesModels;

    public $promocode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($promocode)
    {
        $this->promocode = $promocode;
    }
}
