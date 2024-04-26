@props([
	'name',
	'label',
])
<div class="flex">
	<label for="{{ $name }}" class="flex w-28">
		<div class="text-sky-600 font-semibold dark:text-blue-300">${{ $label }}</div>
		<div class="text-slate-600 dark:text-slate-400">=</div>
		<div class="text-green-800 dark:text-slate-400">&quot;</div>
	</label>
	<input
		id="{{ $name }}"
		class="font-mono font-semibold text-green-800 bg-slate-50 border-b border-slate-200 dark:text-slate-400 dark:bg-slate-700 dark:border-slate-500"
		required
	/>
	<div class="text-green-800 dark:text-slate-400">&quot;</div>
	<div class="text-slate-400">;</div>
</div>
