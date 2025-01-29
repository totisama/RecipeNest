<?php

namespace App\Livewire;

use Livewire\Component;

class ToggleVideo extends Component
{
    public $showVideo = false;

    public $videoUrl;

    public function mount($videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }

    public function toggleVideo()
    {
        $this->showVideo = ! $this->showVideo;
    }

    public function render()
    {
        return view('livewire.toggle-video');
    }
}
