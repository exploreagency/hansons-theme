export default function schedulerFormModal() {
	return {
		form: null,
		observer: null,

		init() {
			this.form = this.$root.querySelector('.hero-scheduler-form');

			if (!this.form) {
				return;
			}

			this.$nextTick(() => {
				this.bindModalEvents();
				this.observeWpFormsPages();
				this.syncModalState();
			});
		},

		bindModalEvents() {
			document.addEventListener('keydown', (event) => {
				if (event.key !== 'Escape') {
					return;
				}

				if (!this.isModalOpen()) {
					return;
				}

				const activePage = this.getActiveModalPage();
				const previousButton = activePage
					? activePage.querySelector('.wpforms-page-prev')
					: null;

				if (previousButton) {
					previousButton.click();
				}
			});
		},

		observeWpFormsPages() {
			const pages = [
				this.getPage(2),
				this.getPage(3),
			].filter(Boolean);

			if (!pages.length) {
				return;
			}

			this.observer = new MutationObserver(() => {
				this.syncModalState();
			});

			pages.forEach((page) => {
				this.observer.observe(page, {
					attributes: true,
					attributeFilter: ['style', 'class'],
				});
			});
		},

		syncModalState() {
			const pageTwo = this.getPage(2);
			const pageThree = this.getPage(3);

			const pageTwoVisible = this.isWpFormsPageVisible(pageTwo);
			const pageThreeVisible = this.isWpFormsPageVisible(pageThree);

			if (pageTwo) {
				pageTwo.classList.toggle('is-scheduler-modal-open', pageTwoVisible);
			}

			if (pageThree) {
				pageThree.classList.toggle('is-scheduler-modal-open', pageThreeVisible);
			}

			document.body.classList.toggle(
				'scheduler-modal-is-open',
				pageTwoVisible || pageThreeVisible
			);
		},

		getPage(pageNumber) {
			return this.form.querySelector(`.wpforms-page-${pageNumber}`);
		},

		getActiveModalPage() {
			const pageThree = this.getPage(3);
			const pageTwo = this.getPage(2);

			if (this.isWpFormsPageVisible(pageThree)) {
				return pageThree;
			}

			if (this.isWpFormsPageVisible(pageTwo)) {
				return pageTwo;
			}

			return null;
		},

		isModalOpen() {
			return Boolean(this.getActiveModalPage());
		},

		isWpFormsPageVisible(page) {
			if (!page) {
				return false;
			}

			return window.getComputedStyle(page).display !== 'none';
		},
	};
}