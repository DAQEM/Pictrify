<script lang="ts">
	import Authentication from '../components/Authentication.svelte';
	import Header from '../components/Header.svelte';
	import './styles.css';
</script>

<div class="w-full flex flex-col justify-center">
	<Authentication>
		<div class="flex justify-center w-full bg-black">
			<div class="max-w-6xl w-full">
				<Header />
			</div>
		</div>
		<div>
			<main>
				<slot />
			</main>

			<footer>
				<p>visit <a href="https://kit.svelte.dev">kit.svelte.dev</a> to learn SvelteKit</p>
			</footer>
		</div>
	</Authentication>
</div>
