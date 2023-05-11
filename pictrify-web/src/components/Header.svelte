<script>
	import logo from '$lib/images/logo-transparant-white.png';
	import RoundedButton from './RoundedButton.svelte';
	import LoginModal from '../components/LoginModal.svelte';
	import AiOutlineLogin from 'svelte-icons-pack/ai/AiOutlineLogin';

	let showModal = false;
</script>

<header class="flex justify-between p-4">
	{#if showModal}
		<LoginModal on:close={() => (showModal = false)} />
	{/if}

	<div class="h-8">
		<a class="h-8" href="/">
			<img class="h-8" src={logo} alt="Pictrify" />
		</a>
	</div>

	<RoundedButton icon={AiOutlineLogin} onClick={() => (showModal = true)}>Login</RoundedButton>
</header>
