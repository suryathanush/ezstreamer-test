<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PollStream extends Component
{

    public $stream_id;
    public $statsToGet;

    public function render()
    {
        return view('components.poll-stream');
    }
}
