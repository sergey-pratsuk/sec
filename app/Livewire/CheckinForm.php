<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Material;
use App\Models\CheckinLog;
use Illuminate\Support\Facades\DB;

class CheckinForm extends Component
{
    use WithFileUploads;

    // поля формы
    public $license_plate = '';
    public $material_id = '';
    public $volume = '';
    
    // файлы фото
    public $photo_vehicle;
    public $photo_cargo;
    public $photo_invoice;

    // валидация
    protected $rules = [
        'license_plate' => 'required|string|max:20|min:3',
        'material_id'   => 'required|exists:materials,id',
        'volume'        => 'required|numeric|min:0.01|max:999999',
        'photo_vehicle' => 'required|image|max:10240', // 10 мб
        'photo_cargo'   => 'required|image|max:10240',
        'photo_invoice' => 'required|image|max:10240',
    ];

    protected $messages = [
        'required' => 'Это поле обязательно.',
        'image' => 'Файл должен быть изображением.',
        'max' => 'Файл слишком большой (макс. 10 МБ).',
        'min' => 'Значение слишком маленькое.',
    ];

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // ГРНЗ
            $cleanPlate = strtoupper(str_replace(' ', '', $this->license_plate));

            $log = CheckinLog::create([
                'license_plate' => $cleanPlate,
                'material_id'   => $this->material_id,
                'volume'        => $this->volume,
                'user_id'       => 1, // Подставляем ID созданного сидером Ивана
                'checked_in_at' => now(),
            ]);

            // в storage/app/private/checkins/ГГГГ/ММ/ДД/
            $photos = [
                'vehicle' => $this->photo_vehicle,
                'cargo' => $this->photo_cargo,
                'invoice' => $this->photo_invoice,
            ];

            foreach ($photos as $type => $file) {
                $path = $file->store('checkins/' . now()->format('Y/m/d'), 'local');

                $log->photos()->create([
                    'type' => $type,
                    'file_path' => $path,
                ]);
            }
        });

        // успешно
        session()->flash('message', 'Транспорт успешно зарегистрирован в журнале!');
        
        // рисет формы
        $this->reset(['license_plate', 'material_id', 'volume', 'photo_vehicle', 'photo_cargo', 'photo_invoice']);
    }

    #[Layout('welcome')]
    public function render()
    {
        return view('livewire.checkin-form', [
            'materials' => Material::orderBy('name')->get()
        ]);
    }
}
