<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PollScreenshot extends Component
{
    public $stream_id;
    public $input_url;

    public function render()
    {
        return view('components.poll-screenshot');
    }
}
