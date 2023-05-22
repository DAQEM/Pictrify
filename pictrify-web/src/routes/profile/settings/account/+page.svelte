<script lang="ts">
	import { Button, Input, Modal } from 'flowbite-svelte';
	import type { PageData } from './$types';
	import { Creator } from '$lib/types/creator';

	export let data: PageData;
	let viewer: Creator = Creator.fromJson(data.viewer);

	let usernameModalOpen = false;
	let emailModalOpen = false;

	let username = viewer.getUsername();
	let email = viewer.getEmail();

	const submitUsernameForm = () => {
		const form: HTMLFormElement = document.getElementById('username-form') as HTMLFormElement;
		form.submit();
	};
</script>

<div>
	<Modal title="Change username" bind:open={usernameModalOpen} class="max-w-xs">
		{#if !new RegExp('^[a-zA-Z0-9_]{2,16}$').test(username)}
			{#if username.length < 2}
				<p class="text-center">Username must be at least 2 characters long.</p>
			{:else if username.length > 16}
				<p class="text-center">Username must be at most 16 characters long.</p>
			{:else}
				<p class="text-center">Username can only contain letters, numbers and underscores.</p>
			{/if}
		{:else}
			<p class="text-center">Are you sure you want to change your username to:</p>
			<pre class="text-center text-primary bg-tertiary p-2 rounded-xl">{username}</pre>
			<div class="flex justify-center gap-4">
				<Button
					color="green"
					on:click={() => {
						submitUsernameForm;
					}}>Confirm</Button
				>
				<Button color="red" on:click={() => (usernameModalOpen = false)}>Cancel</Button>
			</div>
		{/if}
	</Modal>

	<Modal title="Change email" bind:open={emailModalOpen} class="max-w-xs">
		<p class="text-center">Are you sure you want to change your eamil to</p>
		<pre class="text-center text-primary bg-tertiary p-2 rounded-xl">{email}</pre>
		<div class="flex justify-center gap-4">
			<Button color="green">Confirm</Button>
			<Button color="red" on:click={() => (usernameModalOpen = false)}>Cancel</Button>
		</div>
	</Modal>

	<h1 class="text-primary text-2xl mb-1">Account settings</h1>
	<hr class="my-4 border-tertiary" />
	<div class="flex flex-col gap-8">
		<div>
			<h1 class="text-secondary text-xl mb-1">Username</h1>
			<form id="username-form" action="/auth/change/email" method="POST" class="flex gap-4">
				<Input
					placeholder="Username"
					name="username"
					bind:value={username}
					class="bg-tertiary max-w-[20rem]"
				/>
				<Button
					class="bg-tertiary"
					on:click={(event) => {
						event.preventDefault();
						usernameModalOpen = true;
					}}>Change</Button
				>
			</form>
		</div>
		<div>
			<h1 class="text-secondary text-xl mb-1">Email</h1>
			<form id="email-form" action="/auth/change/email" method="POST" class="flex gap-4">
				<Input
					placeholder="Email"
					name="email"
					type="email"
					bind:value={email}
					class="bg-tertiary max-w-[20rem]"
				/>
				<Button
					class="bg-tertiary"
					on:click={(event) => {
						event.preventDefault();
						emailModalOpen = true;
					}}>Change</Button
				>
			</form>
		</div>
		<div>
			<h1 class="text-secondary text-xl mb-1">Password</h1>
			<Button class="w-48" color="red">Change password</Button>
		</div>
	</div>
	<form action="/auth/change/username" method="POST" id="username-form">
		<input type="text" name="username" value={username} />
		<button type="submit">Submit</button>
	</form>
</div>
