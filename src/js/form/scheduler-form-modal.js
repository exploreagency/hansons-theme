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
				this.prepareModalPanels();
				this.observeWpFormsPages();
				this.bindKeyboardEvents();
				this.bindPageButtonEvents();
				this.syncModalState();
			});
		},

		prepareModalPanels() {
			this.movePageTwoControlsIntoPanel();
			this.wrapPageInPanel(3, 'scheduler-contact-panel');
			this.wrapPageInPanel(4, 'scheduler-confirmation-panel');
			this.moveSubmitContainerIntoConfirmationPanel();
			this.addModalCloseButtons();
		},

		movePageTwoControlsIntoPanel() {
			const pageTwo = this.getPage(2);

			if (!pageTwo) {
				return;
			}

			const modalPanel = pageTwo.querySelector('.scheduler-modal-panel');

			const pageBreakControls = pageTwo.querySelector(
				'.wpforms-pagebreak-left, .wpforms-pagebreak-center, .wpforms-pagebreak-right'
			);

			if (!modalPanel || !pageBreakControls) {
				return;
			}

			if (modalPanel.contains(pageBreakControls)) {
				return;
			}

			pageBreakControls.classList.add('scheduler-modal-panel__controls');
			modalPanel.appendChild(pageBreakControls);
		},

		wrapPageInPanel(pageNumber, panelClass) {
			const page = this.getPage(pageNumber);

			if (!page) {
				return;
			}

			let panel = page.querySelector(`:scope > .${panelClass}`);

			if (!panel) {
				panel = document.createElement('div');
				panel.className = panelClass;
				page.appendChild(panel);
			}

			const childrenToMove = Array.from(page.children).filter((child) => {
				return (
					child !== panel &&
					(
						child.classList.contains('wpforms-field') ||
						child.classList.contains('wpforms-pagebreak-left') ||
						child.classList.contains('wpforms-pagebreak-center') ||
						child.classList.contains('wpforms-pagebreak-right')
					)
				);
			});

			childrenToMove.forEach((child) => {
				panel.appendChild(child);
			});
		},

		moveSubmitContainerIntoConfirmationPanel() {
			const pageFour = this.getPage(4);

			if (!pageFour) {
				return;
			}

			const confirmationPanel = pageFour.querySelector('.scheduler-confirmation-panel');
			const submitContainer = this.form.querySelector('.wpforms-submit-container');

			if (!confirmationPanel || !submitContainer) {
				return;
			}

			if (confirmationPanel.contains(submitContainer)) {
				return;
			}

			submitContainer.classList.add('scheduler-confirmation-panel__submit');
			confirmationPanel.appendChild(submitContainer);
		},

		addModalCloseButtons() {
			const panels = [
				this.getPage(2)?.querySelector('.scheduler-modal-panel'),
				this.getPage(3)?.querySelector('.scheduler-contact-panel'),
				this.getPage(4)?.querySelector('.scheduler-confirmation-panel'),
			].filter(Boolean);

			panels.forEach((panel) => {
				if (panel.querySelector('.scheduler-modal-close')) {
					return;
				}

				const closeButton = document.createElement('button');

				closeButton.type = 'button';
				closeButton.className = 'scheduler-modal-close';
				closeButton.setAttribute('aria-label', 'Close modal');
				closeButton.innerHTML = '&times;';

				closeButton.addEventListener('click', (event) => {
					event.preventDefault();
					event.stopPropagation();

					this.closeToFirstStep();
				});

				panel.appendChild(closeButton);
			});
		},

		closeToFirstStep() {
			this.forceShowPage(1);
			this.forceHidePage(2);
			this.forceHidePage(3);
			this.forceHidePage(4);

			this.closeModalClasses();
			this.restoreFocus();
		},

		forceShowPage(pageNumber) {
			const page = this.getPage(pageNumber);

			if (!page) {
				return;
			}

			page.style.display = 'block';
			page.hidden = false;
			page.classList.remove('is-scheduler-modal-open');
		},

		forceHidePage(pageNumber) {
			const page = this.getPage(pageNumber);

			if (!page) {
				return;
			}

			page.style.display = 'none';
			page.hidden = false;
			page.classList.remove('is-scheduler-modal-open');

			if (pageNumber === 2) {
				page.classList.remove('is-out-of-service-area');
			}
		},

		observeWpFormsPages() {
			const pages = [
				this.getPage(2),
				this.getPage(3),
				this.getPage(4),
			].filter(Boolean);

			if (!pages.length) {
				return;
			}

			this.observer = new MutationObserver(() => {
				this.prepareModalPanels();
				this.syncModalState();
			});

			pages.forEach((page) => {
				this.observer.observe(page, {
					attributes: true,
					childList: true,
					subtree: false,
					attributeFilter: ['style', 'class', 'hidden'],
				});
			});
		},

		bindKeyboardEvents() {
			document.addEventListener('keydown', (event) => {
				if (event.key !== 'Escape') {
					return;
				}

				if (!this.getActiveModalPage()) {
					return;
				}

				this.closeToFirstStep();
			});
		},

		bindPageButtonEvents() {
			const pageOneNextButton = this.getPage(1)?.querySelector('.wpforms-page-next');
			const pageTwoNextButton = this.getPage(2)?.querySelector('.wpforms-page-next');
			const pageThreeNextButton = this.getPage(3)?.querySelector('.wpforms-page-next');

			const pageTwoPrevButton = this.getPage(2)?.querySelector('.wpforms-page-prev');
			const pageThreePrevButton = this.getPage(3)?.querySelector('.wpforms-page-prev');
			const pageFourPrevButton = this.getPage(4)?.querySelector('.wpforms-page-prev');

			if (pageOneNextButton) {
				pageOneNextButton.addEventListener('click', () => {
					this.previousActiveElement = document.activeElement;

					window.requestAnimationFrame(() => {
						this.prepareModalPanels();
						this.syncModalState();
						this.focusActiveModal();
					});
				});
			}

			[
				pageTwoNextButton,
				pageThreeNextButton,
				pageThreePrevButton,
				pageFourPrevButton,
			].forEach((button) => {
				if (!button) {
					return;
				}

				button.addEventListener('click', () => {
					window.requestAnimationFrame(() => {
						this.prepareModalPanels();
						this.syncModalState();
						this.focusActiveModal();
					});
				});
			});

			if (pageTwoPrevButton) {
				pageTwoPrevButton.addEventListener('click', () => {
					window.requestAnimationFrame(() => {
						this.closeToFirstStep();
					});
				});
			}
		},

		syncModalState() {
			const pages = [
				this.getPage(2),
				this.getPage(3),
				this.getPage(4),
			].filter(Boolean);

			const activePage = this.getActiveModalPage();

			pages.forEach((page) => {
				page.classList.toggle('is-scheduler-modal-open', page === activePage);
			});

			document.body.classList.toggle(
				'scheduler-modal-is-open',
				Boolean(activePage)
			);
		},

		closeModalClasses() {
			[2, 3, 4].forEach((pageNumber) => {
				const page = this.getPage(pageNumber);

				if (!page) {
					return;
				}

				page.classList.remove('is-scheduler-modal-open');

				if (pageNumber === 2) {
					page.classList.remove('is-out-of-service-area');
				}
			});

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
			const pageFour = this.getPage(4);
			const pageThree = this.getPage(3);
			const pageTwo = this.getPage(2);

			if (this.isWpFormsPageVisible(pageFour)) {
				return pageFour;
			}

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

			if (page.hidden) {
				return false;
			}

			if (page.style.display) {
				return page.style.display !== 'none';
			}

			const style = window.getComputedStyle(page);

			return style.display !== 'none';
		},
	};
}