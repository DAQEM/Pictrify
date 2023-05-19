<script>
	import { Footer, FooterCopyright, FooterLinkGroup, FooterLink } from 'flowbite-svelte';
</script>

<Footer style="border-radius: 0">
	<FooterCopyright href="/" by="Flowbite™" year={2022} />
	<FooterLinkGroup
		ulClass="flex flex-wrap items-center mt-3 text-sm text-gray-500 dark:text-gray-400 sm:mt-0"
	>
		<FooterLink href="/">About</FooterLink>
		<FooterLink href="/">Privacy Policy</FooterLink>
		<FooterLink href="/">Licensing</FooterLink>
		<FooterLink href="/">Contact</FooterLink>
	</FooterLinkGroup>
</Footer>
