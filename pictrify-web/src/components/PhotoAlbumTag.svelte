<script lang="ts">
	import type { IconDefinition } from '@fortawesome/free-solid-svg-icons';
	import Fa from 'svelte-fa/src/fa.svelte';

	export let icon: IconDefinition;
	export let name: string;
</script>

<div class="bg-tertiary py-2 px-5 rounded-xl h-min">
	<div class="flex text-tertiary items-center">
		<div class="mr-2">
			<Fa {icon} />
		</div>
		<p>{name}</p>
	</div>
</div>
