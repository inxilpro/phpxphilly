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
				Philly
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
			<a href="{{ url('/') }}" class="border-t-2 border-white first-of-type:border-t-0 flex items-center justify-end gap-2 w-full px-4 py-2.5 text-right text-sm hover:bg-white hover:text-black">
				Philly
			</a>
			<a href="https://phpxnyc.com/" target="_blank" class="border-t-2 border-white first-of-type:border-t-0 flex items-center justify-end gap-2 w-full px-4 py-2.5 text-right text-sm hover:bg-white hover:text-black">
				NYC
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
					<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
				</svg>
			</a>
		</div>
	</div>
</div>
