<div class="mb-4 max-h-full h-full flex flex-col">
    <div class="flex justify-between items-center mb-1">
        <h2 class="text-md font-semibold">{{ $title }}</h2>

        @if ($todos->count() && isset($deleteAction))
            <button
                @click.prevent="
                    if (confirm('Smazat všechny {{ strtolower($title) }}?')) {
                        $wire.call('{{ $deleteAction }}')
                    }
                "
                class="text-xs text-gray-300 hover:text-red-500 cursor-pointer"
            >
                <i class="fa-solid fa-trash"></i> Smazat všechny
            </button>
        @endif
    </div>

    <div class="overflow-y-auto grow scroll-container pr-1 pl-1">
        <ul>
            @forelse($todos as $todo)
                @livewire('todo-status-toggle', ['todoId' => $todo->id], key($todo->id))
            @empty
                <li class="text-sm text-gray-300">{{ $emptyText }}</li>
            @endforelse
        </ul>
    </div>
</div>
