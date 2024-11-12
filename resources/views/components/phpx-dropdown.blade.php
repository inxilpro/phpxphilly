<div class="flex justify-center">
	<div
		x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.$refs.button.focus()

                this.open = true
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            }
        }"
		x-on:keydown.escape.prevent.stop="close($refs.button)"
		x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
		x-id="['dropdown-button']"
		class="relative"
	>
		{{-- Button --}}
		<button
			x-ref="button"
			x-on:click="toggle()"
			:aria-expanded="open"
			:aria-controls="$id('dropdown-button')"
			type="button"
			class="flex items-center gap-2 bg-black border-2 border-white text-white font-mono font-bold"
		>
			<span class="px-2.5 py-1.5 pr-1">PHP<span class="inline-block ml-0.5">×</span></span>
			<span class="border-l-2 border-gray-200 bg-white text-black px-2.5 py-1.5 flex items-center">
				{{ str($group->name)->afterLast('×')->trim() }}
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" viewBox="0 0 20 20" fill="currentColor">
	                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
	            </svg>
			</span>
		</button>
		
		{{-- Panel --}}
		<div
			x-ref="panel"
			x-show="open"
			x-transition.origin.top.right
			x-on:click.outside="close($refs.button)"
			:id="$id('dropdown-button')"
			style="display: none;"
			class="absolute left-0 border-2 border-white mt-px w-full bg-black text-white font-mono font-bold"
		>
			@foreach($phpx_network as $domain => $group_name)
				<a
					href="{{ $domain === $group->domain ? url('/') : "https://{$domain}/" }}"
					class="border-t-2 border-white first-of-type:border-t-0 flex items-center justify-end gap-2 w-full px-4 py-2.5 text-right text-sm hover:bg-white hover:text-black"
				>
					<span class="whitespace-nowrap">
						{{ str($group_name)->after('×') }}
					</span>
					@if($domain === $group->domain)
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-5 h-5 fill-current">
							<path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
						</svg>
					@else
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 fill-current">
							<path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
						</svg>
					@endif
				</a>
			@endforeach
		</div>
	</div>
</div>
