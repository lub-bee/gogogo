<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Topic;
use Livewire\Component;

class TopicSearch extends Component
{
    public $event = null;
    public $search = "";
    public $selectedTopic = null;
    public $topics = [];
    public $open = false;


    public function mount($event = null)
    {
        //todo add limitation on published only?
        $this->topics = Topic::get();
        $this->event = $event;

        if ($this->event) {
            $this->selectedTopic = $this->event->topic;
        }
    }


    public function updatedSearch()
    {
        $this->topics = Topic::where("name", "like", "%" . $this->search . "%")->get();
        // dd('update?', $this->search, $this->topics);
    }


    public function selectTopic(int $topicId)
    {
        $this->selectedTopic = Topic::find($topicId);
        $this->search = "";
        $this->topics = Topic::get();
        $this->open = false;
    }

    public function clearTopic()
    {
        $this->selectedTopic = null;
        $this->topics = Topic::get();
    }

    public function toggleOpen(bool $force = null){
        if($force !== null){
            $this->open = $force;
        }else{
            $this->open = !$this->open;
        }
    }

    public function render()
    {
        return view('livewire.topic-search');
    }
}
