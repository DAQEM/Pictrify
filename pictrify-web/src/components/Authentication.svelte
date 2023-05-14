<script lang="ts">
	import auth from '$lib/services/auth';
	import { isAuthenticated, user } from '$lib/stores/auth';
	import { onMount } from 'svelte';

	$: isLoading = true;

	onMount(async () => {
		let auth0Client = await auth.createClient();
		isAuthenticated.set(await auth0Client.isAuthenticated());
		user.set(await auth0Client.getUser());
		isLoading = false;
	});
</script>

{#if !isLoading}
	<slot />
{/if}
