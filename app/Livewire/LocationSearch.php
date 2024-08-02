<?php

namespace App\Livewire;

use App\Models\Location;
use Livewire\Component;

class LocationSearch extends Component
{

    public $event = null;
    public $search = "";
    public $selectedLocation = null;
    public $locations = [];
    public $open = false;


    public function mount($event = null)
    {
        //todo add limitation on published only?
        $this->locations = Location::get();
        $this->event = $event;

        if ($this->event) {
            $this->selectedLocation = $this->event->location;
        }
    }


    public function updatedSearch()
    {
        $this->locations = Location::where("name", "like", "%" . $this->search . "%")->get();
    }

    public function selectLocation(int $locationId)
    {
        $this->selectedLocation = Location::find($locationId);
        $this->search = "";
        $this->locations = Location::get();
        $this->open = false;
    }

    public function clearLocation()
    {
        $this->selectedLocation = null;
        $this->locations = Location::get();
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
        return view('livewire.location-search');
    }
}
