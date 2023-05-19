<script lang="ts">
	import { onMount } from 'svelte';
	import Authentication from '../components/Authentication.svelte';
	import Header from '../components/Header.svelte';
	import './styles.css';
	import { initFlowbite } from 'flowbite';
	import Footer from '../components/Footer.svelte';

	onMount(() => {
		initFlowbite();
	});
</script>

<div class="w-full flex flex-col justify-center">
	<Authentication>
		<div>
			<Header />

			<main>
				<slot />
			</main>

			<Footer />
			<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
		</div>
	</Authentication>
</div>
