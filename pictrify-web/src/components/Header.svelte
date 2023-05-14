<script lang="ts">
	import logo from '$lib/images/logo-transparant-white.png';
	import AiOutlineLogin from 'svelte-icons-pack/ai/AiOutlineLogin';
	import RoundedButton from './RoundedButton.svelte';

	import auth from '$lib/services/auth';
	import { isAuthenticated } from '$lib/stores/auth';
	import type { Auth0Client } from '@auth0/auth0-spa-js';
	import { onMount } from 'svelte';

	let auth0Client: Auth0Client;

	onMount(async () => {
		auth0Client = await auth.createClient();
	});

	function login() {
		auth.loginWithPopup(auth0Client);
	}

	function logout() {
		auth.logout(auth0Client);
	}
</script>

<header class="flex justify-between p-4">
	<div class="h-8">
		<a class="h-8" href="/">
			<img class="h-8" src={logo} alt="Pictrify" />
		</a>
	</div>
	<div>
		<a href="/creator">Creators</a>
	</div>

	{#if $isAuthenticated}
		<RoundedButton icon={AiOutlineLogin} onClick={logout}>Logout</RoundedButton>
	{:else}
		<RoundedButton icon={AiOutlineLogin} onClick={login}>Login</RoundedButton>
	{/if}
</header>
