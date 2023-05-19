<script>
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
		DarkMode
	} from 'flowbite-svelte';
	import logo from '$lib/images/logo-transparant-white.png';
	import { onMount } from 'svelte';

	onMount(() => {
		console.log(isDarkModeEnabled());
	});

	function isDarkModeEnabled() {
		return window.matchMedia('(prefers-color-scheme: dark)').matches;
	}
</script>

<header class="flex justify-center bg-white dark:bg-gray-900">
	<Navbar let:hidden let:toggle style="max-width: 1200px;">
		<NavBrand href="/">
			<img src={logo} class="mr-3 h-6 sm:h-9" alt="Pictrify Logo" />
		</NavBrand>
		<div class="flex gap-5 items-center md:order-2">
			<Avatar id="avatar-menu" src="/images/profile-picture-3.webp" />
			<NavHamburger on:click={toggle} class1="w-full md:flex md:w-auto md:order-1" />
			<DarkMode />
		</div>
		<Dropdown placement="bottom" triggeredBy="#avatar-menu">
			<DropdownHeader>
				<span class="block text-sm"> Bonnie Green </span>
				<span class="block truncate text-sm font-medium"> name@flowbite.com </span>
			</DropdownHeader>
			<DropdownItem>Dashboard</DropdownItem>
			<DropdownItem>Settings</DropdownItem>
			<DropdownItem>Earnings</DropdownItem>
			<DropdownDivider />
			<DropdownItem>Sign out</DropdownItem>
		</Dropdown>
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
				<DropdownItem>Sign out</DropdownItem>
			</Dropdown>
		</NavUl>
	</Navbar>
</header>
