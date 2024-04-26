@props([
	'name',
	'label',
])
<div class="flex flex-col md:flex-row">
	<label for="{{ $name }}" class="flex md:w-28">
		<div class="text-sky-600 font-semibold dark:text-blue-300">${{ $label }}</div>
		<div class="text-slate-600 dark:text-slate-400">=</div>
		<div class="text-green-800 dark:text-slate-400 hidden md:block">&quot;</div>
	</label>
	<input
		id="{{ $name }}"
		name="{{ $name }}"
		class="font-mono font-semibold text-green-800 bg-slate-50 border-b border-slate-200 dark:text-slate-400 dark:bg-slate-700 dark:border-slate-500"
		required
	/>
	<div class="text-green-800 dark:text-slate-400 hidden md:block">&quot;</div>
	<div class="text-slate-400 hidden md:block">;</div>
</div>

@error($name)
<div class="text-red-500">
	// {{ $message }}
</div>
@enderror
