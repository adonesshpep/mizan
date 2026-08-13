import './bootstrap';

const catalogRoot = document.querySelector('[data-catalog-root]');

if (catalogRoot) {
	const grid = catalogRoot.querySelector('[data-products-grid]');
	const sentinel = catalogRoot.querySelector('[data-load-more]');
	const status = catalogRoot.querySelector('[data-feed-status]');
	let nextPageUrl = catalogRoot.dataset.nextPageUrl || '';
	let loading = false;

	const escapeHtml = (value) => {
		const element = document.createElement('div');
		element.textContent = value ?? '';
		return element.innerHTML;
	};

	const buildCard = (product) => {
		const card = document.createElement('a');
		card.href = product.detail_url;
		card.className = 'group overflow-hidden rounded-[28px] border border-white/10 bg-white/6 shadow-[0_30px_80px_rgba(3,7,18,0.18)] backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-amber-300/60';
		card.innerHTML = `
			<div class="aspect-[4/3] overflow-hidden bg-slate-900">
				${product.thumbnail ? `<img src="${escapeHtml(product.thumbnail)}" alt="${escapeHtml(product.title)}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">` : '<div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-amber-300/40 to-slate-800 text-sm uppercase tracking-[0.3em] text-amber-50/70">No image</div>'}
			</div>
			<div class="space-y-3 p-5">
				<div class="flex items-start justify-between gap-4">
					<h3 class="text-lg font-semibold text-slate-950 dark:text-white">${escapeHtml(product.title)}</h3>
					<span class="rounded-full border border-amber-300/40 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.3em] text-amber-200">View</span>
				</div>
				<p class="line-clamp-3 text-sm leading-6 text-slate-600 dark:text-slate-300">${escapeHtml(product.description)}</p>
			</div>
		`;

		return card;
	};

	const setStatus = (message) => {
		if (status) {
			status.textContent = message;
		}
	};

	const loadMore = async () => {
		if (!nextPageUrl || loading) {
			return;
		}

		loading = true;
		setStatus('Loading more products...');

		try {
			const response = await fetch(nextPageUrl, {
				headers: {
					Accept: 'application/json',
				},
			});

			if (!response.ok) {
				throw new Error('Failed to load products');
			}

			const payload = await response.json();
			nextPageUrl = payload.next_page_url || '';

			payload.data.forEach((product) => {
				grid?.appendChild(buildCard(product));
			});

			if (!nextPageUrl && observer) {
				observer.disconnect();
				setStatus('You reached the end of the catalog.');
			} else {
				setStatus('Scroll to load more products.');
			}
		} catch (error) {
			setStatus('Unable to load more products right now.');
		} finally {
			loading = false;
		}
	};

	const observer = sentinel
		? new IntersectionObserver((entries) => {
			if (entries.some((entry) => entry.isIntersecting)) {
				loadMore();
			}
		}, {
			rootMargin: '400px',
		})
		: null;

	if (sentinel && observer) {
		observer.observe(sentinel);
	}
}
