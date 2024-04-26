<div {{ $attributes }}>
	<div class="border rounded-lg bg-slate-50 border-slate-200 dark:bg-slate-900 dark:border-slate-700 shadow-xl">
		
		{{-- Top toolbar --}}
		<div class="flex items-center w-full p-4 gap-8">
			<div class="flex items-center gap-2">
				<div class="bg-red-400 rounded-full size-3"></div>
				<div class="bg-yellow-400 rounded-full size-3"></div>
				<div class="bg-green-400 rounded-full size-3"></div>
			</div>
			
			<div class="flex items-center gap-2">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
					<path stroke-linecap="round"
					      stroke-linejoin="round"
					      d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
				</svg>
				<h2>
					phpxphilly.com
				</h2>
			</div>
			
			{{--
			<div class="ml-auto">
				<button class="flex gap-2 bg-emerald-600 rounded px-2 py-1 text-white font-semibold items-center">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
					</svg>
					Run Tests
				</button>
			</div>
			--}}
		</div>
		
		{{-- Files --}}
		<div class="border-t border-slate-200 dark:border-slate-700 px-4 py-2 flex gap-2 items-center opacity-60">
			phpxphilly
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 opacity-40">
				<path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
			</svg>
			newsletter.php
		</div>
		
		{{-- Editor --}}
		<form
			action="{{ route('newsletter-subscriber.store') }}"
			method="post"
			class="flex border-t border-slate-200 dark:border-slate-700"
		>
			@csrf
			<div class="hidden sm:block p-4 space-y-4 font-mono bg-white rounded-bl-lg dark:bg-slate-700 border-r border-slate-200 dark:border-slate-700 text-slate-200">
				@for($i = 1; $i < 9; $i++)
					<div>{{ $i }}</div>
				@endfor
			</div>
			<div class="flex-1 bg-white rounded-br-lg p-4 space-y-4 font-mono dark:bg-slate-800">
				@if(session()->has('message'))
					<div class="flex font-semibold">
						<span class="text-amber-500">response(</span>
						<span class="text-green-800 dark:text-slate-400">&quot;</span>
						<span class="text-purple-600 dark:text-purple-300">You're on the list!</span>
						<span class="text-green-800 dark:text-slate-400">&quot;</span>
						<span class="text-amber-500">)</span>
						<span class="text-slate-400 hidden sm:block">;</span>
					</div>
				@else
					<div class="text-slate-500">
						<span class="hidden sm:inline">// </span>
						<span class="sm:hidden">/* </span>
						<span>curious about our next upcoming meetup? </span>
						<span class="sm:hidden">Sign up for updates:</span>
						<span class="sm:hidden"> */</span>
					</div>
					<div class="text-slate-500 hidden sm:block">// sign up for updates:</div>
					<div class="text-slate-500 hidden sm:block">&nbsp;</div>
					
					<x-code-input name="full_name" label="my_name" />
					<x-code-input name="email" label="my_email" />
					
					<div class="text-slate-500">&nbsp;</div>
					<div class="text-slate-500 group flex items-center">
						<button type="submit" class="text-amber-500 font-semibold hover:text-red-800 dark:hover:text-white hover:underline">
							submit()
						</button>
						<span class="text-slate-500">;</span>
					</div>
				@endif
			</div>
		</form>
	</div>
</div>
