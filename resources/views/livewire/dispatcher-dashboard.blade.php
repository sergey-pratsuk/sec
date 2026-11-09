<div class="w-full max-w-6xl mx-auto p-6 bg-white rounded-xl shadow-md my-4 font-sans">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Журнал въезда спецтехники и материалов</h2>
        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Панель диспетчера</span>
    </div>

    <!-- Таблица логов -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4">Дата / Время</th>
                    <th class="px-6 py-4">Госномер</th>
                    <th class="px-6 py-4">Материал</th>
                    <th class="px-6 py-4">Объем / Вес</th>
                    <th class="px-6 py-4 text-center">Фотофиксация</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($logs as $log)
                    <tr wire:click="showDetails({{ $log->id }})" class="hover:bg-blue-50/50 cursor-pointer transition">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $log->checked_in_at->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-gray-100 border border-gray-300 text-gray-800 font-mono font-bold rounded">
                                {{ $log->license_plate }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-medium">{{ $log->material->name }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            {{ $log->volume }} {{ $log->material->unit }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs px-2.5 py-1 bg-green-50 text-green-700 rounded border border-green-200 font-medium">
                                📸 {{ $log->photos->count() }} шт.
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">Записей в журнале пока нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Модальное окно просмотра фотографий заезда -->
    @if($selectedLog)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full p-6 relative max-h-[90vh] overflow-y-auto">
                
                <!-- Хедер модалки -->
                <div class="flex justify-between items-start border-b border-gray-100 pb-3 mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Детали заезда транспорта {{ $selectedLog->license_plate }}</h3>
                        <p class="text-xs text-gray-500">Зафиксировано: {{ $selectedLog->checked_in_at->format('d.m.Y в H:i:s') }}</p>
                    </div>
                    <button wire:click="closeDetails" class="text-gray-400 hover:text-gray-600 font-bold text-xl px-2">&times;</button>
                </div>

                <!-- Информация о грузе -->
                <div class="grid grid-cols-2 gap-4 mb-6 bg-gray-50 p-3 rounded-lg border border-gray-200">
                    <div><span class="text-xs text-gray-500 block">Груз:</span> <strong class="text-sm text-gray-800">{{ $selectedLog->material->name }}</strong></div>
                    <div><span class="text-xs text-gray-500 block">Объем / Вес:</span> <strong class="text-sm text-gray-800">{{ $selectedLog->volume }} {{ $selectedLog->material->unit }}</strong></div>
                </div>

                <!-- Сетка фотографий (наши 3 фотографии из роута) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($selectedLog->photos as $photo)
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50 shadow-sm">
                            <span class="block text-xs font-semibold uppercase bg-gray-100 px-3 py-2 text-gray-600 text-center border-b border-gray-200">
                                @if($photo->type === 'vehicle') 🚚 Транспорт и номер
                                @elseif($photo->type === 'cargo') 📦 Содержимое груза
                                @elseif($photo->type === 'invoice') 📄 ТТН / Накладная @endif
                            </span>
                            <a href="{{ route('photos.show', $photo->id) }}" target="_blank" class="block aspect-[4/3] relative overflow-hidden group">
                                <img src="{{ route('photos.show', $photo->id) }}" alt="Фото" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-medium">Открыть оригинал</div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
