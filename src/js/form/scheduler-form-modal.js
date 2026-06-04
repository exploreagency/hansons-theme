export default function schedulerFormModal() {
	return {
		form: null,
		observer: null,
		previousActiveElement: null,

		init() {
			this.form = this.$root.querySelector('.hero-scheduler-form');

			if (!this.form) {
				return;
			}

			this.$nextTick(() => {
				this.movePageTwoControlsIntoPanel();
				this.observeWpFormsPages();
				this.bindKeyboardEvents();
				this.bindPageButtonEvents();
				this.syncModalState();
			});
		},

		movePageTwoControlsIntoPanel() {
			const pageTwo = this.getPage(2);

			if (!pageTwo) {
				return;
			}

			const modalPanel = pageTwo.querySelector('.scheduler-modal-panel');
			const pageBreakControls = pageTwo.querySelector(':scope > .wpforms-pagebreak-left');

			if (!modalPanel || !pageBreakControls) {
				return;
			}

			if (modalPanel.contains(pageBreakControls)) {
				return;
			}

			pageBreakControls.classList.add('scheduler-modal-panel__controls');
			modalPanel.appendChild(pageBreakControls);
		},

		observeWpFormsPages() {
			const pages = [this.getPage(2), this.getPage(3)].filter(Boolean);

			if (!pages.length) {
				return;
			}

			this.observer = new MutationObserver(() => {
				this.syncModalState();
			});

			pages.forEach((page) => {
				this.observer.observe(page, {
					attributes: true,
					attributeFilter: ['style', 'class', 'hidden'],
				});
			});
		},

		bindKeyboardEvents() {
			document.addEventListener('keydown', (event) => {
				if (event.key !== 'Escape') {
					return;
				}

				const activePage = this.getActiveModalPage();

				if (!activePage) {
					return;
				}

				const previousButton = activePage.querySelector('.wpforms-page-prev');

				if (previousButton) {
					previousButton.click();
					return;
				}

				this.closeModalClasses();
			});
		},

		bindPageButtonEvents() {
			const pageOneNextButton = this.getPage(1)
				? this.getPage(1).querySelector('.wpforms-page-next')
				: null;

			const pageTwoNextButton = this.getPage(2)
				? this.getPage(2).querySelector('.wpforms-page-next')
				: null;

			const pageTwoPrevButton = this.getPage(2)
				? this.getPage(2).querySelector('.wpforms-page-prev')
				: null;

			const pageThreePrevButton = this.getPage(3)
				? this.getPage(3).querySelector('.wpforms-page-prev')
				: null;

			if (pageOneNextButton) {
				pageOneNextButton.addEventListener('click', () => {
					this.previousActiveElement = document.activeElement;

					window.requestAnimationFrame(() => {
						this.movePageTwoControlsIntoPanel();
						this.syncModalState();
						this.focusActiveModal();
					});
				});
			}

			if (pageTwoNextButton) {
				pageTwoNextButton.addEventListener('click', () => {
					window.requestAnimationFrame(() => {
						this.syncModalState();
						this.focusActiveModal();
					});
				});
			}

			if (pageTwoPrevButton) {
				pageTwoPrevButton.addEventListener('click', () => {
					window.requestAnimationFrame(() => {
						this.syncModalState();
						this.restoreFocus();
					});
				});
			}

			if (pageThreePrevButton) {
				pageThreePrevButton.addEventListener('click', () => {
					window.requestAnimationFrame(() => {
						this.syncModalState();
						this.focusActiveModal();
					});
				});
			}
		},

		syncModalState() {
			const pageTwo = this.getPage(2);
			const pageThree = this.getPage(3);

			const pageTwoVisible = this.isWpFormsPageVisible(pageTwo);
			const pageThreeVisible = this.isWpFormsPageVisible(pageThree);

			if (pageTwo) {
				pageTwo.classList.toggle(
					'is-scheduler-modal-open',
					pageTwoVisible && !pageThreeVisible
				);
			}

			if (pageThree) {
				pageThree.classList.toggle('is-scheduler-modal-open', pageThreeVisible);
			}

			document.body.classList.toggle(
				'scheduler-modal-is-open',
				pageTwoVisible || pageThreeVisible
			);
		},

		closeModalClasses() {
			const pageTwo = this.getPage(2);
			const pageThree = this.getPage(3);

			if (pageTwo) {
				pageTwo.classList.remove('is-scheduler-modal-open');
			}

			if (pageThree) {
				pageThree.classList.remove('is-scheduler-modal-open');
			}

			document.body.classList.remove('scheduler-modal-is-open');
		},

		focusActiveModal() {
			const activePage = this.getActiveModalPage();

			if (!activePage) {
				return;
			}

			activePage.setAttribute('tabindex', '-1');
			activePage.focus({ preventScroll: true });
		},

		restoreFocus() {
			if (
				this.previousActiveElement &&
				typeof this.previousActiveElement.focus === 'function'
			) {
				this.previousActiveElement.focus({ preventScroll: true });
			}
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

		isWpFormsPageVisible(page) {
			if (!page) {
				return false;
			}

			if (page.style.display) {
				return page.style.display === 'block';
			}

			const style = window.getComputedStyle(page);

			return style.display !== 'none' && !page.hidden;
		},
	};
}