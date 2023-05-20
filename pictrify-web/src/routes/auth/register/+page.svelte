<script lang="ts">
	import { Button, Input, Label, Alert } from 'flowbite-svelte';
	import Fa from 'svelte-fa/src/fa.svelte';
	import type { ActionData } from './$types';
	import { faCircleInfo } from '@fortawesome/free-solid-svg-icons';

	export let form: ActionData;
</script>

<div class="flex items-center mt-12 flex-col">
	<h1>Register</h1>
	{#if form?.message}
		<Alert color="red" dismissable>
			<div class="flex items-center">
				<Fa icon={faCircleInfo} class="mr-2" />
				<p>{form.message}</p>
			</div>
		</Alert>
	{/if}
	<form method="POST" action="/auth/register" class="w-full max-w-xs">
		<div class="mb-6">
			<Label for="username">Username</Label>
			<Input name="username" id="username" placeholder="Your username" value={form?.username} />
		</div>
		<div class="mb-6">
			<Label for="email">Email</Label>
			<Input
				name="email"
				id="email"
				type="email"
				placeholder="example@example.com"
				value={form?.email}
			/>
		</div>
		<div class="mb-6">
			<Label for="password">Password</Label>
			<Input name="password" id="password" type="password" placeholder="A very strong password" />
		</div>
		<Button type="submit" color="blue">Register</Button>
	</form>
</div>
