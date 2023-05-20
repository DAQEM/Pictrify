<script lang="ts">
	import { Creator } from '../../../lib/types/creator';
	import type { PageData } from './$types';

	export let data: PageData;
	let creator = Creator.fromJson(data.creator);
</script>

<div class="flex max-w-7xl" style="margin: 1.5rem auto -1.5rem;">
	<div class="flex items-center gap-1 py-0 px-4 relative w-full">
		<img
			class="rounded-full w-24 h-24 outline outline-[6px] outline-white dark:outline-gray-800"
			src="https://i.imgur.com/ShL15rC.png"
			alt={creator.getUsername()}
			loading="eager"
		/>
		<h1 class="mb-4 ml-2 text-primary">{creator.getUsername()}</h1>
	</div>
</div>
<div class="flex justify-center w-full">
	<div id="profile" class="">
		<div id="user-profile" class="h-fit rounded-xl bg-secondary">
			<div class="p-5 pt-7">
				<div>
					<p class="text-secondary">Some creator details</p>
					<hr class="border-gray-400 dark:border-gray-500 my-3" />
					<p class="text-secondary">More creator details</p>
				</div>
			</div>
		</div>
		<div id="profile-content">
			<div id="content-filters" class="rounded-xl p-5 bg-secondary">
				<p class="text-secondary">Some cool filters</p>
			</div>
			<div id="content-photobooks" class="rounded-xl p-5 bg-secondary">
				<div class="flex gap-5">
					<div class="min-h-[8rem] min-w-[8rem]">
						<img
							src="https://images.unsplash.com/photo-1608848461950-0fe51dfc41cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8M3x8fGVufDB8fHx8fA%3D%3D"
							alt="photoalbum cover"
							class="h-32 w-32 object-cover object-left-top rounded-xl"
						/>
					</div>
					<div class="flex flex-col justify-between max-h-32">
						<div>
							<p class="text-primary text-2xl">Some cool Photoalbum</p>
							<span
								class="text-secondary"
								style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"
							>
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur maiores ipsa
								placeat accusamus soluta, dignissimos, voluptatem asperiores sunt id dolore aliquam,
								accusamus soluta, dignissimos, voluptatem asperiores sunt id dolore aliquam,
								accusamus soluta, dignissimos, voluptatem asperiores sunt id dolore aliquam,
								accusamus soluta, dignissimos, voluptatem asperiores sunt id dolore aliquam,
								doloremque quod cupiditate corporis expedita. Voluptatum animi voluptates enim.
							</span>
						</div>
						<div class="flex gap-5">
							<div class="bg-tertiary py-2 px-5 rounded-xl">Some stat</div>
							<div class="bg-tertiary py-2 px-5 rounded-xl">Some other stat</div>
							<div class="bg-tertiary py-2 px-5 rounded-xl">Some other stat</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	@media (min-width: 1024px) {
		#profile {
			-moz-column-gap: 0.75rem !important;
			column-gap: 2rem !important;
			grid-template-columns: 20rem 1fr !important;
			grid-template-areas: 'sidebar content' !important;
			margin: 0 auto !important;
			max-width: 80rem !important;
		}

		#user-profile {
			min-width: 20rem !important;
			width: 20rem !important;
		}

		#profile-content {
			max-width: 58rem !important;
			width: 1fr !important;
		}
	}

	#profile {
		display: grid;
	}

	#user-profile {
		display: block;
		grid-area: sidebar;
	}

	#profile-content {
		display: grid;
		row-gap: 2rem;
		grid-area: content;
	}
</style>
