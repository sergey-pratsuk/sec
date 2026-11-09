<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-lg my-4 font-sans">
    <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Регистрация въезда ТС</h2>

    @if (session()->has('message'))
        <div class="mb-5 p-4 bg-green-100 text-green-700 rounded-lg font-medium text-center shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-5">
        <!-- Госномер -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Госномер транспорта</label>
            <input type="text" wire:model.defer="license_plate" placeholder="А001АА77" 
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none uppercase text-lg tracking-wider">
            @error('license_plate') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Выбор материала -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Тип материала / Груза</label>
            <select wire:model="material_id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white text-base">
                <option value="">-- Выберите материал --</option>
                @foreach($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->unit }})</option>
                @endforeach
            </select>
            @error('material_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Количество / Объем -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Объем / Вес / Кол-во</label>
            <input type="number" step="0.01" wire:model.defer="volume" placeholder="0.00"
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none text-lg">
            @error('volume') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
        </div>

        <!-- Блок фотофиксации -->
        <div class="space-y-4 pt-3 border-t border-gray-100">
            <span class="block text-sm font-semibold text-gray-800">Обязательные фотографии:</span>
            
            <!-- Фото Машины -->
            <div class="bg-gray-50 p-3 rounded-lg border border-dashed border-gray-300 flex flex-col items-center justify-center text-center">
                <label class="w-full cursor-pointer">
                    <span class="block text-sm font-medium text-gray-700 mb-1">📸 Фото 1: Общий вид ТС и номер</span>
                    <input type="file" wire:model="photo_vehicle" accept="image/*" capture="environment" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </label>
                <div wire:loading wire:target="photo_vehicle" class="text-xs text-blue-500 mt-1">Загрузка изображения...</div>
                @if ($photo_vehicle) <div class="text-xs text-green-600 font-medium mt-1">✅ Снимок добавлен</div> @endif
                @error('photo_vehicle') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Фото Кузова -->
            <div class="bg-gray-50 p-3 rounded-lg border border-dashed border-gray-300 flex flex-col items-center justify-center text-center">
                <label class="w-full cursor-pointer">
                    <span class="block text-sm font-medium text-gray-700 mb-1">📸 Фото 2: Содержимое кузова / груз</span>
                    <input type="file" wire:model="photo_cargo" accept="image/*" capture="environment" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </label>
                <div wire:loading wire:target="photo_cargo" class="text-xs text-blue-500 mt-1">Загрузка изображения...</div>
                @if ($photo_cargo) <div class="text-xs text-green-600 font-medium mt-1">✅ Снимок добавлен</div> @endif
                @error('photo_cargo') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Фото Документов -->
            <div class="bg-gray-50 p-3 rounded-lg border border-dashed border-gray-300 flex flex-col items-center justify-center text-center">
                <label class="w-full cursor-pointer">
                    <span class="block text-sm font-medium text-gray-700 mb-1">📸 Фото 3: ТТН / Накладная</span>
                    <input type="file" wire:model="photo_invoice" accept="image/*" capture="environment" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </label>
                <div wire:loading wire:target="photo_invoice" class="text-xs text-blue-500 mt-1">Загрузка изображения...</div>
                @if ($photo_invoice) <div class="text-xs text-green-600 font-medium mt-1">✅ Снимок добавлен</div> @endif
                @error('photo_invoice') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Кнопка сохранения -->
        <button type="submit" wire:loading.attr="disabled" 
                class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md active:bg-blue-800 transition disabled:opacity-50 text-lg mt-4">
            <span wire:loading.remove wire:target="save">Зафиксировать въезд</span>
            <span wire:loading wire:target="save">Сохранение в журнал...</span>
        </button>
    </form>
</div>
