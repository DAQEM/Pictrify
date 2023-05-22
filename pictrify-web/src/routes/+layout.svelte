<script lang="ts">
	import Header from '../components/Header.svelte';
	import './styles.css';
	import Footer from '../components/Footer.svelte';
	import { page } from '$app/stores';
	import { Creator } from '$lib/types/creator';

	const isAuthenticated = $page.data.isAuthenticated;
	const viewer = $page.data.viewer;
</script>

<div class="w-full flex flex-col justify-center">
	<div>
		<Header isAuthenticated={isAuthenticated} viewer={Creator.fromJson(viewer)} />

		<main>
			<slot />
		</main>

		<Footer />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
	</div>
</div>
