<div class="flex items-center justify-between p-2 bg-white mb-1 last:mb-0 rounded-md">
    <div class="flex items-center gap-3">
        @php
            $baseClasses = 'focus:outline-none w-[20px] h-[20px] rounded-full border-2 flex items-center justify-center cursor-pointer transition text-white min-w-[20px]';
        @endphp

        <button
            wire:click="toggle"
            class="{{ $baseClasses }}
            {{ $todo->done ? 'bg-primary border-primary hover:bg-white hover:border-outline' : 'border-outline hover:bg-primary hover:border-primary' }}"
        >
            <i class="fa-solid fa-check text-xs"></i>
        </button>


        <span class="pr-4 {{ $todo->done ? 'text-gray-500 line-through' : 'text-black' }}">
            {{ $todo->title }}
        </span>
    </div>

    <div class="flex gap-3">
        <div wire:poll.20s>
            @if ($todo->done)
                <span class="text-[12px] text-gray-300 whitespace-nowrap"><i class="fa-solid fa-check"></i> {{ $todo->completed_at->diffForHumans(null, short: true) }}</span>
            @else
                <span class="text-[12px] text-gray-300 whitespace-nowrap">{{ $todo->created_at->diffForHumans(null, short: true) }}</span>
            @endif
        </div>


        <a href="{{ route('todos.edit', $todo) }}" class="text-gray-300 hover:text-primary"><i class="fa-solid fa-pen-to-square"></i></a>

        <form method="POST" action="{{ route('todos.destroy', $todo) }}" onsubmit="return confirm('Smazat úkol?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-gray-300 hover:text-red-500 cursor-pointer"><i class="fa-solid fa-trash"></i></button>
        </form>
    </div>
</div>
