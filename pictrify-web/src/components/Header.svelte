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
	import logo from '$lib/images/logo-transparant-white.png';
	import type { Creator } from '$lib/types/creator';

	export let isAuthenticated = false;
	export let creator: Creator;
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
				<a href="/auth/login" class="btn btn-primary">Login</a>
			{/if}
			<NavHamburger on:click={toggle} class1="w-full md:flex md:w-auto md:order-1" />
			<DarkMode />
		</div>
		{#if isAuthenticated}
			<Dropdown placement="bottom" triggeredBy="#avatar-menu">
				<DropdownHeader>
					<span class="block text-sm"> {creator.getUsername()} </span>
					<span class="block truncate text-sm font-medium"> {creator.getEmail()} </span>
				</DropdownHeader>
				<DropdownItem>Dashboard</DropdownItem>
				<DropdownItem>Settings</DropdownItem>
				<DropdownItem>Earnings</DropdownItem>
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
			<NavLi href="/about">About</NavLi>
			<NavLi href="/services">Services</NavLi>
			<NavLi href="/pricing">Pricing</NavLi>
			<NavLi href="/contact">Contact</NavLi>
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
