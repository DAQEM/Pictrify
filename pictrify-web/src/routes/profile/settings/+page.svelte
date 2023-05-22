<script lang="ts">
	import { Textarea } from 'flowbite-svelte';
	import type { PageData } from './$types';
	import { Creator } from '$lib/types/creator';

	export let data: PageData;
	let viewer: Creator = Creator.fromJson(data.viewer);
</script>

<div>
	<h1 class="text-primary text-2xl mb-1">Profile settings</h1>
	<hr class="my-4 border-tertiary" />
	<h1 class="text-secondary text-xl mb-1">Biography</h1>
	<Textarea placeholder="Biography" value={viewer.getBiography()} class="bg-tertiary" />
</div>
