<script lang="ts">
	import { Creator } from '../../../types/creator';
	import type { PageData } from './$types';

	export let data: PageData;
	let creator: Creator;

	$: {
		creator = Creator.fromJson(data.creator);
	}
</script>

<div class="flex flex-col justify-center text-center">
	<h1>Creator {creator.getUsername()}</h1>
	<p>Joined: {creator.getCreatedAt().toLocaleDateString()}</p>
</div>
