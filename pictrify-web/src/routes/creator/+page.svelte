<script lang="ts">
	import { Creator } from '../../types/creator';
	import type { PageData } from './$types';

	export let data: PageData;
	let creators: Creator[];

	$: {
		creators = data.creators.map((json: any) => Creator.fromJson(json));
	}
</script>

<div>
	<h1>All Creators</h1>
	<div class="flex flex-wrap">
		{#each creators as creator}
			<a href="/creator/{creator.getId()}">
				<div class="bg-white m-3 p-3 rounded-lg text-center font-bold">
					<h2 class="font-bold">{creator.getUsername()}</h2>
					<p>Joined: {creator.getCreatedAt().toLocaleDateString()}</p>
				</div>
			</a>
		{/each}
	</div>
</div>
