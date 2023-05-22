<script lang="ts">
	import { Creator } from '$lib/types/creator';
	import { faGear, faUser } from '@fortawesome/free-solid-svg-icons';
	import type { PageData } from './$types';
	import Fa from 'svelte-fa/src/fa.svelte';
	import { Button } from 'flowbite-svelte';
	import { page } from '$app/stores';

	export let data: PageData;
	let viewer: Creator = Creator.fromJson(data.viewer);
</script>

<div id="settings-wrapper" class="w-full p-2">
	<div id="settings-header-wrapper" class="flex justify-center p-8 px-0">
		<div id="settings-header" class="w-full max-w-7xl">
			<h1 class="text-3xl text-primary">Settings</h1>
		</div>
	</div>

	<div id="profile-grid-wrapper" class="flex justify-center">
		<div id="profile-grid" class="w-full max-w-7xl">
			<div id="profile-sidebar" class="flex gap-2">
				<div id="profile-image" class="w-16 h-16 rounded-full">
					<img
						src="https://i.imgur.com/ShL15rC.png"
						alt="profile"
						loading="eager"
						class="w-full h-full"
					/>
				</div>
				<div id="profile-info">
					<h1 class="text-primary text-2xl">{viewer.getUsername()}</h1>
					<h2 class="text-tertiary text-md">Your personal account</h2>
				</div>
			</div>
			<div id="profile-content" class="flex lg:justify-end justify-start">
				<Button href="/profile" class="h-fit bg-secondary p-2 px-4 rounded-xl lg:w-fit w-full"
					><p class="text-secondary text-md">Visit your profile</p></Button
				>
			</div>
		</div>
	</div>

	<div id="settings-grid-wrapper" class="flex justify-center">
		<div id="setting-grid" class="w-full max-w-7xl">
			<div id="setting-sidebar" class="rounded-xl bg-secondary p-5 h-fit text-secondary">
				<div class="flex flex-col gap-2">
					<Button
						href="/profile/settings"
						btnClass="flex items-end gap-2 py-2 px-4 rounded-md {$page.url.pathname ==
						'/profile/settings'
							? 'bg-tertiary'
							: ''}"
					>
						<Fa icon={faUser} class="mb-1" />
						<p>Profile</p>
					</Button>
					<Button
						href="/profile/settings/account"
						btnClass="flex items-end gap-2 py-2 px-4 rounded-md {$page.url.pathname ==
						'/profile/settings/account'
							? 'bg-tertiary'
							: ''}"
					>
						<Fa icon={faGear} class="mb-1" />
						<p>Account</p>
					</Button>
				</div>
			</div>
			<div id="setting-content" class="bg-secondary rounded-xl p-5 h-fit">
				<slot />
			</div>
		</div>
	</div>
</div>

<style>
	@media (max-width: 1024px) {
		#setting-grid {
			grid-template-columns: 1fr !important;
			grid-template-areas: 'sidebar' 'content' !important;
			row-gap: 1rem;
		}

		#profile-grid {
			grid-template-columns: 1fr !important;
			grid-template-areas: 'sidebar' 'content' !important;
			row-gap: 1rem;
		}
	}

	#setting-grid {
		display: grid;
		grid-template-columns: 20rem 1fr;
		grid-template-areas: 'sidebar content';
		column-gap: 1rem;
	}
	#setting-sidebar {
		grid-area: sidebar;
	}
	#setting-content {
		grid-area: content;
	}

	#profile-grid {
		display: grid;
		grid-template-columns: 20rem 1fr;
		grid-template-areas: 'sidebar content';
		column-gap: 1rem;
		margin-bottom: 1rem;
	}
	#profile-sidebar {
		grid-area: sidebar;
	}
	#profile-content {
		grid-area: content;
	}
</style>
