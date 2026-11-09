<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CheckinLog;

class DispatcherDashboard extends Component
{
    public $selectedLog = null; // Для модального окна просмотра фото

    public function showDetails($logId)
    {
        $this->selectedLog = CheckinLog::with('photos', 'material')->find($logId);
    }

    public function closeDetails()
    {
        $this->selectedLog = null;
    }

    #[\Livewire\Attributes\Layout('welcome')]
    public function render()
    {
        return view('livewire.dispatcher-dashboard', [
            'logs' => CheckinLog::with(['material', 'photos'])
                ->orderBy('checked_in_at', 'desc')
                ->paginate(20)
        ]);
    }
}
