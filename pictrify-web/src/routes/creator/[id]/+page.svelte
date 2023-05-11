<script lang="ts">
	import { getIsAuthenticatedValue } from 'sveltekit-auth0';
	import { Creator } from '../../../types/creator';
	import type { PageData } from './$types';

	export let data: PageData;
	let creator: Creator;

	$: {
		creator = Creator.fromJson(data.creator);
	}

	console.log(getIsAuthenticatedValue());
</script>

<div class="flex flex-col justify-center text-center">
	<h1>Creator {creator.getUsername()}</h1>
	<p>Joined: {creator.getCreatedAt().toLocaleDateString()}</p>
</div>
