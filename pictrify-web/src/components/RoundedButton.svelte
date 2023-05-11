<script lang="ts">
	import Icon from 'svelte-icons-pack/Icon.svelte';

	export let icon: any = undefined;
	export let className: string = '';
	export let href: string = '/';
	export let onClick = () => {
		location.href = href;
	};
</script>

<button class="button {className}" on:click={onClick}>
	{#if icon != undefined}
		<Icon src={icon} className="h-5 w-5" />
	{/if}

	<div class="mx-2" style="transform: translateY(-2px);">
		<slot />
	</div>
</button>

<style>
	.button {
		background-color: var(--color-theme-1);
		border-radius: 20px;
		padding: 5px 5px;
		color: black;
		display: flex;
		align-items: center;
		justify-content: center;
	}
</style>
