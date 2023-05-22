<script lang="ts">
	import {
		faBook,
		faCalendar,
		faImage,
		faLocationPin,
		faUserPlus
	} from '@fortawesome/free-solid-svg-icons';
	import PhotoAlbumTag from '../../../components/PhotoAlbumTag.svelte';
	import { Creator } from '$lib/types/creator';
	import type { PageData } from './$types';
	import { onMount } from 'svelte';
	import Fa from 'svelte-fa/src/fa.svelte';
	import { PhotoAlbum } from '$lib/types/photo_album';

	export let data: PageData;
	let creator: Creator = Creator.fromJson(data.creator);
	let photoalbums: PhotoAlbum[] = data.photoAlbums.map((photoalbum: any) =>
		PhotoAlbum.fromJson(photoalbum)
	);

	onMount(() => {
		const bio = document.querySelector('.bio');
		if (bio != null) {
			if (bio.scrollHeight > 72) {
				const bioTitle = document.querySelector('.bio-title');
				if (bioTitle != null) {
					const span = `<span class="text-tertiary text-xs pb-[0.15rem]">Show more</span>`;
					bioTitle.innerHTML += span;
				}
			}
		}
	});

	const handleBioClick = () => {
		const bio = document.querySelector('.bio');
		if (bio != null) {
			bio.classList.toggle('bio-clamp');
		}
	};
</script>

<div class="mx-2">
	<div class="flex max-w-7xl" style="margin: 1.5rem auto -1.5rem;">
		<div class="flex items-center gap-1 py-0 px-4 relative w-full">
			<img
				class="rounded-full w-24 h-24 outline outline-[6px] outline-white dark:outline-gray-800"
				src="https://i.imgur.com/ShL15rC.png"
				alt={creator.getUsername()}
				loading="eager"
			/>
			<h1 class="mb-4 ml-2 text-primary text-4xl">{creator.getUsername()}</h1>
		</div>
	</div>
</div>
<div class="flex justify-center w-full">
	<div id="profile" class="m-2">
		<div id="user-profile" class="h-fit rounded-xl bg-secondary">
			<div class="p-6 pt-8">
				<div on:click={handleBioClick}>
					<div class="bio-title text-primary flex items-end gap-1">
						<p>Bio</p>
					</div>
					<p class="text-secondary bio bio-clamp">
						Hello there! I'm Kevin, a passionate photographer with an unyielding love for freezing
						moments in time and transforming
					</p>
				</div>
				<hr class="border-gray-400 dark:border-gray-500 my-3" />
				<div class="grid gap-y-2">
					<div class="flex items-end gap-2 text-primary">
						<Fa class="mb-[0.4rem]" icon={faBook} />
						<p class="text-2xl">11</p>
						<p class="text-secondary">Photobooks</p>
					</div>
					<div class="flex items-end gap-2 text-primary">
						<Fa class="mb-[0.4rem]" icon={faImage} />
						<p class="text-2xl">114</p>
						<p class="text-secondary">Photos</p>
					</div>
					<div class="flex items-end gap-2 text-primary">
						<Fa class="mb-[0.4rem]" icon={faUserPlus} />
						<p class="text-secondary">
							Joined {creator.getCreatedAt().toLocaleDateString('en-UK', {
								year: 'numeric',
								month: 'long',
								day: 'numeric'
							})}
						</p>
					</div>
				</div>
			</div>
		</div>
		<div id="profile-content" class="h-fit">
			<div class="rounded-xl p-5 bg-secondary">
				<p class="text-secondary">Some cool filters</p>
			</div>
			{#each photoalbums as photoalbum}
				<div class="photobook flex rounded-xl p-5 bg-secondary">
					<div class="photobook-image flex items-center">
						<img
							src="https://images.unsplash.com/photo-1608848461950-0fe51dfc41cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8M3x8fGVufDB8fHx8fA%3D%3D"
							alt="photoalbum cover"
							class="object-cover object-left-top rounded-xl"
						/>
					</div>
					<p class="photobook-title text-primary text-2xl">{photoalbum.getName()}</p>
					<span
						class="photobook-description text-secondary"
						style="display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden;"
					>
						{photoalbum.getDescription()}
					</span>
					<div class="photobook-tags flex flex-wrap">
						<PhotoAlbumTag icon={faImage} name="10 Images" />
						<PhotoAlbumTag icon={faLocationPin} name="Location" />
						<PhotoAlbumTag
							icon={faCalendar}
							name={photoalbum.getCreationDate().toLocaleDateString('en-UK', {
								year: 'numeric',
								month: 'long',
								day: 'numeric'
							})}
						/>
					</div>
				</div>
			{/each}
		</div>
	</div>
</div>

<style>
	@media (min-width: 1024px) {
		#profile {
			-moz-column-gap: 1rem !important;
			column-gap: 1rem !important;
			grid-template-columns: 20rem 1fr !important;
			grid-template-areas: 'sidebar content' !important;
			margin: 0 !important;
			max-width: 80rem !important;
			width: 100%;
		}

		#user-profile {
			min-width: 20rem !important;
			width: 20rem !important;
		}

		#profile-content {
			max-width: 58rem !important;
			width: 1fr !important;
			margin: 0 !important;
		}

		.photobook-description {
			min-height: 3rem;
		}
	}

	@media (max-width: 750px) {
		.photobook {
			grid-template-areas:
				'image title'
				'image description'
				'tags tags' !important;
			grid-template-columns: 6rem 1fr !important;
			grid-template-rows: min-content min-content min-content !important;
		}
		.photobook-image {
			width: 6rem !important;
			height: 6rem !important;
		}

		.photobook-image img {
			width: 6rem !important;
			height: 6rem !important;
		}

		.photobook-description {
			-webkit-line-clamp: 3 !important;
		}

		.photobook-tags {
			gap: 1rem !important;
		}
	}

	@media (max-width: 450px) {
		.photobook {
			grid-template-areas:
				'image title'
				'description description'
				'tags tags' !important;
			grid-template-columns: 4rem 1fr !important;
			grid-template-rows: min-content min-content min-content !important;
		}
		.photobook-image {
			width: 4rem !important;
			height: 4rem !important;
		}

		.photobook-image img {
			width: 4rem !important;
			height: 4rem !important;
		}

		.photobook-description {
			-webkit-line-clamp: 5 !important;
		}

		.photobook-tags {
			gap: 0.5rem !important;
		}
	}

	#profile {
		display: grid;
		grid-template-areas: 'sidebar' 'content';
	}

	#user-profile {
		display: block;
		grid-area: sidebar;
		width: 100%;
	}

	#profile-content {
		display: grid;
		row-gap: 1rem;
		grid-area: content;
		width: 100%;
		margin-top: 1rem;
	}

	.photobook {
		display: grid;
		grid-template-areas:
			'image title'
			'image description'
			'image tags';
		grid-template-columns: 8rem 1fr;
		grid-template-rows: min-content min-content 1fr;
		column-gap: 1rem;
	}

	.photobook-image {
		grid-area: image;
		width: 8rem;
		height: 8rem;
	}

	.photobook-image img {
		width: 8rem;
		height: 8rem;
	}

	.photobook-title {
		grid-area: title;
	}

	.photobook-description {
		grid-area: description;
		-webkit-line-clamp: 2;
		margin-bottom: 0.5rem;
	}

	.photobook-tags {
		grid-area: tags;
		gap: 1rem;
	}

	.bio-clamp {
		display: -webkit-box;
		-webkit-box-orient: vertical;
		overflow: hidden;
		-webkit-line-clamp: 3;
	}
</style>
