<?php ?>
<div x-on:keydown.right.prevent="$focus.wrap().next()" x-on:keydown.left.prevent="$focus.wrap().previous()"
	class="mx-[5%] md:mx-[20%] flex justify-center gap-2 overflow-x-auto border-b border-neutral-300" role="tablist"
	aria-label="tab options">
	<button x-on:click="selectedTab = 'categories'" x-bind:aria-selected="selectedTab === 'categories'"
		x-bind:tabindex="selectedTab === 'categories' ? '0' : '-1'"
		x-bind:class="selectedTab === 'categories' ? 'font-bold text-primary border-b-2 border-primary ' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
		class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelGroups">Categories</button>
	<button x-on:click="selectedTab = 'uni'" x-bind:aria-selected="selectedTab === 'uni'"
		x-bind:tabindex="selectedTab === 'uni' ? '0' : '-1'"
		x-bind:class="selectedTab === 'uni' ? 'font-bold text-primary border-b-2 border-primary' : 'text-neutral-600 font-medium hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900'"
		class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelLikes">Universities</button>
</div>