<form method="POST" action="{{ $action }}">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <input
        type="text"
        name="title"
        placeholder="Název úkolu"
        value="{{ old('title', $todo->title ?? '') }}"
        class="w-full"
        required
    >
    @error('title') <div class="bg-red-500 text-xs px-4">{{ $message }}</div> @enderror

    <div class="flex items-center mt-4 gap-2">
        <a href="{{ route('todos.index') }}" class="button"><i class="fa-solid fa-arrow-left"></i> Zpět</a>
        <button type="submit" class="button bg-green-700 hover:bg-green-600">Uložit</button>
    </div>
</form>
