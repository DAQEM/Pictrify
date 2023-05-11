<script>
	import { createEventDispatcher } from 'svelte';
	import RoundedButton from './RoundedButton.svelte';
	const dispatch = createEventDispatcher();

	let email = '';
	let password = '';

	function handleLogin() {}

	function handleClose() {
		dispatch('close');
	}
</script>

<div class="fixed z-10 inset-0 overflow-y-auto">
	<div
		class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
	>
		<!-- Background overlay -->
		<div class="fixed inset-0 transition-opacity" aria-hidden="true">
			<div class="absolute inset-0 bg-black opacity-50" />
		</div>

		<!-- Modal panel -->
		<div
			class="inline-block align-bottom bg-secondary rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
		>
			<div class="bg-secondary px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
				<div class="sm:flex sm:items-start">
					<!-- Modal title -->
					<h3 class="text-lg leading-6 font-medium text-t-light sm:mt-0 sm:mr-4 sm:text-left">
						Login to Pictrify
					</h3>
					<!-- Close button -->
					<button
						class="absolute top-0 right-0 mt-3 mr-3 text-tertiary hover:text-gray-900"
						type="button"
						on:click={handleClose}
					>
						<span class="sr-only">Close</span>
						<svg
							class="h-6 w-6"
							fill="none"
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path d="M6 18L18 6M6 6l12 12" />
						</svg>
					</button>
				</div>
				<!-- Modal content -->
				<div class="mt-5">
					<form>
						<div class="mb-4">
							<label class="block text-t-dark font-bold mb-1" for="email"> Email </label>
							<input
								class="appearance-none rounded w-full py-2 px-3 text-t-dark bg-tertiary leading-tight focus:outline-none focus:shadow-outline"
								id="email"
								type="email"
								placeholder="Enter email"
								bind:value={email}
							/>
						</div>
						<div class="mb-6">
							<label class="block text-t-dark font-bold mb-1" for="password"> Password </label>
							<input
								class="appearance-none rounded w-full py-2 px-3 text-t-dark bg-tertiary leading-tight focus:outline-none focus:shadow-outline"
								id="password"
								type="password"
								placeholder="Enter password"
								bind:value={password}
							/>
						</div>
						<div class="flex items-center justify-end">
							<RoundedButton
								className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
								onClick={handleLogin}
							>
								Login
							</RoundedButton>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
