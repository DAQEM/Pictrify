<script lang="ts">
	import { Button, Input, Label, Alert } from 'flowbite-svelte';
	import Fa from 'svelte-fa/src/fa.svelte';
	import type { ActionData } from './$types';
	import { faCircleInfo } from '@fortawesome/free-solid-svg-icons';

	export let form: ActionData;
</script>

<div class="flex items-center mt-12 flex-col">
	<h1>Login</h1>
	{#if form?.username}
		<Alert color="red" dismissable>
			<div class="flex items-center">
				<Fa icon={faCircleInfo} class="mr-2" />
				<p>Incorrect username or password.</p>
			</div>
		</Alert>
	{/if}
	<form method="POST" action="/auth/login" class="w-full max-w-xs">
		<div class="mb-6">
			<Label for="username">Username</Label>
			<Input name="username" id="username" placeholder="Username" value={form?.username} />
		</div>
		<div class="mb-6">
			<Label for="password">Password</Label>
			<Input name="password" id="password" type="password" placeholder="Password" />
		</div>
		<Button type="submit" color="blue">Login</Button>
	</form>
</div>
