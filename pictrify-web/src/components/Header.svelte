<script lang="ts">
	import {
		Navbar,
		NavBrand,
		NavLi,
		NavUl,
		NavHamburger,
		Avatar,
		Dropdown,
		DropdownItem,
		DropdownHeader,
		DropdownDivider,
		Chevron,
		DarkMode,
		Button
	} from 'flowbite-svelte';
	import lightModeLogo from '$lib/images/logo-transparant-black.png';
	import darkModeLogo from '$lib/images/logo-transparant-white.png';
	import type { Creator } from '$lib/types/creator';
	import Fa from 'svelte-fa/src/fa.svelte';
	import { faGear, faUserAlt } from '@fortawesome/free-solid-svg-icons';
	import { onMount } from 'svelte';

	export let isAuthenticated = false;
	export let creator: Creator;

	let logo = lightModeLogo;

	onMount(() => {
		const htmlTag = document.querySelector('html');

		if (htmlTag != null) {
			if (htmlTag.classList.contains('dark')) {
				logo = darkModeLogo;
			}
			const observer = new MutationObserver((mutationsList) => {
				for (const mutation of mutationsList) {
					if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
						const classList = htmlTag.classList;
						if (classList.contains('dark')) {
							logo = darkModeLogo;
						} else {
							logo = lightModeLogo;
						}
					}
				}
			});

			const observerOptions = {
				attributes: true,
				attributeFilter: ['class']
			};

			observer.observe(htmlTag, observerOptions);
		}
	});
</script>

<header class="flex justify-center bg-white dark:bg-gray-900">
	<Navbar let:hidden let:toggle style="max-width: 1200px;">
		<NavBrand href="/">
			<img src={logo} class="mr-3 h-6 sm:h-9" alt="Pictrify Logo" />
		</NavBrand>
		<div class="flex gap-5 items-center md:order-2">
			{#if isAuthenticated}
				<Avatar id="avatar-menu" src="https://i.imgur.com/ShL15rC.png" />
			{:else}
				<a href="/auth/login">Login</a>
				<Button href="/auth/register" color="blue">Register</Button>
			{/if}
			<NavHamburger on:click={toggle} class1="w-full md:flex md:w-auto md:order-1" />
			<DarkMode initialTheme="dark" />
		</div>
		{#if isAuthenticated}
			<Dropdown placement="bottom" triggeredBy="#avatar-menu">
				<DropdownHeader>
					<span class="block text-sm font-medium text-gray-600 dark:text-gray-100">
						{creator.getUsername()}
					</span>
					<span class="block truncate text-sm text-gray-400 dark:text-gray-300">
						{creator.getEmail()}
					</span>
				</DropdownHeader>
				<DropdownItem href="/profile">
					<span class="flex items-center text-gray-500 dark:text-gray-200">
						<Fa icon={faUserAlt} class="mr-2" />
						<span>Profile</span>
					</span>
				</DropdownItem>
				<DropdownItem href="/profile/settings">
					<span class="flex items-center text-gray-500 dark:text-gray-200">
						<Fa icon={faGear} class="mr-2" />
						<span>Settings</span>
					</span>
				</DropdownItem>
				<DropdownDivider />
				<form action="/auth/logout" method="POST" class="m-2">
					<Button type="submit" color="blue" class="w-full">Sign out</Button>
				</form>
			</Dropdown>
		{/if}
		<NavUl {hidden}>
			<NavLi href="/" active={true}>Home</NavLi>
			<NavLi id="nav-menu1" class="cursor-pointer">
				<Chevron aligned>Dropdown</Chevron>
			</NavLi>
			<NavLi href="/">About</NavLi>
			<NavLi href="/">Services</NavLi>
			<NavLi href="/">Pricing</NavLi>
			<NavLi href="/">Contact</NavLi>
			<Dropdown triggeredBy="#nav-menu1" class="w-44 z-20">
				<DropdownItem>Dashboard</DropdownItem>
				<DropdownItem>Settings</DropdownItem>
				<DropdownItem>Earnings</DropdownItem>
				<DropdownDivider />
				<form action="/auth/logout" method="POST">
					<Button color="blue">Sign out</Button>
				</form>
			</Dropdown>
		</NavUl>
	</Navbar>
</header>
